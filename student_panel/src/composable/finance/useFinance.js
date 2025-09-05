import { ref } from 'vue';
import { useStore } from 'vuex';
import RepositoryFactory from '@/repository/RepositoryFactory';
import {useAlert} from "@/composable/useAlert";


export function useFinance() {
    const store = useStore();
    const financeBrief = ref({
        total_credit_amount : null,
        total_buy_amount    : null,
        total_debt          : null,
        credit              : null,
    });
    const finance = ref({
        transaction_future_installment : [],
        transaction_type_one : [],
        transaction_type_zero : [],
    });
    const loading = ref(false);
    const { error } = useAlert();
    const FinanceRepository = RepositoryFactory.get('Finance');

    const getFinanceBrief = async () => {
        try {
            loading.value = true;
            const { data: { data } } = await FinanceRepository.getFinanceBrief();
            financeBrief.value = data; // Assuming data has deposits, payments, and debts properties
        } catch (e) {
            error(e.error.message);
        } finally {
            loading.value = false;
        }
    };

    const getFinance = async (type) => {
        try {
            loading.value = true;
            const { data: { data } } = await FinanceRepository.getFinance(type);
            finance.value = data; // Assuming data has deposits, payments, and debts properties
        } catch (e) {
            error(e.error.message);
        } finally {
            loading.value = false;
        }
    };

    return {
        financeBrief,
        finance,
        loading,
        getFinance,
        getFinanceBrief,
    };
}