import { reactive } from "vue";

/**
 * Function to handle action responses.
 *
 * @function
 * @name useActionResponseHandler
 * @returns {Object} An object with methods for handling success and error responses.
 */
export function useActionResponseHandler() {
    const state = reactive({
        data: null,
        isLoading: false,
        error_msg: "",
    });

    /**
     * Handles success response.
     *
     * @function
     * @name onSuccess
     * @param {any} data - The success data.
     * @returns {Promise<Object>} A promise resolving to the updated state.
     */
    function onSuccess(data) {
        Object.assign(state, {
            data: data,
            isLoading: false,
            error_msg: "",
        });
        return Promise.resolve(state);
    }

    /**
     * Handles error response.
     *
     * @function
     * @name onError
     * @param {Object} data - The error data.
     * @returns {Promise<Object>} A promise rejecting with the updated state.
     */
    function onError(data) {
        Object.assign(state, {
            status: data.status,
            errors: data.errors,
            validationErrors: data.validationErrors,
            isLoading: false,
            error_msg: data.message,
        });
        return Promise.reject(state);
    }

    return { onSuccess, onError };
}
