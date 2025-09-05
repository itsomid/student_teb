// useProduct.js
import { ref, computed } from 'vue';
import RepositoryFactory from '@/repository/RepositoryFactory';
import { useAlert } from '@/composable/useAlert';
import { useRoute } from 'vue-router';
import {useStore} from "vuex";
import { useGoogleTagManager } from "@/composable/useGtm";

const StoreRepository = RepositoryFactory.get('Store');
const { error } = useAlert();

export function useProduct() {
    const product = ref(null);
    const loading = ref(false);
    const route = useRoute();
    const productId = computed(() => route.params.id);
    const store = useStore();
    const { trackViewItemEvent } = useGoogleTagManager();

    const getProduct = async (product_id) => {
        try {
            loading.value = true;
            const { data: { data } } = await StoreRepository.getProduct(product_id);
            product.value = data;
            trackViewItemEvent(product.value)
            store.dispatch('navbar/updateTitle',product.value.name );
        } catch (e) {
            error(`${e.error.message} ${e.error.status}`);
        } finally {
            loading.value = false;
        }
    };

    return { product, loading, getProduct, productId };
}