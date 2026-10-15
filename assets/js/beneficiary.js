import { openModal, closeModal } from './modal.js';

/* ------------------------------------------------------------------ *
 *  Validation IBAN — contrôle mod 97 (norme ISO 13616)
 * ------------------------------------------------------------------ */

/**
 * Le mod 97 rattrape la quasi-totalité des fautes de frappe et des
 * interversions de chiffres. Le faire côté client évite un aller-retour
 * serveur pour une erreur de saisie — mais il ne remplace PAS la contrainte
 * Assert\Iban côté Symfony : tout ce qui vient du navigateur est falsifiable.
 */
export function isValidIban(raw) {
    const iban = String(raw).replace(/\s+/g, '').toUpperCase();

    if (!/^[A-Z]{2}\d{2}[A-Z0-9]{10,30}$/.test(iban)) return false;

    // Les 4 premiers caractères passent à la fin, les lettres deviennent
    // des nombres (A=10 … Z=35), puis on vérifie que le reste vaut 1.
    const rearranged = iban.slice(4) + iban.slice(0, 4);
    const digits = rearranged.replace(/[A-Z]/g, (c) => c.charCodeAt(0) - 55);

    // Division par tranches : le nombre dépasse la précision d'un Number.
    let remainder = 0;
    for (const digit of digits) {
        remainder = (remainder * 10 + Number(digit)) % 97;
    }

    return remainder === 1;
}

const isValidBic = (raw) => /^[A-Z]{6}[A-Z0-9]{2}([A-Z0-9]{3})?$/.test(String(raw).replace(/\s+/g, '').toUpperCase());

const formatIban = (raw) => String(raw).replace(/\s+/g, '').toUpperCase().replace(/(.{4})/g, '$1 ').trim();

/* ------------------------------------------------------------------ *
 *  Menus d'action : visualiser / éditer / supprimer
 * ------------------------------------------------------------------ */

export function initBeneficiaryActions() {
    // --- Visualiser ---
    const viewModal = document.getElementById('beneficiary-view-modal');

    document.querySelectorAll('[data-beneficiary-view]').forEach((trigger) => {
        trigger.addEventListener('click', (event) => {
            event.preventDefault();
            if (!viewModal) return;

            const d = trigger.dataset;
            const set = (key, value) => {
                const el = viewModal.querySelector(`[data-field="${key}"]`);
                if (el) el.textContent = value || '—';
            };

            set('name', d.bName);
            set('iban', d.bIban);
            set('bic', d.bBic);
            set('bank', d.bBank);
            set('country', d.bCountry);
            set('status', d.bStatus);
            set('created', d.bCreated);

            const editLink = viewModal.querySelector('[data-action="edit"]');
            if (editLink && d.bEditUrl) editLink.href = d.bEditUrl;

            openModal(viewModal, trigger);
        });
    });

    // --- Supprimer ---
    const deleteModal = document.getElementById('beneficiary-delete-modal');

    document.querySelectorAll('[data-beneficiary-delete]').forEach((trigger) => {
        trigger.addEventListener('click', (event) => {
            event.preventDefault();
            if (!deleteModal) return;

            const d = trigger.dataset;
            const nameEl = deleteModal.querySelector('[data-field="name"]');
            const ibanEl = deleteModal.querySelector('[data-field="iban"]');
            const form = deleteModal.querySelector('form');

            if (nameEl) nameEl.textContent = d.bName || '';
            if (ibanEl) ibanEl.textContent = d.bIban || '';

            if (form) {
                // L'URL et le jeton viennent du serveur, portés par le
                // déclencheur : le JS ne fabrique aucune URL de suppression.
                form.action = d.bDeleteUrl || '';
                const token = form.querySelector('input[name="_token"]');
                if (token) token.value = d.bToken || '';
            }

            openModal(deleteModal, trigger);
        });
    });
}

/* ------------------------------------------------------------------ *
 *  Assistant d'ajout : pays → banque → informations → récapitulatif
 * ------------------------------------------------------------------ */

export function initBeneficiaryWizard() {
    const modal = document.getElementById('beneficiary-add-modal');
    if (!modal) return;

    const form = modal.querySelector('form');
    const steps = Array.from(modal.querySelectorAll('[data-step]'));
    const dots = Array.from(modal.querySelectorAll('[data-step-dot]'));
    const bars = Array.from(modal.querySelectorAll('[data-step-bar]'));
    const btnBack = modal.querySelector('[data-wizard-back]');
    const btnNext = modal.querySelector('[data-wizard-next]');
    const btnSubmit = modal.querySelector('[data-wizard-submit]');

    let banks = [];
    try {
        banks = JSON.parse(modal.dataset.banks || '[]');
    } catch (e) {
        console.error('Liste des banques illisible', e);
    }

    let current = 1;
    const total = steps.length;

    /*
       Accès aux champs par sélecteur explicite, jamais par `form.nomDuChamp`.

       L'accès nommé est shadowé par les propriétés natives de HTMLFormElement
       (action, method, target, submit, reset, length, name…) : un champ appelé
       « action » renverrait l'URL du formulaire au lieu de l'input, sans la
       moindre erreur. Certaines implémentations ne l'exposent d'ailleurs pas
       du tout.
    */
    const field = (name) => form.querySelector(`[name="${name}"]`);

    /* ---------- Navigation ---------- */

    function render() {
        steps.forEach((s) => {
            s.hidden = Number(s.dataset.step) !== current;
        });

        dots.forEach((dot) => {
            const n = Number(dot.dataset.stepDot);
            dot.classList.toggle('is-current', n === current);
            dot.classList.toggle('is-done', n < current);
        });

        bars.forEach((bar) => {
            bar.classList.toggle('is-done', Number(bar.dataset.stepBar) < current);
        });

        btnBack.hidden = current === 1;
        btnNext.hidden = current === total;
        btnSubmit.hidden = current !== total;

        // Optionnel : certains environnements de test n'implémentent pas scrollTo.
        modal.querySelector('.modal-body')?.scrollTo?.({ top: 0 });
    }

    function go(step) {
        current = Math.max(1, Math.min(step, total));
        if (current === total) buildRecap();
        render();
    }

    /* ---------- Étape 1 : pays ---------- */

    function selectedCountry() {
        return form.querySelector('input[name="country"]:checked');
    }

    form.querySelectorAll('input[name="country"]').forEach((radio) => {
        radio.addEventListener('change', () => {
            renderBanks(radio.value);
            // Changer de pays invalide la banque déjà choisie.
            form.querySelectorAll('input[name="bank"]').forEach((b) => { b.checked = false; });
        });
    });

    /* ---------- Étape 2 : banque ---------- */

    const bankList = modal.querySelector('[data-bank-list]');
    const bankEmpty = modal.querySelector('[data-bank-empty]');

    function renderBanks(countryCode) {
        if (!bankList) return;

        const matches = banks.filter((b) => b.country === countryCode);
        bankList.innerHTML = '';

        if (matches.length === 0) {
            bankList.hidden = true;
            if (bankEmpty) bankEmpty.hidden = false;
            return;
        }

        bankList.hidden = false;
        if (bankEmpty) bankEmpty.hidden = true;

        matches.forEach((bank, index) => {
            const id = `bank-${countryCode}-${index}`;
            const wrapper = document.createElement('div');

            wrapper.innerHTML = `
                <input type="radio" name="bank" id="${id}" class="peer sr-only"
                       value="" data-bic="" data-prefix="">
                <label for="${id}" class="choice-card">
                    <span class="bank-logo" style="background-color: ${bank.color}"></span>
                    <span class="min-w-0">
                        <span class="block text-sm font-bold"></span>
                        <span class="block text-xs text-ink-3 tnum mt-0.5"></span>
                    </span>
                </label>`;

            // Les valeurs passent par des propriétés, jamais par interpolation
            // HTML : un nom de banque contenant une apostrophe casserait le
            // balisage, et un champ non assaini ouvrirait une injection.
            const input = wrapper.querySelector('input');
            input.value = bank.name;
            input.dataset.bic = bank.bic || '';
            input.dataset.prefix = bank.prefix || '';

            const [nameEl, bicEl] = wrapper.querySelectorAll('label span.min-w-0 > span');
            nameEl.textContent = bank.name;
            bicEl.textContent = bank.bic ? `BIC ${bank.bic}` : '';
            wrapper.querySelector('.bank-logo').textContent = bank.short;

            input.addEventListener('change', () => {
                const bicField = field('bic');
                if (bicField && !bicField.value) bicField.value = input.dataset.bic;
            });

            bankList.appendChild(wrapper);
        });
    }

    /* ---------- Étape 3 : validation des champs ---------- */

    function showError(field, message) {
        const input = form.querySelector(`[name="${field}"]`);
        const error = form.querySelector(`[data-error="${field}"]`);

        input?.classList.toggle('is-invalid', Boolean(message));
        if (error) {
            error.textContent = message || '';
            error.hidden = !message;
        }
        if (input) input.setAttribute('aria-invalid', message ? 'true' : 'false');
    }

    function validateStep(step) {
        if (step === 1) {
            const ok = Boolean(selectedCountry());
            toggleStepMessage(1, ok ? '' : 'Choisissez un pays pour continuer.');
            return ok;
        }

        if (step === 2) {
            const ok = Boolean(form.querySelector('input[name="bank"]:checked'));
            toggleStepMessage(2, ok ? '' : 'Choisissez une banque pour continuer.');
            return ok;
        }

        if (step === 3) {
            let ok = true;

            const firstname = field('firstname').value.trim();
            const lastname = field('lastname').value.trim();
            const iban = field('iban').value.trim();
            const bic = field('bic').value.trim();

            showError('firstname', firstname ? '' : 'Le prénom est obligatoire.');
            if (!firstname) ok = false;

            showError('lastname', lastname ? '' : 'Le nom est obligatoire.');
            if (!lastname) ok = false;

            if (!iban) {
                showError('iban', "L'IBAN est obligatoire.");
                ok = false;
            } else if (!isValidIban(iban)) {
                showError('iban', "Cet IBAN est invalide (clé de contrôle incorrecte).");
                ok = false;
            } else {
                const country = selectedCountry()?.value;
                const prefix = iban.replace(/\s+/g, '').slice(0, 2).toUpperCase();

                // Un IBAN allemand sur un bénéficiaire déclaré en France est
                // presque toujours une erreur de saisie : on le signale avant
                // que le virement ne parte.
                if (country && prefix !== country) {
                    showError('iban', `Cet IBAN commence par ${prefix}, mais le pays choisi est ${country}.`);
                    ok = false;
                } else {
                    showError('iban', '');
                    field('iban').value = formatIban(iban);
                }
            }

            if (bic && !isValidBic(bic)) {
                showError('bic', 'Le BIC doit comporter 8 ou 11 caractères.');
                ok = false;
            } else {
                showError('bic', '');
            }

            return ok;
        }

        return true;
    }

    function toggleStepMessage(step, message) {
        const el = modal.querySelector(`[data-step-error="${step}"]`);
        if (!el) return;
        el.textContent = message;
        el.hidden = !message;
    }

    /* ---------- Étape 4 : récapitulatif ---------- */

    function buildRecap() {
        const country = selectedCountry();
        const bank = form.querySelector('input[name="bank"]:checked');

        const values = {
            country: country?.dataset.label || '—',
            bank: bank?.value || '—',
            name: `${field('firstname').value.trim()} ${field('lastname').value.trim()}`.trim() || '—',
            iban: field('iban').value.trim() || '—',
            bic: field('bic').value.trim().toUpperCase() || '—',
            label: field('label').value.trim() || '—',
        };

        Object.entries(values).forEach(([key, value]) => {
            const el = modal.querySelector(`[data-recap="${key}"]`);
            if (el) el.textContent = value;
        });
    }

    /* ---------- Écouteurs ---------- */

    btnNext.addEventListener('click', () => {
        if (validateStep(current)) go(current + 1);
    });

    btnBack.addEventListener('click', () => go(current - 1));

    form.addEventListener('submit', (event) => {
        // Dernier filet : on revalide tout avant l'envoi, au cas où
        // l'utilisateur serait revenu en arrière modifier un champ.
        for (let step = 1; step < total; step += 1) {
            if (!validateStep(step)) {
                event.preventDefault();
                go(step);
                return;
            }
        }
    });

    // Réinitialisation à chaque ouverture : sans cela, un abandon laisserait
    // les champs de la tentative précédente au rouvrant.
    modal.addEventListener('modal:open', () => {
        form.reset();
        ['firstname', 'lastname', 'iban', 'bic'].forEach((f) => showError(f, ''));
        [1, 2].forEach((s) => toggleStepMessage(s, ''));
        if (bankList) bankList.innerHTML = '';
        if (bankEmpty) bankEmpty.hidden = false;
        go(1);
    });

    modal.querySelectorAll('[data-wizard-cancel]').forEach((btn) => {
        btn.addEventListener('click', () => closeModal(modal));
    });

    render();
}
