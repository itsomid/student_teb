import axios from "axios";
import { useCookies } from '@/composable/useCookies'; // Cookie handling functions

/**
 * A composable function that provides methods for handling UTM_MA (User Tracking Medium Analytics) data.
 *
 * @typedef {object} UseUTMMAType
 * @property {Function} saveUTMMA - Saves UTM_MA to the local storage.
 * @property {Function} sendUTMMA - Sends UTM_MA data to a specified endpoint.
 */

/**
 * UseCookies composable function to get redirect path after successful login.
 *
 * @type {UseCookiesType}
 * @constant
 */
const { getCookie } = useCookies();

/**
 * Creates a composable function for handling UTM_MA data.
 *
 * @function
 * @name useUTMMA
 * @returns {UseUTMMAType} - Object containing functions for handling UTM_MA data.
 */
export function useUTMMA() {

    /**
     * Saves UTM_MA to the local storage.
     *
     * @function
     * @name saveUTMMA
     * @param {string} utm_ma - UTM_MA to be saved.
     */
    function saveUTMMA(utm_ma = ""){
        if (utm_ma) {
            localStorage.setItem('utm_ma', JSON.stringify(utm_ma));
        }
    }

    /**
     * Sends UTM_MA data to a specified endpoint.
     *
     * @async
     * @function
     * @name sendUTMMA
     * @returns {Promise<void>}
     */
    async function sendUTMMA(){
        const redirectPath = !!getCookie('redirect_path') ? JSON.parse(getCookie('redirect_path')) : false;

        let iid = "";

        if (!!redirectPath && !!redirectPath.query && !!redirectPath.query.utm_ma) {
            iid = redirectPath.query.utm_ma;
        } else {
            iid = localStorage.getItem('utm_ma')
        }
        const actionName = "register";
        const payload = {
            actionName: actionName,
            clickId: iid,
        }
        if (iid) {
            try {
                await axios.get(`https://s1.mediaad.org/v1/events/post-back`, {
                    params: {
                        ...payload
                    }
                });
                localStorage.removeItem('utm_ma');
            } catch (error) {
                console.log("FAILED TO SEND UTM_MA: ", error);
            }
        }
    }


    return {
        saveUTMMA,
        sendUTMMA
    }
}