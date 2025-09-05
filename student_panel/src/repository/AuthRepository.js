
import axiosInstance from "@/config/axios.config";

// The base resource path for the API
const resource = '';


/**
 * Repository for authentication-related API calls.
 * @namespace AuthRepository
 * @property {string} resource - The base resource path for the API.
 */
const AuthRepository = {
    /**
     * Initiates auth process.
     * Method | POST
     * Api address| /api/auth
     *
     * @function
     * @memberof AuthRepository
     * @name auth
     * @param {Object} payload - The payload containing auth information.
     * @returns {Promise} - A promise representing the result of the auth API call.
     * @throws Will throw an error if the request fails.
     */
    auth(payload) {
        return axiosInstance.post(`${resource}/auth`, payload);
    },

    /**
     * Initiates login process using a password.
     *
     * Method: POST
     * Api Address: /api/password-login
     *
     * @function
     * @memberof AuthRepository
     * @name loginWithPassword
     * @param {Object} payload - The payload containing login information.
     * @returns {Promise} - A promise representing the result of the password login API call.
     * @throws Will throw an error if the request fails.
     */
    loginWithPassword(payload) {
        return axiosInstance.post(`${resource}/password_login`, payload);
    },

    /**
     * Initiates otp process.
     * Method | POST
     * Api address| /api/send_otp
     *
     * @function
     * @memberof AuthRepository
     * @name sendOtp
     * @param {Object} payload - The payload containing login information.
     * @returns {Promise} - A promise representing the result of the login API call.
     * @throws Will throw an error if the request fails.
     */
    sendOtp(payload) {
        return axiosInstance.post(`${resource}/send_otp`, payload);
    },

    /**
     * Requests the lock time for OTP resend.
     * Method | POST
     * Api address| /api/lockTime
     *
     * @function
     * @memberof AuthRepository
     * @name lockTime
     * @param {Object} payload - The payload containing relevant information for lock time request.
     * @returns {Promise} - A promise representing the result of the lock time request API call.
     * @throws Will throw an error if the request fails.
     */

    lockTime(payload) {
        return axiosInstance.post(`${resource}/lock_time`, payload);
    },

    /**
     * Initiates OTP login process.
     * Method | POST
     * Api address| /api/otp_login
     *
     * @function
     * @memberof AuthRepository
     * @name otpLogin
     * @param {Object} payload - The payload containing OTP login information.
     * @returns {Promise} - A promise representing the result of the OTP login API call.
     * @throws Will throw an error if the request fails.
     */
    otpLogin(payload) {
        return axiosInstance.post(`${resource}/otp_login`, payload);
    },

    /**
     * Reloads the captcha for authentication.
     * Method: GET
     * Api Address: /api/captcha-reload
     *
     * @function
     * @memberof AuthRepository
     * @name reloadCaptcha
     * @returns {Promise} - A promise representing the result of the captcha reload API call.
     * @throws Will throw an error if the request fails.
     */
    reloadCaptcha() {
        return axiosInstance.get(`${resource}/captcha_reload`);
    },

    /**
     * Initiates OTP registration process.
     * Method: POST
     * Api Address: /api/otp_register
     *
     * @function
     * @memberof AuthRepository
     * @name otpRegister
     * @param {Object} payload - The payload containing OTP registration information.
     * @returns {Promise} - A promise representing the result of the OTP registration API call.
     * @throws Will throw an error if the request fails.
     */

    otpRegister(payload) {
        return axiosInstance.post(`${resource}/otp_register`, payload);
    },

    /**
     * Registers a new user.
     *
     * Method: POST
     * Api Address: /api/register
     *
     * @function
     * @memberof AuthRepository
     * @name register
     * @param {Object} payload - The payload containing user registration information.
     * @returns {Promise} - A promise representing the result of the user registration API call.
     * @throws Will throw an error if the request fails.
     */
    register(payload) {
        return axiosInstance.post(`${resource}/registering`, payload);
    },

    /**
     * change user password.
     *
     * Method: POST
     * Api Address: /api/password-update
     *
     * @function
     * @memberof AuthRepository
     * @name changePassword
     * @param {Object} payload - The payload containing user new passwrod.
     * @returns {Promise} - A promise representing the result of the user changePassword API call.
     * @throws Will throw an error if the request fails.
     */
    changePassword(payload) {
        return axiosInstance.post(`${resource}/password-update`, payload);
    }

}

export default AuthRepository;