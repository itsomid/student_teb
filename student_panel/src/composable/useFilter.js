import { useSerializer } from "@/composable/useSerializer";
import { ref } from "vue";

/**
 * A composable function for filtering products based on specified query parameters.
 * @param {Object} FILTER_KEYS - An object containing keys for filtering criteria.
 * @returns {Object} An object with a filter function for filtering products.
 */
export function useFilter(FILTER_KEYS) {
    /**
     * Ref for storing the filtered products.
     * @type {Object}
     */
    const filteredProducts = ref([]);

    /**
     * Serializer utility for deserializing comma-separated strings.
     * @type {Object}
     */
    const { commaSeparatedDeserializer } = useSerializer();

    /**
     * Function to detect and parse query parameters.
     * @param {Object} query - The query parameters to parse.
     * @returns {Object} An object containing selected filters.
     */
    const queryParamDetector = (query) => {
        const selectedFilters = {};
        for (const paramName in query) {
            if (query.hasOwnProperty(paramName)) {
                if (!['search', 'free'].includes(paramName)) {
                    selectedFilters[paramName] = commaSeparatedDeserializer(query[paramName]);
                } else if (query[paramName]) {
                    selectedFilters[paramName] = query[paramName];
                }
            }
        }
        return selectedFilters;
    };

    /**
     * Logic function for filtering products based on selected filters.
     * @param {Object} selectedFilters - The selected filters.
     * @param {string} key - The key of the filter to apply.
     * @param {Object} product - The product to filter.
     * @returns {boolean} True if the product passes the filter, false otherwise.
     */
    const filterLogic = (selectedFilters, key, product) => {
        if (!selectedFilters[key] || !selectedFilters[key].length) {
            return true;
        } else if (typeof product[FILTER_KEYS[key]] === 'number') {
            return selectedFilters[key].includes(product[FILTER_KEYS[key]]);
        }
        else if (['lessons','grades','courses','fields'].includes(FILTER_KEYS[key])) {
            let ids = product[FILTER_KEYS[key]].map((item) => item.id);
            return selectedFilters[key].some(option => ids && ids.includes(option));
        } else if (FILTER_KEYS[key] === 'store_status') {
            return product[FILTER_KEYS[key]] === 'free';
        } else if (FILTER_KEYS[key] === 'name') {
            return product[FILTER_KEYS[key]].includes(selectedFilters[key]);
        } else {
            return selectedFilters[key].some(option => product[FILTER_KEYS[key]] && product[FILTER_KEYS[key]].includes(option));
        }
    };

    /**
     * Function to filter items based on query parameters.
     * @param {Object} items - The items to filter.
     * @param {Object} queries - The query parameters for filtering.
     * @returns {Array} The filtered products.
     */
    const filter = (items, queries) => {
        if (Object.keys(queries).length === 0) {
            filteredProducts.value = items;
        } else {
            const selectedFilters = queryParamDetector(queries);
            filteredProducts.value = items.filter(product =>
                ['course', 'lesson','fields', 'professor', 'grade', 'free', 'search'].every(key =>
                    filterLogic(selectedFilters, key, product)
                )
            );
        }

        return filteredProducts.value;
    };

    // expose managed state as return value
    return { filter };
}
