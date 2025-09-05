// useProductFilters.js
import {ref, computed, watch, reactive} from 'vue';
import { useRoute } from 'vue-router';
import debounce from 'lodash/debounce';
import RepositoryFactory from "@/repository/RepositoryFactory";
import {useAlert} from "@/composable/useAlert";

export function useProductFilters() {
    const { error } = useAlert();
    const StoreRepository = RepositoryFactory.get("Store");
    const route = useRoute();
    const items = ref([]);
    const loading = ref(false);
    const pagination =reactive({
        last_page: 1,
        current_page: 1,
        per_page: 10,
    })

    const filteredProducts = computed(()=> items.value);

    const searchQuery = ref('');

    // Computed property for debounced search
    const debouncedSearchQuery = ref('');
    const debouncedUpdate = debounce((val) => {
        debouncedSearchQuery.value = val;
    }, 300);

    watch(() => searchQuery.value, (newVal) => {
        if(typeof newVal === "undefined") debouncedUpdate('');
        else debouncedUpdate(newVal)
    },{ immediate: false });

    const applyFilters = async (currentPage,query) => {
        try {
            loading.value = true;
            items.value = [];
            const { data: { data, lastPage, page, pageSize } } = await StoreRepository.getProducts({
               page : currentPage,
               ...query
            });
            pagination.current_page = page;
            pagination.last_page = lastPage;
            pagination.per_page = pageSize;

            items.value = data ;
        } catch (e) {
            error(`${e.error.message} ${e.error.status}`);
            // TODO: Handle error or show retry option
        } finally {
            loading.value = false;
        }
    };

    // Watch route query for changes and update filtered products
    watch(() => route.query, (value)=> {
        pagination.current_page = 1;
        applyFilters(pagination.current_page,value);
    }, { deep: true });

    watch(()=> pagination.current_page, (value,oldValue)=> {
        applyFilters(value, route.query)
    })

    // Watch debounced search query for changes and update filtered products
    watch(debouncedSearchQuery, (value)=>{
        pagination.current_page = 1;
        applyFilters(pagination.current_page, route.query)
    });

    return { filteredProducts, searchQuery,applyFilters, loading, pagination };
}