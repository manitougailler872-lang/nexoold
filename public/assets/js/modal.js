/**
 * Fenêtres modales.
 *
 * Balisage attendu :
 *   <button data-modal-open="id-de-la-modale">…</button>
 *   <div id="id-de-la-modale" class="modal" hidden role="dialog" aria-modal="true">
 *       <div class="modal-backdrop" data-modal-close></div>
 *       <div class="modal-panel">… <button data-modal-close>…</button></div>
 *   </div>
 *
 * Accessibilité :
 *  - le focus est piégé dans la boîte tant qu'elle est ouverte ;
 *  - Échap et le clic sur le voile referment ;
 *  - le focus revient sur l'élément déclencheur à la fermeture ;
 *  - le défilement de la page est bloqué derrière la modale.
 */

const FOCUSABLE = 'a[href], button:not([disabled]), input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])';

let opener = null;

export function openModal(modal, trigger = null) {
    if (!modal) return;

    opener = trigger;
    modal.hidden = false;
    document.body.classList.add('overflow-hidden');

    const first = modal.querySelector('[data-modal-autofocus]') || modal.querySelector(FOCUSABLE);
    first?.focus?.();

    modal.dispatchEvent(new CustomEvent('modal:open', { detail: { trigger } }));
}

export function closeModal(modal) {
    if (!modal || modal.hidden) return;

    modal.hidden = true;
    document.body.classList.remove('overflow-hidden');

    opener?.focus();
    opener = null;

    modal.dispatchEvent(new CustomEvent('modal:close'));
}

function currentOpen() {
    return document.querySelector('.modal:not([hidden])');
}

export function initModals() {
    document.querySelectorAll('[data-modal-open]').forEach((trigger) => {
        trigger.addEventListener('click', (event) => {
            event.preventDefault();
            openModal(document.getElementById(trigger.dataset.modalOpen), trigger);
        });
    });

    document.addEventListener('click', (event) => {
        const closer = event.target.closest('[data-modal-close]');
        if (closer) closeModal(closer.closest('.modal'));
    });

    document.addEventListener('keydown', (event) => {
        const modal = currentOpen();
        if (!modal) return;

        if (event.key === 'Escape') {
            closeModal(modal);
            return;
        }

        // Piège à focus : Tab ne doit pas sortir de la boîte de dialogue.
        if (event.key !== 'Tab') return;

        const items = Array.from(modal.querySelectorAll(FOCUSABLE))
            .filter((el) => el.offsetParent !== null);

        if (items.length === 0) return;

        const first = items[0];
        const last = items[items.length - 1];

        if (event.shiftKey && document.activeElement === first) {
            event.preventDefault();
            last.focus();
        } else if (!event.shiftKey && document.activeElement === last) {
            event.preventDefault();
            first.focus();
        }
    });
}
