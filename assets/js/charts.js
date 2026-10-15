import {
    Chart,
    LineController,
    LineElement,
    PointElement,
    LinearScale,
    CategoryScale,
    Filler,
    Tooltip,
    DoughnutController,
    ArcElement,
} from 'chart.js';

// Enregistrement sélectif : on n'embarque que les contrôleurs utilisés,
// ce qui évite d'alourdir le bundle avec toute la bibliothèque.
Chart.register(
    LineController,
    LineElement,
    PointElement,
    LinearScale,
    CategoryScale,
    Filler,
    Tooltip,
    DoughnutController,
    ArcElement
);

Chart.defaults.font.family = 'Inter, system-ui, sans-serif';
Chart.defaults.font.size = 11;
Chart.defaults.color = '#6B7280';

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

export function initBalanceChart() {
    const canvas = document.getElementById('balance-chart');
    if (!canvas) return;

    const points = readData(canvas, 'points');
    if (!points) return;

    const ctx = canvas.getContext('2d');

    // Dégradé sous la courbe, recalculé à la hauteur réelle du canvas.
    const gradient = ctx.createLinearGradient(0, 0, 0, canvas.offsetHeight || 260);
    gradient.addColorStop(0, 'rgba(22, 163, 74, 0.22)');
    gradient.addColorStop(1, 'rgba(22, 163, 74, 0)');

    new Chart(ctx, {
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

    const slices = readData(canvas, 'slices');
    if (!slices) return;

    new Chart(canvas.getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: slices.map((s) => s.label),
            datasets: [
                {
                    data: slices.map((s) => s.amount),
                    backgroundColor: slices.map((s) => s.color),
                    borderWidth: 0,
                    // Un secteur à 0 € ne doit pas produire de trait résiduel.
                    spacing: 2,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '72%',
            plugins: {
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
