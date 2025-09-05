import jwtDefaultConfig from '@/config/jwtDefaultConfig'
import {useCookies} from "@/composable/useCookies";
const { removeCookie } = useCookies();
/**
 * Service class for handling JWT authentication.
 *
 * @class JwtService
 */
export default class JwtService {
    /**
     * JWT configuration object.
     *
     * @type {Object}
     * @private
     */
    jwtConfig = { ...jwtDefaultConfig }

    /**
     * Flag indicating whether an access token is being fetched.
     *
     * @type {boolean}
     * @private
     */
    isAlreadyFetchingAccessToken = false

    /**
     * List of subscribers waiting for the access token.
     *
     * @type {Function[]}
     * @private
     */
    subscribers = []

    /**
     * Creates an instance of JwtService.
     *
     * @param {Object} jwtOverrideConfig - Override configuration for JWT.
     */
    constructor( jwtOverrideConfig) {
        this.jwtConfig = { ...this.jwtConfig, ...jwtOverrideConfig }
    }

    /**
     * Callback function to handle fetching of access token.
     *
     * @private
     * @param {string} accessToken - The fetched access token.
     * @returns {void}
     */
    onAccessTokenFetched(accessToken) {
        this.subscribers = this.subscribers.filter(callback => callback(accessToken))
    }

    /**
     * Adds a subscriber waiting for the access token.
     *
     * @private
     * @param {Function} callback - Callback function to be invoked when access token is fetched.
     * @returns {void}
     */
    addSubscriber(callback) {
        this.subscribers.push(callback)
    }

    /**
     * Retrieves the stored JWT access token from local storage.
     *
     * @returns {string|null} The JWT access token if available, otherwise null.
     */
    getToken() {
        return localStorage.getItem(this.jwtConfig.STORAGE_TOKEN_KEY_NAME)
    }

    /**
     * Retrieves the stored JWT refresh token from local storage.
     *
     * @returns {string|null} The JWT refresh token if available, otherwise null.
     */
    getRefreshToken() {
        return localStorage.getItem(this.jwtConfig.STORAGE_REFRESH_TOKEN_KEY_NAME)
    }

    /**
     * Stores the JWT access token in local storage.
     *
     * @param {string} value - The JWT access token to be stored.
     * @returns {void}
     */
    setToken(value) {
        localStorage.setItem(this.jwtConfig.STORAGE_TOKEN_KEY_NAME, value);
    }

    /**
     * Remove the JWT access token in local storage.
     * @returns {void}
     */
    removeToken() {
        localStorage.removeItem(this.jwtConfig.STORAGE_TOKEN_KEY_NAME);
        removeCookie();
    }

    /**
     * Stores the JWT refresh token in local storage.
     *
     * @param {string} value - The JWT refresh token to be stored.
     * @returns {void}
     */
    setRefreshToken(value) {
        localStorage.setItem(this.jwtConfig.STORAGE_REFRESH_TOKEN_KEY_NAME, value)
    };

    logout() {
        localStorage.clear();
        removeCookie();
    }
}
