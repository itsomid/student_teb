import axiosInstance from "@/config/axios.config";

// The base resource path for the API
const resource = '/user_profile';
const resource_update = '/panel';
const resource_reagent = '/site/reagent-code'
const resource_check_vpn = '/site/user/status'

/**
 * Repository for user-related API calls.
 * @namespace UserRepository
 * @property {string} resource - The base resource path for the API.
 */
const UserRepository = {
    /**
     * Retrieves user profile information.
     * Method | get
     * Api address| /api/user_profile/show
     *
     * @function
     * @memberof UserRepository
     * @name userProfile
     * @returns {Promise} - A promise representing the result of the userProfile API call.
     * @throws Will throw an error if the request fails.
     */
    userProfile() {
        return axiosInstance.get(`${resource}/show`);
    },

    /**
     * Retrieves user profile support information.
     * Method | get
     * Api address| /api/user_profile/support
     *
     * @function
     * @memberof UserRepository
     * @name userSupport
     * @returns {Promise} - A promise representing the result of the userProfile support API call.
     * @throws Will throw an error if the request fails.
     */
    userSupport() {
        return axiosInstance.get(`${resource}/support`);
    },

    /**
     * Retrieves support information.
     * Method | get
     * Api address| /api/site/reagent-code
     *
     * @function
     * @memberof UserRepository
     * @name getSupportByReagentCode
     * @returns {Promise} - A promise representing the result of the getSupportByReagentCode support API call.
     * @throws Will throw an error if the request fails.
     */
    getSupportByReagentCode(reagent_code) {
        return axiosInstance.get(`${resource_reagent}/${reagent_code}`);
    },


    /**
     * updateAvatar
     * Method | PATCH
     * Api address| /api/user/update
     *
     * @function
     * @memberof UserRepository
     * @name updateProfile
     * @param {Object} payload - The payload containing updated user information.
     * @returns {Promise} - A promise representing the result of the updateProfile API call.
     * @throws Will throw an error if the request fails.
     */
    updateProfile(payload) {
        return axiosInstance.patch(`${resource_update}/profile`, payload);
    },

    /**
     * updateGrade
     * Method | PATCH
     * Api address| /api/panel/profile/grade-and-field
     *
     * @function
     * @memberof UserRepository
     * @name updateGrade
     * @param {Object} payload - The payload containing updated user information.
     * @returns {Promise} - A promise representing the result of the updateGrade API call.
     * @throws Will throw an error if the request fails.
     */
    updateGrade(payload) {
        return axiosInstance.patch(`${resource_update}/profile/grade-and-field`, payload);
    },
    /**
     * check connection for vpn.
     *
     * Method: GET
     * Api Address: /api/site/user/status

     * @function
     * @memberof UserRepository
     * @name checkVpnBeforeLogin
     * @returns {Promise} - A promise representing the result of the checkVpnBeforeLogin check vpn API call.
     * @throws Will throw an error if the request fails.
     */
    checkVpnBeforeLogin() {
        return axiosInstance.get(`${resource_check_vpn}/check-vpn`);
    }
}

export default UserRepository;