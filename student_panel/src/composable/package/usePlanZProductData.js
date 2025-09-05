import {computed, ref, onMounted, reactive} from "vue";
import { useRoute } from "vue-router";
import RepositoryFactory from "@/repository/RepositoryFactory";
import { useAlert } from "@/composable/useAlert";
import {useStore} from "vuex";

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
    const store = useStore();
    const productId = computed(() => product_id || route.params.id);
    const serverSelectedItems = ref();
    const product = ref([]);
    const sections = ref([]);
    const initialSelectedItems = reactive({});
    const isPackageInCart = ref(false);
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
            const { data: { data } } = await StoreRepository.getPlanZPackage(product_id);
            store.dispatch('navbar/updateTitle',data.package.product_name );
            return data;
        } catch (e) {
            error(`${e.error.message} ${e.error.status}`);
        } finally {
            loading.value = false;
        }
    };

    onMounted(async () => {
        const  data = await getProduct(productId.value);
        product.value = data.package;
        sections.value = product.value.sections.sort((a, b) => a.teachers.length - b.teachers.length);
        if(data.selected_items) {
            serverSelectedItems.value = data.selected_items;
                data.selected_items.forEach((section)=> {
                initialSelectedItems[section.section_id] = section.teacher_id
            })
        }

        sections.value.forEach((section) => {
            if (section.teachers.length === 1) {
                initialSelectedItems[section.section_id] = +section.teachers[0].teacher_id;
            }
        });

        isPackageInCart.value =  !!data.selected_items;
        console.log(isPackageInCart.value, '--asd-a-sd')
    });

    return { productId, product, initialSelectedItems,isPackageInCart,serverSelectedItems, sections, loading };
}
