/**
 * Point d'entrée front NexoTrade.
 *
 * Chargé en <script type="module"> : les navigateurs modernes résolvent les
 * imports relatifs nativement, aucun bundler n'est nécessaire. Les modules
 * sont différés par défaut, le DOM est donc déjà parsé à l'exécution.
 */
import { initSidebar, initAmountToggles } from './sidebar.js';
import { initDropdowns } from './dropdown.js';
import { initCardsView } from './cards.js';
import { initModals } from './modal.js';
import { initBeneficiaryActions, initBeneficiaryWizard } from './beneficiary.js';
import { initTransferForm } from './tapsend.js';
import { initSignatureModal, initLoanDetails, initContractModal } from './signature.js';
import { initBalanceChart, initAllocationChart } from './charts.js';

initSidebar();
initAmountToggles();
initDropdowns();
initCardsView();
initModals();
initBeneficiaryActions();
initBeneficiaryWizard();
initTransferForm();
initSignatureModal();
initLoanDetails();
initContractModal();
initBalanceChart();
initAllocationChart();
