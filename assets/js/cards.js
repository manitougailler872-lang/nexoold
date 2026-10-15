/**
 * Bascule grille / liste sur la page Cartes bancaires.
 * Le choix est conservé en localStorage pour survivre à la navigation.
 */
const STORAGE_KEY = 'nexotrade.cards.view';

export function initCardsView() {
    const section = document.querySelector('[data-cards-section]');
    if (!section) return;

    const grid = section.querySelector('[data-cards-grid]');
    const list = section.querySelector('[data-cards-list]');
    const buttons = section.querySelectorAll('[data-view]');

    if (!grid || !list) return;

    function apply(view) {
        const isList = view === 'list';

        grid.classList.toggle('hidden', isList);
        list.classList.toggle('hidden', !isList);

        buttons.forEach((button) => {
            const active = button.dataset.view === view;
            button.classList.toggle('is-active', active);
            button.setAttribute('aria-pressed', active ? 'true' : 'false');
        });
    }

    buttons.forEach((button) => {
        button.addEventListener('click', () => {
            const view = button.dataset.view;
            apply(view);

            try {
                localStorage.setItem(STORAGE_KEY, view);
            } catch (e) {
                // Navigation privée ou stockage plein : la bascule reste
                // fonctionnelle, seule la persistance est perdue.
            }
        });
    });

    let saved = null;
    try {
        saved = localStorage.getItem(STORAGE_KEY);
    } catch (e) {
        saved = null;
    }

    if (saved === 'list') {
        apply('list');
    }
}
