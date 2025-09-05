
import axiosInstance from "@/config/axios.config";

// The base resource path for the API
const resource = '/v1/user/store';
const resource_core_data = '/v1/core_data';
const resource_store = '/v1/panel';
const resource_package = '/v1/user/package';


/**
 * Repository for store-related API calls.
 * @namespace StoreRepository
 * @property {string} resource - The base resource path for the API.
 */
const StoreRepository = {
    /**
     * Retrieves store products information.
     * Method | get
     * Api address| /api/user/store
     *
     * @function
     * @memberof StoreRepository
     * @name userProfile
     * @returns {Promise} - A promise representing the result of the getProducts API call.
     * @throws Will throw an error if the request fails.
     */
    getProducts(query) {
        return axiosInstance.get(`${resource}`,{
            params: {
                ...query
            }
        });
    },

    /**
     * Retrieves information about a specific product.
     * Method | get
     * Api address| /api/user/store/:product_id
     *
     * @function
     * @memberof StoreRepository
     * @name getProduct
     * @param {string} product_id - The ID of the product.
     * @returns {Promise} A promise representing the result of the getProduct API call.
     * @throws {Error} Will throw an error if the request fails.
     */
    getProduct(product_id) {
        return axiosInstance.get(`${resource}/${product_id}`);
    },

    /**
     * Retrieves information about a specific package.
     * Method | get
     * Api address| /api/user/package/:product_id
     *
     * @function
     * @memberof StoreRepository
     * @name getProduct
     * @param {string} product_id - The ID of the product.
     * @returns {Promise} A promise representing the result of the getPackage API call.
     * @throws {Error} Will throw an error if the request fails.
     */
    getPackage(product_id) {
        return axiosInstance.get(`${resource_package}/show/${product_id}`);
    },

    /**
     * Retrieves information about a specific package.
     * Method | get
     * Api address| /api/user/planz/show/:product_id
     *
     * @function
     * @memberof StoreRepository
     * @name getProduct
     * @param {string} product_id - The ID of the product.
     * @returns {Promise} A promise representing the result of the getPackage API call.
     * @throws {Error} Will throw an error if the request fails.
     */
    getPlanZPackage(product_id) {
        return axiosInstance.get(`${resource_planz_package}/show/${product_id}`);
    },

    /**
     * Retrieves store product's filters information.
     * Method | get
     * Api address| /api/core_data/filter_dropdown
     *
     * @function
     * @memberof StoreRepository
     * @name getProductFilters
     * @returns {Promise} - A promise representing the result of the getProductFilters API call.
     * @throws Will throw an error if the request fails.
     */
    getProductFilters() {
        return axiosInstance.get(`${resource_core_data}/filter_dropdown`);
    },

    /**
     * Purchases a product for free.
     * Method | post
     * Api address| /api/panel/buy/:product_id
     *
     * @function
     * @memberof StoreRepository
     * @name buyForFree
     * @param {string} product_id - The ID of the product to buy for free.
     * @returns {Promise} A promise representing the result of the buyForFree API call.
     * @throws {Error} Will throw an error if the request fails.
     */
    buyForFree(product_id) {
        return axiosInstance.post(`${resource_store}/buy/${product_id}`);
    },

    /**
     * Adds a product to the user's shopping cart.
     * Method | post
     * Api address| /api/panel/cart
     *
     * @function
     * @memberof StoreRepository
     * @name addToCart
     * @param {Object} payload - The payload containing information about the product to add to the cart.
     * @returns {Promise} A promise representing the result of the addToCart API call.
     * @throws {Error} Will throw an error if the request fails.
     */
    addToCart(payload){
        return axiosInstance.post(`${resource_store}/cart`,payload);
    },

    /**
     * Adds a product to the user's shopping cart on redirect after login.
     * Method | post
     * Api address| /api/panel/add_to_user_course/:productId
     *
     * @function
     * @memberof StoreRepository
     * @name addToCart
     * @param {Number} productId - The productId to add to the cart.
     * @returns {Promise} A promise representing the result of the addToCart API call.
     * @throws {Error} Will throw an error if the request fails.
     */
    addToCartOnRedirectAfterLogin(productId){
        return axiosInstance.post(`${resource_store}/add_to_user_course/${productId}`);
    },

    /**
     * Adds a package product to the user's shopping cart.
     * Method | post
     * Api address| /api/panel/package
     *
     * @function
     * @memberof StoreRepository
     * @name addPackageToCart
     * @param {Object} payload - The payload containing information about the product to add to the cart.
     * @returns {Promise} A promise representing the result of the addPackageToCart API call.
     * @throws {Error} Will throw an error if the request fails.
     */
    addPackageToCart(payload){
        return axiosInstance.patch(`${resource_store}/package`,payload);
    },
}

export default StoreRepository;