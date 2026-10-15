/**
 * Copie les dépendances JS tierces depuis node_modules vers public/js/vendor/.
 *
 * Sans bundler, il faut bien que Chart.js arrive dans public/. Deux options
 * existaient : un CDN, ou cette copie. La copie est retenue parce qu'une
 * application bancaire ne devrait pas dépendre de la disponibilité — ni du
 * traçage — d'un domaine tiers au chargement de chaque page.
 *
 * Écrit en Node pur (pas de `cp`) pour fonctionner à l'identique sous Windows.
 */
import { copyFileSync, mkdirSync, existsSync } from 'node:fs';
import { dirname, resolve } from 'node:path';
import { fileURLToPath } from 'node:url';

const root = resolve(dirname(fileURLToPath(import.meta.url)), '..');

const files = [
    {
        from: 'node_modules/chart.js/dist/chart.umd.js',
        to: 'public/js/vendor/chart.umd.js',
    },
];

let copied = 0;

for (const file of files) {
    const source = resolve(root, file.from);
    const target = resolve(root, file.to);

    if (!existsSync(source)) {
        console.error(`✗ Introuvable : ${file.from} — avez-vous lancé « npm install » ?`);
        process.exitCode = 1;
        continue;
    }

    mkdirSync(dirname(target), { recursive: true });
    copyFileSync(source, target);
    console.log(`✓ ${file.to}`);
    copied++;
}

console.log(`${copied} fichier(s) copié(s) dans public/js/vendor/.`);
