
import axiosInstance from "@/config/axios.config";

// The base resource path for the API
const resource = '/v1/dashboard';


/**
 * Repository for baner-related API calls.
 * @namespace BannerRepository
 * @property {string} resource - The base resource path for the API.
 */
const BannerRepository = {
    /**
     * get
     * Method | get banner
     * Api address| /api/dashboard/banners/:type
     *
     * @function
     * @memberof BannerRepository
     * @name getBanner
     * @returns {Promise} - A promise representing the result of the getBanner API call.
     * @throws Will throw an error if the request fails.
     */
    getBanner(type) {
        return axiosInstance.get(`${resource}/banners/${type}`);
    },

    /**
     * get
     * Method | get banner
     * Api address| /api/dashboard/banners/:type
     *
     * @function
     * @memberof BannerRepository
     * @name getClassBanner
     * @param {string} courseId - ID of the course to retrieve details for.
     * @returns {Promise} - A promise representing the result of the getClassBanner API call.
     * @throws Will throw an error if the request fails.
     */
    getClassBanner(courseId) {
        return axiosInstance.get(`${resource}/banners/class/${courseId}`);
    },
}

export default BannerRepository;