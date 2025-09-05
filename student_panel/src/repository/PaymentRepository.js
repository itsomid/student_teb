
import axiosInstance from "@/config/axios.config";

// The base resource path for the API
const resource = '/api/panel/cart';
const resource_receipt = '/api/user/finance';


/**
 * Repository for cart-related API calls.
 * @namespace PaymentRepository
 * @property {string} resource - The base resource path for the API.
 */
const PaymentRepository = {

    /**
     * change payment type
     * Method | post
     * Api address| /api/panel/cart/change/type
     *
     * @function
     * @memberof PaymentRepository
     * @name changePaymentMethod
     * @param {Object} payload - The payload containing auth information.
     * @returns {Promise} - A promise representing the result of the changePaymentMethod API call.
     * @throws Will throw an error if the request fails.
     */
    changePaymentMethod(payload) {
        return axiosInstance.post(`${resource}/change/type`,payload);
    },

    /**
     * change payment type
     * Method | post
     * Api address| /api/user/finance/receipt/:receiptId
     *
     * @function
     * @memberof PaymentRepository
     * @name getPaymentReceipt
     * @param {Object} receiptId - The payload containing receiptId information.
     * @returns {Promise} - A promise representing the result of the getPaymentReceipt API call.
     * @throws Will throw an error if the request fails.
     */
    getPaymentReceipt(receiptId) {
        return axiosInstance.get(`${resource_receipt}/receipt/${receiptId}`);
    },
}

export default PaymentRepository;