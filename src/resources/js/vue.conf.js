import {createApp} from 'vue/dist/vue.esm-bundler';

import 'vuetify/_styles.scss'

import {createVuetify} from 'vuetify'
import {fa} from 'vuetify/locale'

const vuetify = createVuetify({

    locale: {
        locale: 'fa',
        fallback: 'fa',
        messages: {fa},
        rtl: {fa: true},
    },
})
import DebitCardTransactionSelect from "./components/miscellaneous/DebitCardTransactionSelect.vue";
import DynamicSelect from './components/miscellaneous/DynamicSelect.vue'
import NoteModal from './components/miscellaneous/NoteModal.vue'
import Filepond from "./components/libs/Filepond.vue";
import InstallmentChart from "./components/libs/InstallmentChart.vue";
import CustomPackage from "./components/pages/custom_package/CustomPackage.vue";
import PackageSectionManager from "./components/pages/custom_package/PackageSectionManager.vue";

const app = createApp({});

app.use(vuetify)
    .component("dynamic-select", DynamicSelect)
    .component('filepond', Filepond)
    .component("debit-card-transaction-select", DebitCardTransactionSelect)
    .component("note-modal", NoteModal)
    .component('installment-chart', InstallmentChart)
    .component('custom-package', CustomPackage)
    .component('package-section-manager', PackageSectionManager)

const mountedApp = app.mount("#app");
