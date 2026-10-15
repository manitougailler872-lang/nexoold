/** @type {import('tailwindcss').Config} */
module.exports = {
    // Tailwind scanne ces fichiers pour ne garder que les classes réellement
    // utilisées. Oublier un chemin ici = styles absents en production.
    content: [
        './templates/**/*.html.twig',
        // Le JS applicatif manipule des classes (`is-active`, `hidden`) :
        // sans ce chemin, elles seraient purgées du build de production.
        // Motif volontairement non récursif : il exclut public/js/vendor/,
        // dont chart.umd.js (208 Ko) ralentirait l'analyse pour rien.
        './public/js/*.js',
    ],

    theme: {
        extend: {
            colors: {
                // Vert de marque
                nexo: {
                    50:  '#F0FAF4',
                    100: '#DCF3E4',
                    200: '#BBE7CB',
                    300: '#86D3A6',
                    400: '#4BB87C',
                    500: '#22A05C',
                    600: '#16A34A',
                    700: '#0F7B3D',
                    800: '#0D5F31',
                    900: '#0B3B24',
                    950: '#0F1512', // carte « Solde total »
                },
                colors: {
                    green: "#2E9E5B",
                    "green-deep": "#24824A",
                    mint: "#EAF6EF", 
                    "mint-2": "#F3F9F5",
                    ink: "#1A1D1F",
                    gray50: "#F5F6F7",
                    muted: "#6B7280",
                },
                // Gris de l'interface
                ink: {
                    DEFAULT: '#111827',
                    2: '#4B5563',
                    3: '#6B7280',
                    4: '#9CA3AF',
                },
                line: '#E8ECEA',
                canvas: '#F7F9F8',
                // Sémantique transactions
                credit: { bg: '#DCFCE7', fg: '#15803D' },
                debit:  { bg: '#FEE2E2', fg: '#B91C1C' },
            },

            fontFamily: { 
                sans: ["Nunito", "sans-serif"], head: ["Nunito", "sans-serif"] 
            },
            fontSize: {
                '2xs': ['0.6875rem', { lineHeight: '1rem' }],
            },

            borderRadius: {
                card: '14px',
            },

            boxShadow: {
                card: '0 1px 2px rgba(16, 24, 40, 0.04)',
                pop: '0 12px 32px -12px rgba(11, 59, 36, 0.22)',
            },

            spacing: {
                sidebar: '272px',
            },
        },
    },

    plugins: [],
};
