
import axiosInstance from "@/config/axios.config";

// The base resource path for the API
const resource = '/api/user/cart';
const resource_action = '/api/panel/cart';


/**
 * Repository for cart-related API calls.
 * @namespace CartRepository
 * @property {string} resource - The base resource path for the API.
 */
const CartRepository = {
    /**
     * get user cart
     * Method | get
     * Api address| /api/user/cart
     *
     * @function
     * @memberof CartRepository
     * @name getUserCart
     * @returns {Promise} - A promise representing the result of the getUserCart API call.
     * @throws Will throw an error if the request fails.
     */
    getUserCart() {
        return axiosInstance.get(`${resource}`);
    },

    /**
     * get user cart items
     * Method | get
     * Api address| /api/user/cart/count
     *
     * @function
     * @memberof CartRepository
     * @name getUserCartItemsCount
     * @returns {Promise} - A promise representing the result of the getUserCartItemsCount API call.
     * @throws Will throw an error if the request fails.
     */
    getUserCartItemsCount() {
        return axiosInstance.get(`${resource}/count`);
    },

    /**
     * remove item from cart
     * Method | delete
     * Api address| /api/panel/cart/:product_id
     *
     * @function
     * @memberof CartRepository
     * @name removeCartItem
     * @param {String} productId - The productId that will be removed.
     * @returns {Promise} - A promise representing the result of the removeCartItem API call.
     * @throws Will throw an error if the request fails.
     */
    removeCartItem(productId) {
        return axiosInstance.delete(`${resource_action}/${productId}`);
    },

    /**
     * add discount
     * Method | post
     * Api address| /api/panel/cart/coupon/add
     *
     * @function
     * @memberof CartRepository
     * @name addDiscount
     * @param {Object} payload - The discount that added to cart.
     * @returns {Promise} - A promise representing the result of the addDiscount API call.
     * @throws Will throw an error if the request fails.
     */
    addDiscount(payload) {
        return axiosInstance.post(`${resource_action}/coupon/add`,payload);
    },

    /**
     * remove discount from cart
     * Method | delete
     * Api address| /api/panel/cart/coupon/remove
     *
     * @function
     * @memberof CartRepository
     * @name removeDiscount
     * @returns {Promise} - A promise representing the result of the removeDiscount API call.
     * @throws Will throw an error if the request fails.
     */
    removeDiscount() {
        return axiosInstance.post(`${resource_action}/coupon/remove`);
    },

    /**
     * check discount
     * Method | post
     * Api address| /api/panel/cart/coupon/add
     *
     * @function
     * @memberof CartRepository
     * @name checkDiscount
     * @param {Object} payload - The discount that added to cart.
     * @returns {Promise} - A promise representing the result of the checkDiscount API call.
     * @throws Will throw an error if the request fails.
     */
    checkDiscount(payload) {
        return axiosInstance.post(`${resource_action}/coupon/add`,payload);
    },

}

export default CartRepository;