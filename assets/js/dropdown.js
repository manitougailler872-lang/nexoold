/**
 * Menus déroulants (messages, notifications, profil).
 *
 * Un seul contrôleur générique pilote les trois : le balisage porte
 * data-dropdown / data-dropdown-trigger / data-dropdown-panel, le JS ne
 * connaît aucun identifiant métier.
 *
 * Accessibilité prise en charge :
 *  - aria-expanded reflété sur le déclencheur ;
 *  - fermeture à Échap, avec retour du focus sur le déclencheur ;
 *  - fermeture au clic extérieur et à la perte de focus clavier ;
 *  - ouvrir un menu referme les autres.
 */

const OPEN_CLASS = 'is-open';

/** matchMedia peut manquer selon l'environnement : repli sur innerWidth. */
const isNarrow = () => (window.matchMedia
    ? window.matchMedia('(max-width: 639px)').matches
    : window.innerWidth <= 639);

export function initDropdowns() {
    const dropdowns = Array.from(document.querySelectorAll('[data-dropdown]'));
    if (dropdowns.length === 0) return;

    const controllers = dropdowns.map(build).filter(Boolean);

    function closeAll(except) {
        controllers.forEach((c) => {
            if (c !== except) c.close(false);
        });
    }

    function build(root) {
        const trigger = root.querySelector('[data-dropdown-trigger]');
        const panel = root.querySelector('[data-dropdown-panel]');

        if (!trigger || !panel) return null;

        const controller = {
            root,
            trigger,
            panel,
            isOpen: () => !panel.hidden,

            open() {
                closeAll(controller);
                panel.hidden = false;
                root.classList.add(OPEN_CLASS);
                trigger.setAttribute('aria-expanded', 'true');

                // Sur mobile le panneau occupe presque tout l'écran :
                // on bloque le défilement de la page derrière.
                if (isNarrow()) {
                    document.body.classList.add('overflow-hidden');
                }
            },

            close(returnFocus = true) {
                if (panel.hidden) return;

                panel.hidden = true;
                root.classList.remove(OPEN_CLASS);
                trigger.setAttribute('aria-expanded', 'false');
                document.body.classList.remove('overflow-hidden');

                if (returnFocus) trigger.focus();
            },

            toggle() {
                controller.isOpen() ? controller.close() : controller.open();
            },
        };

        panel.hidden = true;
        trigger.setAttribute('aria-expanded', 'false');
        trigger.setAttribute('aria-haspopup', 'true');

        trigger.addEventListener('click', (event) => {
            event.preventDefault();
            event.stopPropagation();
            controller.toggle();
        });

        // Un clic à l'intérieur du panneau ne doit pas le refermer,
        // sauf sur un élément qui le demande explicitement.
        panel.addEventListener('click', (event) => {
            if (event.target.closest('[data-dropdown-close]')) {
                controller.close();
                return;
            }
            event.stopPropagation();
        });

        return controller;
    }

    document.addEventListener('click', () => closeAll(null));

    document.addEventListener('keydown', (event) => {
        if (event.key !== 'Escape') return;

        const open = controllers.find((c) => c.isOpen());
        if (open) open.close();
    });

    // Navigation au clavier : sortir du menu le referme.
    controllers.forEach((c) => {
        c.root.addEventListener('focusout', (event) => {
            if (!c.isOpen()) return;
            if (c.root.contains(event.relatedTarget)) return;

            // Sur mobile, le panneau est détaché visuellement : on ne ferme
            // pas sur focusout, l'utilisateur a le bouton de fermeture.
            if (isNarrow()) return;

            c.close(false);
        });
    });
}
