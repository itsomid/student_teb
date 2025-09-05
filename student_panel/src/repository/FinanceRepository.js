
import axiosInstance from "@/config/axios.config";

// The base resource path for the API
const resource = '/api/user/finance';


/**
 * Repository for finance-related API calls.
 * @namespace FinanceRepository
 * @property {string} resource - The base resource path for the API.
 */
const FinanceRepository = {
    /**
     * Retrieves user profile information.
     * Method | get
     * Api address| /api/user/finance/header
     *
     * @function
     * @memberof FinanceRepository
     * @name getFinanceBrief
     * @returns {Promise} - A promise representing the result of the getFinanceBrief API call.
     * @throws Will throw an error if the request fails.
     */
    getFinanceBrief() {
        return axiosInstance.get(`${resource}/header`);
    },

    /**
     * Retrieves user profile information.
     * Method | get
     * Api address| /api/user/finance/:type
     *
     * @function
     * @memberof FinanceRepository
     * @name getFinance
     * @param type {String}
     * @returns {Promise} - A promise representing the result of the getFinance API call.
     * @throws Will throw an error if the request fails.
     */
    getFinance(type) {
        return axiosInstance.get(`${resource}/${type}`);
    },

}

export default FinanceRepository;