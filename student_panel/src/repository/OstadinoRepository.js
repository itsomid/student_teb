
import axiosInstance from "@/config/axios.config";


// The base resource path for the API
const resource = '/api/site/ostadino';
const resource_rate = '/api/panel/ostadino';

/**
 * Repository for ostadino-related API calls.
 * @namespace OstadinoRepository
 * @property {string} resource - The base resource path for the API.
 */
const OstadinoRepository = {

    /**
     * Retrieves details of a ostadino steps.
     * Method | get
     * Api address| /api/website/ostadino/steps
     *
     * @function
     * @memberof OstadinoRepository
     * @name getSteps
     * @returns {Promise} A promise representing the result of the getSteps API call.
     * @throws {Error} Will throw an error if the request fails.
     */
    getSteps() {
        return axiosInstance.get(`${resource}/steps`)
    },

    /**
     * Retrieves details of  ostadino videos.
     * Method | get
     * Api address| /api/website/ostadino/:level/video
     *
     * @function
     * @memberof OstadinoRepository
     * @name getVideos
     * @param level {Number}
     * @param query {Object}
     * @returns {Promise} A promise representing the result of the getVideos API call.
     * @throws {Error} Will throw an error if the request fails.
     */
    getVideos(level,query = null) {
        return axiosInstance.get(`${resource}/${level}/videos`,{
            params: {
                ...query
            }
        })
    },

    /**
     * Retrieves details of  ostadino video.
     * Method | get
     * Api address| /api/website/ostadino/:level/video/:video_id
     *
     * @function
     * @memberof OstadinoRepository
     * @name getVideoById
     * @param level {Number}
     * @param id {Number}
     * @returns {Promise} A promise representing the result of the getVideoById API call.
     * @throws {Error} Will throw an error if the request fails.
     */
    getVideoById(level,id) {
        return axiosInstance.get(`${resource}/videos/${id}`)
    },

    /**
     * Retrieves details of  ostadino teachers.
     * Method | get
     * Api address| /api/website/ostadino/teachers/:level
     *
     * @function
     * @memberof OstadinoRepository
     * @name getTeachers
     * @param level {Number}
     * @param query {Object}
     * @returns {Promise} A promise representing the result of the getTeachers API call.
     * @throws {Error} Will throw an error if the request fails.
     */
    getTeachers(level,query = null) {
        return axiosInstance.get(`${resource}/teachers/${level}`,{
            params: {
                ...query
            }
        })
    },

    /**
     * rate teachers
     * Method | post
     * Api address| /api/panel/ostadino/teachers
     *
     * @function
     * @memberof OstadinoRepository
     * @name rating
     * @param payload {Object}
     * @returns {Promise} A promise representing the result of the rating API call.
     * @throws {Error} Will throw an error if the request fails.
     */
    rating(payload){
        return axiosInstance.post(`${resource_rate}/rates`, payload)
    }
}

export default OstadinoRepository;