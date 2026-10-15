/**
 * Graphiques du tableau de bord.
 *
 * Chart.js est chargé en amont par <script src=".../chart.umd.js"> et expose
 * `window.Chart`. Le build UMD enregistre déjà tous les contrôleurs : contrairement
 * à la version bundlée, aucun Chart.register() n'est nécessaire ici.
 *
 * Contrepartie assumée du passage sans bundler : on embarque la bibliothèque
 * entière (~208 Ko non minifiés) au lieu des seuls contrôleurs utilisés.
 * Si ce poids devient gênant, le CDN jsDelivr propose des builds partiels.
 */

const euro = new Intl.NumberFormat('fr-FR', {
    style: 'currency',
    currency: 'EUR',
    minimumFractionDigits: 2,
});

/**
 * Lit un JSON déposé par Twig dans un attribut data-*.
 * Twig doit l'encoder avec |json_encode|e('html_attr').
 */
function readData(el, key) {
    try {
        return JSON.parse(el.dataset[key]);
    } catch (e) {
        console.error(`Données "${key}" illisibles sur`, el, e);
        return null;
    }
}

/** Garde-fou : le script vendor peut ne pas avoir été copié (npm run vendor). */
function chartAvailable() {
    if (typeof window.Chart === 'undefined') {
        console.error(
            'Chart.js est absent. Lancez « npm run vendor » pour copier ' +
            'chart.umd.js dans public/js/vendor/.'
        );
        return false;
    }
    return true;
}

function applyDefaults() {
    const Chart = window.Chart;

    Chart.defaults.font.family = 'Nunito, system-ui, sans-serif';
    Chart.defaults.font.size = 11;
    Chart.defaults.font.weight = 600; // Nunito rend plus fin : on compense
    Chart.defaults.color = '#6B7280';
}

export function initBalanceChart() {
    const canvas = document.getElementById('balance-chart');
    if (!canvas) return;
    if (!chartAvailable()) return;

    const points = readData(canvas, 'points');
    if (!points) return;

    applyDefaults();

    const ctx = canvas.getContext('2d');

    const gradient = ctx.createLinearGradient(0, 0, 0, canvas.offsetHeight || 260);
    gradient.addColorStop(0, 'rgba(22, 163, 74, 0.22)');
    gradient.addColorStop(1, 'rgba(22, 163, 74, 0)');

    new window.Chart(ctx, {
        type: 'line',
        data: {
            labels: points.map((p) => p.label),
            datasets: [
                {
                    data: points.map((p) => p.value),
                    borderColor: '#16A34A',
                    borderWidth: 2,
                    backgroundColor: gradient,
                    fill: true,
                    tension: 0.35,
                    pointRadius: 0,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: '#16A34A',
                    pointHoverBorderColor: '#fff',
                    pointHoverBorderWidth: 2,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#0F1512',
                    padding: 12,
                    displayColors: false,
                    cornerRadius: 8,
                    titleFont: { weight: '600' },
                    callbacks: {
                        label: (context) => euro.format(context.parsed.y),
                    },
                },
            },
            scales: {
                x: {
                    grid: { display: false },
                    border: { display: false },
                    ticks: { maxTicksLimit: 7, autoSkip: true },
                },
                y: {
                    beginAtZero: true,
                    grid: { color: '#F1F4F2' },
                    border: { display: false },
                    ticks: {
                        maxTicksLimit: 5,
                        callback: (value) => (value >= 1000 ? `${value / 1000}K` : value),
                    },
                },
            },
        },
    });
}

export function initAllocationChart() {
    const canvas = document.getElementById('allocation-chart');
    if (!canvas) return;
    if (!chartAvailable()) return;

    const slices = readData(canvas, 'slices');
    if (!slices) return;

    applyDefaults();

    new window.Chart(canvas.getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: slices.map((s) => s.label),
            datasets: [
                {
                    data: slices.map((s) => s.amount),
                    backgroundColor: slices.map((s) => s.color),
                    borderWidth: 0,
                    spacing: 2,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '72%',
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#0F1512',
                    padding: 10,
                    cornerRadius: 8,
                    callbacks: {
                        label: (context) => `${context.label} : ${euro.format(context.parsed)}`,
                    },
                },
            },
        },
    });
}
