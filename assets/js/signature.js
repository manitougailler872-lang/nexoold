import { openModal, closeModal } from './modal.js';

/* ------------------------------------------------------------------ *
 *  Pavé de signature
 * ------------------------------------------------------------------ */

/**
 * Signature manuscrite sur <canvas>.
 *
 * Choix techniques :
 *  - Pointer Events plutôt que mouse + touch : un seul jeu d'écouteurs couvre
 *    souris, trackpad, doigt et stylet.
 *  - `setPointerCapture` : le tracé continue proprement si le doigt sort du
 *    canvas, au lieu de s'interrompre net.
 *  - `touch-action: none` (classe CSS) : sans lui, le navigateur mobile fait
 *    défiler la page au lieu de dessiner.
 *  - Le canvas est dimensionné en pixels physiques (devicePixelRatio), sinon
 *    le tracé est flou sur écran à haute densité.
 */
export function createSignaturePad(root) {
    const canvas = root.querySelector('canvas');
    if (!canvas) return null;

    const ctx = canvas.getContext('2d');
    let drawing = false;
    let empty = true;
    let lastX = 0;
    let lastY = 0;

    function applySize() {
        const ratio = window.devicePixelRatio || 1;
        const rect = canvas.getBoundingClientRect();

        // Un redimensionnement vide le canvas : on sauvegarde le tracé courant
        // pour le restituer ensuite.
        const previous = empty ? null : canvas.toDataURL();

        canvas.width = Math.max(1, Math.round(rect.width * ratio));
        canvas.height = Math.max(1, Math.round(rect.height * ratio));

        ctx.setTransform(ratio, 0, 0, ratio, 0, 0);
        ctx.lineWidth = 2.2;
        ctx.lineCap = 'round';
        ctx.lineJoin = 'round';
        ctx.strokeStyle = '#0F1A16';

        if (previous) {
            const image = new Image();
            image.onload = () => ctx.drawImage(image, 0, 0, rect.width, rect.height);
            image.src = previous;
        }
    }

    function position(event) {
        const rect = canvas.getBoundingClientRect();
        return { x: event.clientX - rect.left, y: event.clientY - rect.top };
    }

    function start(event) {
        // Seul le bouton principal dessine : un clic droit ne doit rien tracer.
        if (event.button !== undefined && event.button !== 0) return;

        drawing = true;
        canvas.setPointerCapture?.(event.pointerId);

        const { x, y } = position(event);
        lastX = x;
        lastY = y;

        // Un simple point doit laisser une marque.
        ctx.beginPath();
        ctx.arc(x, y, ctx.lineWidth / 2, 0, Math.PI * 2);
        ctx.fillStyle = ctx.strokeStyle;
        ctx.fill();

        markSigned();
        event.preventDefault();
    }

    function move(event) {
        if (!drawing) return;

        const { x, y } = position(event);

        ctx.beginPath();
        ctx.moveTo(lastX, lastY);
        ctx.lineTo(x, y);
        ctx.stroke();

        lastX = x;
        lastY = y;
        event.preventDefault();
    }

    function stop(event) {
        if (!drawing) return;
        drawing = false;
        canvas.releasePointerCapture?.(event.pointerId);
    }

    function markSigned() {
        empty = false;
        root.classList.add('is-signed');
        root.dispatchEvent(new CustomEvent('signature:change', { bubbles: true }));
    }

    canvas.addEventListener('pointerdown', start);
    canvas.addEventListener('pointermove', move);
    canvas.addEventListener('pointerup', stop);
    canvas.addEventListener('pointercancel', stop);
    canvas.addEventListener('pointerleave', stop);

    window.addEventListener('resize', applySize);
    applySize();

    return {
        isEmpty: () => empty,

        clear() {
            ctx.save();
            ctx.setTransform(1, 0, 0, 1, 0, 0);
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.restore();

            empty = true;
            root.classList.remove('is-signed');
            root.dispatchEvent(new CustomEvent('signature:change', { bubbles: true }));
        },

        /** @returns {string} PNG encodé en base64, ou '' si rien n'est tracé. */
        toDataUrl: () => (empty ? '' : canvas.toDataURL('image/png')),

        resize: applySize,
    };
}

/* ------------------------------------------------------------------ *
 *  Modale de signature de contrat — 3 étapes
 * ------------------------------------------------------------------ */

export function initSignatureModal() {
    const modal = document.getElementById('loan-signature-modal');
    if (!modal) return;

    const form = modal.querySelector('form');
    const steps = Array.from(modal.querySelectorAll('[data-sign-step]'));
    const dots = Array.from(modal.querySelectorAll('[data-sign-dot]'));
    const bars = Array.from(modal.querySelectorAll('[data-sign-bar]'));

    const btnBack = modal.querySelector('[data-sign-back]');
    const btnNext = modal.querySelector('[data-sign-next]');
    const btnSign = modal.querySelector('[data-sign-validate]');
    const btnFinish = modal.querySelector('[data-sign-finish]');
    const btnClear = modal.querySelector('[data-sign-clear]');

    const padRoot = modal.querySelector('.signature-pad');
    const pad = padRoot ? createSignaturePad(padRoot) : null;

    const accept = form.querySelector('[name="acceptTerms"]');
    const typedName = form.querySelector('[name="typedSignature"]');
    const signatureField = form.querySelector('[name="signature"]');

    const total = steps.length;
    let current = 1;

    /** Une signature vaut si le pavé est tracé OU si le nom est saisi. */
    function hasSignature() {
        const drawn = pad && !pad.isEmpty();
        const typed = typedName && typedName.value.trim().length >= 3;
        return Boolean(drawn || typed);
    }

    function message(step, text) {
        const el = modal.querySelector(`[data-sign-error="${step}"]`);
        if (!el) return;
        el.textContent = text || '';
        el.hidden = !text;
    }

    function render() {
        steps.forEach((s) => { s.hidden = Number(s.dataset.signStep) !== current; });

        dots.forEach((dot) => {
            const n = Number(dot.dataset.signDot);
            dot.classList.toggle('is-current', n === current);
            dot.classList.toggle('is-done', n < current);
            // L'étape franchie affiche une coche à la place du numéro.
            const check = dot.querySelector('[data-dot-check]');
            const number = dot.querySelector('[data-dot-number]');
            if (check && number) {
                check.hidden = n >= current;
                number.hidden = n < current;
            }
        });

        bars.forEach((bar) => bar.classList.toggle('is-done', Number(bar.dataset.signBar) < current));

        btnBack.hidden = current === 1 || current === total;
        btnNext.hidden = current !== 1;
        btnSign.hidden = current !== 2;
        btnFinish.hidden = current !== total;

        // Le canvas n'a pas de dimensions tant qu'il est masqué : il faut le
        // redimensionner au moment où l'étape 2 devient visible.
        if (current === 2) requestAnimationFrame(() => pad?.resize());
    }

    function go(step) {
        current = Math.max(1, Math.min(step, total));
        render();
    }

    btnNext?.addEventListener('click', () => {
        if (accept && !accept.checked) {
            message(1, 'Vous devez accepter les conditions du contrat pour continuer.');
            return;
        }
        message(1, '');
        go(2);
    });

    btnBack?.addEventListener('click', () => go(current - 1));
    btnClear?.addEventListener('click', () => { pad?.clear(); message(2, ''); });

    padRoot?.addEventListener('signature:change', () => message(2, ''));
    typedName?.addEventListener('input', () => message(2, ''));

    btnSign?.addEventListener('click', () => {
        if (!hasSignature()) {
            message(2, 'Signez dans le cadre ou saisissez votre nom complet.');
            return;
        }

        message(2, '');

        // La signature manuscrite prime ; le nom saisi sert de repli.
        signatureField.value = pad && !pad.isEmpty()
            ? pad.toDataUrl()
            : `typed:${typedName.value.trim()}`;

        const preview = modal.querySelector('[data-signature-preview]');
        if (preview) {
            if (pad && !pad.isEmpty()) {
                preview.innerHTML = '';
                const img = new Image();
                img.src = pad.toDataUrl();
                img.alt = 'Aperçu de votre signature';
                img.className = 'max-h-20 mx-auto';
                preview.appendChild(img);
            } else {
                preview.textContent = typedName.value.trim();
                preview.className = 'text-center text-xl font-semibold italic text-ink';
            }
        }

        go(3);
    });

    modal.querySelectorAll('[data-sign-cancel]').forEach((btn) => {
        btn.addEventListener('click', () => closeModal(modal));
    });

    // Remise à zéro à chaque ouverture : une signature abandonnée ne doit pas
    // resservir pour un autre contrat.
    modal.addEventListener('modal:open', (event) => {
        form.reset();
        pad?.clear();
        signatureField.value = '';
        [1, 2].forEach((s) => message(s, ''));

        const trigger = event.detail?.trigger;
        if (trigger) {
            const set = (key, value) => {
                const el = modal.querySelector(`[data-contract="${key}"]`);
                if (el) el.textContent = value || '—';
            };

            set('type', trigger.dataset.loanType);
            set('reference', trigger.dataset.loanReference);
            set('amount', trigger.dataset.loanAmount);
            set('duration', trigger.dataset.loanDuration);
            set('monthly', trigger.dataset.loanMonthly);
            set('rate', trigger.dataset.loanRate);

            const idField = form.querySelector('[name="loanId"]');
            if (idField) idField.value = trigger.dataset.loanId || '';
            if (trigger.dataset.loanSignUrl) form.action = trigger.dataset.loanSignUrl;
        }

        go(1);
    });

    render();
}

/* ------------------------------------------------------------------ *
 *  Dépliage des demandes
 * ------------------------------------------------------------------ */

export function initLoanDetails() {
    document.querySelectorAll('[data-loan-toggle]').forEach((button) => {
        const panel = document.getElementById(button.getAttribute('aria-controls'));
        if (!panel) return;

        const label = button.querySelector('[data-toggle-label]');

        button.addEventListener('click', () => {
            const open = panel.hidden;

            panel.hidden = !open;
            button.setAttribute('aria-expanded', open ? 'true' : 'false');
            button.querySelector('svg')?.classList.toggle('rotate-180', open);

            // Le libellé suit l'état : « Voir » / « Masquer ».
            if (label) {
                const next = open ? button.dataset.labelOpen : button.dataset.labelClosed;
                if (next) label.textContent = next;
            }

            // À la première ouverture, on amène l'échéancier dans le champ de
            // vision : déplié sous une carte, il passe souvent sous la ligne
            // de flottaison sans que l'utilisateur s'en aperçoive.
            if (open) {
                requestAnimationFrame(() => {
                    panel.scrollIntoView?.({ behavior: 'smooth', block: 'nearest' });
                });
            }
        });
    });
}

/* ------------------------------------------------------------------ *
 *  Modale « Contrat »
 * ------------------------------------------------------------------ */

export function initContractModal() {
    const modal = document.getElementById('loan-contract-modal');
    if (!modal) return;

    modal.addEventListener('modal:open', (event) => {
        const trigger = event.detail?.trigger;
        if (!trigger) return;

        const d = trigger.dataset;

        // Plusieurs éléments portent la même clé (référence en en-tête et dans
        // le corps du document) : on les renseigne tous.
        const set = (key, value) => {
            modal.querySelectorAll(`[data-contract="${key}"]`).forEach((el) => {
                el.textContent = value || '—';
            });
        };

        set('type', d.loanType);
        set('reference', d.loanReference);
        set('amount', d.loanAmount);
        set('duration', d.loanDuration);
        set('monthly', d.loanMonthly);
        set('rate', d.loanRate);
        set('cost', d.loanCost);
        set('borrower', d.loanBorrower);
        set('account', d.loanAccount);

        // Bloc signature : renseigné seulement si le contrat est déjà signé.
        const block = modal.querySelector('[data-contract-signature]');
        const empty = modal.querySelector('[data-contract-signature-empty]');

        if (block) {
            block.querySelector('[data-signed-name]')?.remove();

            if (d.loanSigned === '1') {
                if (empty) empty.hidden = true;

                const name = document.createElement('span');
                name.dataset.signedName = 'true';
                name.className = 'text-[15px] font-semibold italic text-ink';
                name.textContent = d.loanBorrower || '';
                block.appendChild(name);
            } else if (empty) {
                empty.hidden = false;
            }
        }

        const download = modal.querySelector('[data-contract-download]');
        if (download && d.loanDownloadUrl) download.href = d.loanDownloadUrl;
    });
}
