/**
 * @typedef {Object} CookiesFunctions
 * @property {function(string): string} getCookie - Function to get the value of a cookie by name.
 * @property {function(string, any, number): void} saveCookie - Function to save a value to a cookie.
 * @property {function(string): object | null} getRedirectPath - Function to get the value of the "redirect_path" cookie.
 * @property {function(): string | null} getRepresenter - Function to get the value of the "representer" cookie.
 */

/**
 * This module provides utility functions to work with cookies.
 * @module useCookies
 */

import dayjs from "dayjs";
import jalaliday from 'jalaliday'
import utc from "dayjs/plugin/utc";
import timezone from "dayjs/plugin/timezone";
dayjs.extend(jalaliday);
dayjs.extend(utc);
dayjs.extend(timezone);


/**
 * Get the value of a cookie by name.
 * @function
 * @name getCookie
 * @param {string} cname - The name of the cookie.
 * @returns {string} The value of the cookie.
 */
const getCookie = (cname) => {
    const name = cname + "=";
    const decodedCookie = decodeURIComponent(document.cookie);
    const cookieArray = decodedCookie.split(';');
    for (let cookie of cookieArray) {
        cookie = cookie.trim(); // Trim leading spaces
        if (cookie.startsWith(name)) {
            return cookie.substring(name.length);
        }
    }
    return "";
}


/**
 * Save a value to a cookie.
 * @function
 * @name saveCookie
 * @param {string} cname - The name of the cookie.
 * @param {any} value - The value to be saved.
 * @param {number} minutes - The number of minutes until the cookie expires.
 * @returns {void}
 */
const saveCookie = (cname, value, minutes) => {
    // 5 Minutes
    let cookieExp =  dayjs().add(minutes, 'minutes').utc().locale('en').format('ddd, DD MMM YYYY HH:mm:ss [GMT]');
    let cvalue =  JSON.stringify(value)
    document.cookie = `${cname}=${cvalue}; expires=${cookieExp}; path=/`
};

/**
 * Get the value of the "redirect_path" cookie.
 * @function
 * @name getRedirectPath
 * @param {string} [cookie_name="redirect_path"] - The name of the cookie.
 * @returns {object | null} The parsed JSON value of the cookie, or `null` if the cookie is not found.
 */
const getRedirectPath = (cookie_name = "redirect_path") => {
    let val = getCookie(cookie_name)
    return val ? JSON.parse(val) : null
}

/**
 * Get the value of the "representer" cookie.
 * @function
 * @name getRepresenter
 * @returns {string | null} The representative value parsed from the cookie, or `null` if the cookie is not found.
 */
const getRepresenter = () => {
    let val = getCookie('representer')

    return val ? JSON.parse(val).representer : null
}

const removeCookie = ()=>{
    document.cookie = "redirect_path=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
}

/**
 * A hook that provides functions to work with cookies.
 * @function
 * @name useCookies
 * @returns {CookiesFunctions} An object containing functions to work with cookies.
 */
export const useCookies = ()=> {
    return {
        getCookie,
        saveCookie,
        getRedirectPath,
        getRepresenter,
        removeCookie
    }
}