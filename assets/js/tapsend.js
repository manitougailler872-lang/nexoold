/**
 * Page « Effectuer un virement ».
 */

/* ------------------------------------------------------------------ *
 *  Montant en toutes lettres (français)
 * ------------------------------------------------------------------ */

const UNITS = [
    'zéro', 'un', 'deux', 'trois', 'quatre', 'cinq', 'six', 'sept', 'huit', 'neuf',
    'dix', 'onze', 'douze', 'treize', 'quatorze', 'quinze', 'seize',
    'dix-sept', 'dix-huit', 'dix-neuf',
];

const TENS = ['', '', 'vingt', 'trente', 'quarante', 'cinquante', 'soixante', 'soixante', 'quatre-vingt', 'quatre-vingt'];

/**
 * Convertit 0–999 en lettres.
 *
 * Gère les particularités françaises : « soixante-dix » et « quatre-vingt-dix »
 * se construisent sur la dizaine précédente, « et un » s'emploie à 21/31/…/71
 * mais pas à 81 ni 91.
 *
 * @param {number} n
 * @param {boolean} beforeMille  vrai si le groupe précède « mille ».
 *   « cent » et « vingt » restent alors invariables — on écrit « deux cent
 *   mille » et « quatre-vingt mille », mais « deux cents millions » et
 *   « quatre-vingts millions », million et milliard étant des noms.
 */
function belowThousand(n, beforeMille = false) {
    if (n < 20) return UNITS[n];

    if (n < 100) {
        const ten = Math.floor(n / 10);
        const unit = n % 10;

        // 70–79 et 90–99 comptent au-delà de 16 sur la dizaine inférieure.
        if (ten === 7 || ten === 9) {
            const base = TENS[ten];
            const rest = 10 + unit;
            // « soixante et onze » : la conjonction s'écrit sans traits
            // d'union en orthographe traditionnelle, seul usage admis sur
            // les documents bancaires.
            const link = ten === 7 && unit === 1 ? ' et ' : '-';
            return base + link + UNITS[rest];
        }

        if (unit === 0) {
            // « quatre-vingts » prend un s sauf devant « mille ».
            return ten === 8 && !beforeMille ? 'quatre-vingts' : TENS[ten];
        }

        const link = unit === 1 && ten !== 8 ? ' et ' : '-';
        return TENS[ten] + link + UNITS[unit];
    }

    const hundreds = Math.floor(n / 100);
    const rest = n % 100;
    // « cent » s'accorde seulement s'il termine le nombre et n'annonce pas « mille ».
    const plural = rest === 0 && !beforeMille ? 's' : '';
    const prefix = hundreds === 1 ? 'cent' : `${UNITS[hundreds]} cent${plural}`;

    return rest === 0 ? prefix : `${prefix} ${belowThousand(rest, beforeMille)}`;
}

const SCALES = [
    { value: 1e9, singular: 'milliard', plural: 'milliards' },
    { value: 1e6, singular: 'million', plural: 'millions' },
    { value: 1e3, singular: 'mille', plural: 'mille' },
];

function integerToWords(n) {
    if (n === 0) return 'zéro';

    let rest = n;
    const parts = [];

    for (const scale of SCALES) {
        const count = Math.floor(rest / scale.value);
        if (count === 0) continue;

        rest %= scale.value;

        // « mille » est invariable et ne se dit pas « un mille ».
        if (scale.value === 1e3 && count === 1) {
            parts.push('mille');
        } else {
            parts.push(`${belowThousand(count, scale.value === 1e3)} ${count > 1 ? scale.plural : scale.singular}`);
        }
    }

    if (rest > 0) parts.push(belowThousand(rest));

    return parts.join(' ');
}

/**
 * @param {number} amount montant, centimes compris
 * @returns {string} ex. « mille deux cent cinquante euros »
 */
export function amountToWords(amount) {
    if (!Number.isFinite(amount) || amount < 0) return '';

    const euros = Math.floor(amount);
    const cents = Math.round((amount - euros) * 100);

    const eurosWords = integerToWords(euros);

    // « un million d'euros », pas « un million euros » : après million ou
    // milliard employés seuls, le complément se construit avec « de ».
    const endsWithScale = /(millions?|milliards?)$/.test(eurosWords);
    const unit = euros > 1 ? 'euros' : 'euro';
    const eurosPart = endsWithScale ? `${eurosWords} d'${unit}` : `${eurosWords} ${unit}`;

    if (cents === 0) return eurosPart;

    return `${eurosPart} et ${integerToWords(cents)} ${cents > 1 ? 'centimes' : 'centime'}`;
}

/* ------------------------------------------------------------------ *
 *  Initialisation de la page
 * ------------------------------------------------------------------ */

export function initTransferForm() {
    const form = document.querySelector('[data-transfer-form]');
    if (!form) return;

    const field = (name) => form.querySelector(`[name="${name}"]`);

    /* ---------- Montant en toutes lettres ---------- */
    const amountInput = field('amount');
    const amountWords = form.querySelector('[data-amount-words]');

    function refreshWords() {
        if (!amountInput || !amountWords) return;

        // La saisie française utilise la virgule décimale ; on retire aussi
        // les espaces de milliers avant de parser.
        const raw = amountInput.value.replace(/\s/g, '').replace(',', '.');
        const value = Number.parseFloat(raw);

        amountWords.textContent = Number.isFinite(value) && value > 0
            ? `Montant en toutes lettres : ${amountToWords(value)}`
            : 'Montant en toutes lettres : —';
    }

    amountInput?.addEventListener('input', refreshWords);
    refreshWords();

    /* ---------- Compteur du motif ---------- */
    const reason = field('reason');
    const counter = form.querySelector('[data-reason-counter]');
    const max = Number(reason?.getAttribute('maxlength')) || 140;

    function refreshCounter() {
        if (!reason || !counter) return;
        counter.textContent = `${reason.value.length} / ${max}`;
    }

    reason?.addEventListener('input', refreshCounter);
    refreshCounter();

    /* ---------- Type de virement ---------- */
    const dateBlock = form.querySelector('[data-execution-date]');
    const dateInput = field('executionDate');

    function refreshType() {
        const selected = form.querySelector('input[name="transferType"]:checked')?.value;
        const needsDate = selected === 'scheduled' || selected === 'recurring';

        if (dateBlock) dateBlock.hidden = !needsDate;

        // Un champ masqué ne doit pas rester obligatoire, sinon la validation
        // native bloque l'envoi sur un champ que l'utilisateur ne voit pas.
        if (dateInput) {
            dateInput.required = needsDate;
            dateInput.disabled = !needsDate;
        }
    }

    form.querySelectorAll('input[name="transferType"]').forEach((radio) => {
        radio.addEventListener('change', refreshType);
    });
    refreshType();

    /* ---------- Reflet du bénéficiaire choisi ---------- */
    /*
       Le <select> natif est invisible (il recouvre la carte) : c'est lui qui
       porte l'état, mais l'utilisateur lit la carte. Il faut donc répercuter
       la sélection sur les éléments affichés.
    */
    const beneficiarySelect = field('beneficiary');

    beneficiarySelect?.addEventListener('change', () => {
        const option = beneficiarySelect.selectedOptions[0];
        if (!option) return;

        const set = (selector, value) => {
            const el = form.querySelector(selector);
            if (el) el.textContent = value;
        };

        set('[data-beneficiary-name]', option.textContent.trim());
        set('[data-beneficiary-iban]', option.dataset.iban || '');
        set('[data-beneficiary-initials]', option.dataset.initials || '');
    });

    /* ---------- Reflet du compte débiteur choisi ---------- */
    const accountSelect = field('debitAccount');

    accountSelect?.addEventListener('change', () => {
        const option = accountSelect.selectedOptions[0];
        if (!option) return;
        // Le solde de référence suit le compte sélectionné.
        form.dataset.availableBalance = option.dataset.balance || '0';
    });

    /* ---------- Garde-fou : solde insuffisant ---------- */

    const submit = form.querySelector('[data-transfer-submit]');
    const balanceError = form.querySelector('[data-balance-error]');

    form.addEventListener('submit', (event) => {
        const raw = amountInput.value.replace(/\s/g, '').replace(',', '.');
        const value = Number.parseFloat(raw);

        if (!Number.isFinite(value) || value <= 0) {
            event.preventDefault();
            amountInput.classList.add('is-invalid');
            amountInput.focus();
            return;
        }

        const balance = Number(form.dataset.availableBalance || 0);

        if (balance > 0 && value > balance) {
            event.preventDefault();
            amountInput.classList.add('is-invalid');
            if (balanceError) {
                balanceError.hidden = false;
                balanceError.textContent = 'Le montant dépasse le solde disponible du compte débiteur.';
            }
            amountInput.focus();
            return;
        }

        amountInput.classList.remove('is-invalid');
        if (balanceError) balanceError.hidden = true;

        // Évite le double envoi sur double-clic.
        if (submit) {
            submit.disabled = true;
            submit.dataset.busy = 'true';
        }
    });
}
