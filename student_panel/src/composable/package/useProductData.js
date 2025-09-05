import {computed, ref, onMounted, reactive} from "vue";
import { useRoute } from "vue-router";
import RepositoryFactory from "@/repository/RepositoryFactory";
import { useAlert } from "@/composable/useAlert";

/**
 * Composable function to handle product data fetching and management.
 *
 * @returns {Object} - An object containing product data, sections data, and loading state.
 * @property {Ref<Array>} product - A ref that holds the product data.
 * @property {Ref<Array>} sections - A ref that holds the sections data.
 * @property {Ref<Boolean>} loading - A ref that indicates the loading state.
 */
export function useProductData(product_id = null) {
    const { error } = useAlert();
    const route = useRoute();
    const productId = computed(() => product_id || route.params.id);

    const product = ref([]);
    const sections = ref([]);
    const initialSelectedItems = reactive({});
    const loading = ref(false);

    const StoreRepository = RepositoryFactory.get("Store");

    /**
     * Fetches the product data from the repository.
     *
     * @async
     * @param {string} product_id - The ID of the product to fetch.
     * @returns {Promise<Object>} - The fetched product data.
     */
    const getProduct = async (product_id) => {
        try {
            loading.value = true;
            const { data: { data } } = await StoreRepository.getPackage(product_id);
            return data;
        } catch (e) {
            error(`${e.error.message} ${e.error.status}`);
        } finally {
            loading.value = false;
        }
    };

    onMounted(async () => {
        product.value = await getProduct(productId.value);
        sections.value = product.value.sections.sort((a, b) => a.courses.length - b.courses.length);

        product.value.sections.forEach((section) => {
            section.courses.forEach((course) => {
                if (course.is_selected) initialSelectedItems[section.id] = course.product_id;
            })
        })
        sections.value.forEach((section) => {
            if (section.courses.length === 1) {
                initialSelectedItems[section.id] = section.courses[0].product_id;
            }
        });
    });

    return { productId, product, initialSelectedItems, sections, loading };
}
