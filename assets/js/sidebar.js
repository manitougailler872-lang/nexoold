/**
 * Repli de la navigation latérale + masquage du solde.
 */
export function initSidebar() {
    const toggle = document.querySelector('[data-sidebar-toggle]');
    const sidebar = document.querySelector('[data-sidebar]');

    if (toggle && sidebar) {
        toggle.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
            toggle.setAttribute(
                'aria-expanded',
                sidebar.classList.contains('-translate-x-full') ? 'false' : 'true'
            );
        });
    }

    // Bouton « œil » : masque le solde total (utile en open space).
    document.querySelectorAll('[data-toggle-amount]').forEach((button) => {
        const target = document.querySelector(button.dataset.toggleAmount);
        if (!target) return;

        const realValue = target.textContent;
        let hidden = false;

        button.addEventListener('click', () => {
            hidden = !hidden;
            target.textContent = hidden ? '€ ••• •••,••' : realValue;
            button.setAttribute('aria-label', hidden ? 'Afficher le solde' : 'Masquer le solde');
        });
    });
}
