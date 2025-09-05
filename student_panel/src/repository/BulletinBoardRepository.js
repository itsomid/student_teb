import axiosInstance from "@/config/axios.config";

// The base resource path for the API
const resource = '/v1/dashboard';


/**
 * Repository for bulletin-board-related API calls.
 * @namespace BulletinBoardRepository
 * @property {string} resource - The base resource path for the API.
 */
const BulletinBoardRepository = {
    /**
     * get user today classes
     * Method | get
     * Api address| /api/dashboard/live_classes_product_today
     *
     * @function
     * @memberof BulletinBoardRepository
     * @name getUserTodayClasses
     * @returns {Promise} - A promise representing the result of the getUserTodayClasses API call.
     * @throws Will throw an error if the request fails.
     */
    getUserTodayClasses() {
        return axiosInstance.get(`${resource}/live_classes_product_today`);
    },

    /**
     * get user classes within month
     * Method | get
     * Api address| /api/dashboard/classes_within_month
     *
     * @function
     * @memberof BulletinBoardRepository
     * @name getUserClassesWithinMonth
     * @returns {Promise} - A promise representing the result of the getUserClassesWithinMonth API call.
     * @throws Will throw an error if the request fails.
     */
    getUserClassesWithinMonth() {
        return axiosInstance.get(`${resource}/classes_within_month`);
    },

    /**
     * get user classes within week
     * Method | get
     * Api address| /api/dashboard/live_class_within_week
     *
     * @function
     * @memberof BulletinBoardRepository
     * @name getUserClassesWithinWeek
     * @returns {Promise} - A promise representing the result of the getUserClassesWithinWeek API call.
     * @throws Will throw an error if the request fails.
     */
    getUserClassesWithinWeek(params) {
        return axiosInstance.get(`${resource}/live_class_within_week`, {
            params: {
                ...params
            }
        });
    },
}

export default BulletinBoardRepository;