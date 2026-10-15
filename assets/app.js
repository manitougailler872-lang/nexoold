import './styles/app.css';

import { initBalanceChart, initAllocationChart } from './js/charts';
import { initSidebar } from './js/sidebar';

document.addEventListener('DOMContentLoaded', () => {
    initSidebar();
    initBalanceChart();
    initAllocationChart();
});
