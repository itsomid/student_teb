
import axiosInstance from "@/config/axios.config";

// The base resource path for the API
const resource = '/api/valle';
/**
 * Repository for valle-related API calls.
 * @namespace ValleRepository
 * @property {string} resource - The base resource path for the API.
 */
const ValleRepository = {

    /**
     * Retrieves a list of user exams.
     * Method | get
     * Api address| /api/valle/:product_id/exams
     *
     * @function
     * @memberof ValleRepository
     * @name getValleExams
     * @returns {Promise} - A promise representing the result of the getValleExams API call.
     * @throws Will throw an error if the request fails.
     */
    getValleExams(product_id) {
        return axiosInstance.get(`${resource}/${product_id}/exams`)
    },
}

export default ValleRepository;