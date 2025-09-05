import { useCookies } from "@/composable/useCookies";
import {COOKIES} from "@/constants/app.const";
import {useReagent} from "@/composable/useReagent";
import {useUTMMA} from "@/composable/useUTMMA";

const { saveCookie } = useCookies();

const cookie_exp_minutes = COOKIES.COOKIE_EXP_MINUTES
const cookie_name = 'redirect_path'



/**
 * Handles the redirection after a successful login based on the provided route information.
 *
 * @function
 * @name handleRedirectAfterLogin
 * @param {object} to - The target route object.
 * @param {object} from - The source route object.
 * @param {function} next - The callback function to continue the navigation.
 */
export const handleRedirectAfterLogin = (to, from, next) => {
    /**
     * @typedef {object} RouteParams
     * @property {string} value - The value parameter from the route.
     * @property {object} query - The query parameters from the route.
     * @property {string} representer - The representer parameter from the route.
     * @property {string} pathWanted - The path from the route.
     */

    const {  saveUTMMA  } = useUTMMA();

    // Extracting values from the route object
    const value         = to.params.value
    const query         = to.query
    const representer   = to.params.representer
    const regentCode    = to.query.representer  //reprsenter for ostadino redirect after login
    const pathWanted    = to.path

    const params = new URLSearchParams(value)
    let pathMustRedirect

    if (!pathWanted.includes('/redirectAfterLogin')) {
        return next()
    }
    // Handle different cases based on the path
    switch (pathWanted.split('/')[2]) {
        case 'store':
            // redirectAfterLogin/store/lesson=38,40&grade=129
            const storeParams = paramToQueryParams(params);
            pathMustRedirect = {name: 'store', query: {...storeParams} }
            break
        case 'live_stream':
            pathMustRedirect = {name: 'joinCC', params:{class_id: value}, query}
            break;

        case 'buy':
            pathMustRedirect = {name: 'addToCartOnRedirectAfterLogin', params:{product_id: value}, query}
            break;

        case 'form':
            pathMustRedirect = {name: 'forms', params:{form_id: value}, query}
            break;

        case 'class':
            pathMustRedirect = {name: 'show-class', params: {id: value},query}
            break;

        case 'quiz':
            pathMustRedirect = {name: 'quiz', params: {quiz_id: value}, query};
            break;

        case 'dashboard':
            pathMustRedirect = {name: 'dashboard'}
            break;
        case 'package':
            pathMustRedirect = {name: 'package', params: {id: value}, query}
            break;
        case 'package-planz':
            pathMustRedirect = {name: 'package.planz', params: {id: value}, query}
            break;
        case 'ostadino_set_rate':
            pathMustRedirect = {name: 'ostadino.set-rate', query:{...query}}
            break;
        case 'book_fair':
            pathMustRedirect = {name: 'book-fair', query:{...query}}
            break;
        default:
            pathMustRedirect = {name: 'dashboard',query}
    }

    // // Save cookies for redirection for 5 Minutes
    saveCookie(cookie_name, pathMustRedirect, cookie_exp_minutes)
    saveUTMMA(query);
    if (representer) {
        saveCookie("representer", {representer}, cookie_exp_minutes);
    }

    //reprsenter for ostadino redirect after login
    if(regentCode){
        const { setReagentCode } = useReagent();
        setReagentCode(regentCode);
    }

    // Continue with the redirection
   next(pathMustRedirect)
}


/**
 * Converts an array of parameter pairs to an object representing query parameters.
 *
 * @function
 * @name paramToQueryParams
 * @param {Array<Array<string, any>>} params - An array of parameter pairs, where each pair is represented as [key, value].
 * @returns {Object} An object containing query parameters, where keys are parameter names and values are either single values or arrays of values.
 */
const paramToQueryParams = (params) => {
    const storeParams = {}
    for (const param of params) {
        if (storeParams.hasOwnProperty(param[0])) {
            if (Array.isArray(storeParams[param[0]])) {
                // If the parameter already exists as an array, append the new value to the array.
                storeParams[param[0]].push(param[1])
            } else {
                // If the parameter exists as a single value, convert it to an array with both values.
                storeParams[param[0]] = [storeParams[param[0]], param[1]]
            }
        } else {
            // If the parameter does not exist, create a new entry with the key and value.
            storeParams[param[0]] = param[1]
        }
    }
    return storeParams;
}