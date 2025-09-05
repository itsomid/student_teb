
import axiosInstance from "@/config/axios.config";

// The base resource path for the API
const resource = '/api/panel';


/**
 * Repository for panel-related API calls.
 * @namespace PanelRepository
 * @property {string} resource - The base resource path for the API.
 */
const PanelRepository = {
    /**
     * report bug
     * Method | get
     * Api address| /api/panel/bug_reports
     *
     * @function
     * @memberof PanelRepository
     * @name reportBug
     * @returns {Promise} - A promise representing the result of the report bug API call.
     * @throws Will throw an error if the request fails.
     */
    reportBug(payload) {
        return axiosInstance.post(`${resource}/bug_reports`, payload);
    },

}

export default PanelRepository;