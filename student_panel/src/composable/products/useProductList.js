// useProductList.js
import { ref } from 'vue';
import RepositoryFactory from '@/repository/RepositoryFactory';
import { useAlert } from '@/composable/useAlert';

const StoreRepository = RepositoryFactory.get('Store');
const { error } = useAlert();

export function useProductList() {
    const products = ref([]);
    const loading = ref(false);

    const getProducts = async (query) => {
        try {
            loading.value = true;
            const { data: { data } } = await StoreRepository.getProducts({query});
            products.value = data;
        } catch (e) {
            error(`${e.error.message} ${e.error.status}`);
            // TODO: Handle error or show retry option
        } finally {
            loading.value = false;
        }
    };

    return { products, loading, getProducts };
}