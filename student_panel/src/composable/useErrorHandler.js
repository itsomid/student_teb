import { useRouter } from "vue-router";
import useJwt from "@/composable/useJwt";
import { useAlert } from "@/composable/useAlert";
import { MESSAGE } from "@/constants/apiResponseMessages";


/**
 * @created        16/09/2023 - 17:09
 * @author         Nariman Palangi
 * @user           ragnarok
 * @organization
 * @project        Azmiun
 * @file name      useErrorHandler.js
 * @file dir       src/composable
 */





/**
 * Class representing a server error.
 */
class ServerError {
    /**
     * Create a server error.
     * @param {number} status - The HTTP status code.
     * @param {string} message - The error message.
     * @param {object} errors - Additional error details.
     * @param {array} validationErrors - Validation errors.
     * @param {object} data - errors data.
     */
    constructor(status, message, errors, validationErrors = []) {
        this.status = +status;
        this.message = message;
        this.errors = errors;
        this.validationErrors = validationErrors;
    }
}

/**
 * Handles API responses and errors.
 * @type {Object}
 */

const useApiResponseHandler = {

    /**
     * Handle errors.
     * @param {object} result - The result object.
     * @returns {Promise} A rejected promise with error details.
     */
    error(result) {
// Handler for server or connection errors
        const router = useRouter();
        try {
            let error = new ServerError(
                result.response.status,
                result.response.data.message || result.response.data.error,
                result.response.data.errors,
                result.response.data
            );

            if (+result.response.status === 401) {
                const { error } = useAlert();
                useJwt.removeToken();
                error(MESSAGE.UNAUTHORIZED);
                return window.location.href= window.location.origin+'/auth'
            }

            return Promise.reject({
                error: error,
                header: result.response.headers,
            });
        } catch (e) {
            return Promise.reject({
                error: e,
                header: result.response.headers,
            });
        }
    },

    /**
     * Handle successful responses.
     * @param {object} result - The result object.
     * @returns {object} Response headers and data.
     */
    response(result) {
        try {
            return {
                headers: result.headers,
                data: result.data,
            };
        } catch (e) {
            return Promise.reject(result);
        }
    },
};

export { useApiResponseHandler };
