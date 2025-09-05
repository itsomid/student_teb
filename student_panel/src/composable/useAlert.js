/**
 * @created        15/09/2023 - 18:57
 * @author         Nariman Palangi
 * @user           ragnarok
 * @organization
 * @project        boilerplate-vue-3
 * @file name      useAlert.js
 * @file dir       src/composable
 */

import store from "../store";

/**
 * @typedef {Object} AlertTypes
 * @property {string} success - Represents a success alert.
 * @property {string} error - Represents an error alert.
 * @property {string} warning - Represents a warning alert.
 * @property {string} info - Represents an info alert.
 */

/**
 * @constant {AlertTypes} ALERT_TYPES - Different types of alerts.
 */
const ALERT_TYPES = {
    success: "success",
    error: "error",
    warning: "warning",
    info: "info"
};

/**
 * Time (in milliseconds) to wait until snackbar is automatically hidden.
 * Use -1 to keep open indefinitely (0 in version < 2.3).
 * It is recommended for this number to be between 6000 and 10000.
 * Changes to this property will reset the timeout.
 * @constant {Number} TIMEOUT - Timeout duration for alerts.
 */
const TIMEOUT = 6000;

/**
 * @namespace useAlert
 * @description A composable function for setting alert data by mutating alert state in the store.
 * @property {Function} success - Sets a success alert.
 * @property {Function} error - Sets an error alert.
 * @property {Function} warning - Sets a warning alert.
 * @property {Function} info - Sets an info alert.
 */
export function useAlert() {
    /**
     * Sets a success alert.
     * @param {string} text - The text content of the alert.
     * @param {Number} timeout - The duration for which the alert will be visible (in milliseconds).
     */
    function success(text, timeout = TIMEOUT) {
        store.commit("alert/CHANGE_ALERT_DATA", { text, type: ALERT_TYPES.success, timeout });
    }

    /**
     * Sets an error alert.
     * @param {string} text - The text content of the alert.
     * @param {Number} timeout - The duration for which the alert will be visible (in milliseconds).
     */
    function error(text, timeout = TIMEOUT) {
        store.commit("alert/CHANGE_ALERT_DATA", { text, type: ALERT_TYPES.error, timeout });
    }

    /**
     * Sets a warning alert.
     * @param {string} text - The text content of the alert.
     * @param {Number} timeout - The duration for which the alert will be visible (in milliseconds).
     */
    function warning(text, timeout = TIMEOUT) {
        store.commit("alert/CHANGE_ALERT_DATA", { text, type: ALERT_TYPES.warning, timeout });
    }

    /**
     * Sets an info alert.
     * @param {string} text - The text content of the alert.
     * @param {Number} timeout - The duration for which the alert will be visible (in milliseconds).
     */
    function info(text, timeout = TIMEOUT) {
        store.commit("alert/CHANGE_ALERT_DATA", { text, type: ALERT_TYPES.info, timeout });
    }

    return {
        success,
        error,
        warning,
        info
    }
};
