import router from '../router/index'

/**
 * @description The global site tag (gtag.js) is a JavaScript tagging framework and API
 * that allows you to send event data to Google Analytics, Google Ads,
 * and Google Marketing Platform. For general gtag.js [documentation](https://developers.google.com/analytics/devguides/collection/gtagjs),
 * read the gtag.js developer guide.
 * to see all config options
 * @tutorial https://matteo-gabriele.gitbook.io/vue-gtag/v/master/plugin-options
 * */
export const GTAG_CONFIG = {
    config: {
        /**
         * @param id {String} google analytics UA id
         * */
        id: import.meta.env.VITE_APP_UA_ID || "UA-121613918-1",


        /**
         * * @param deferScriptLoad {boolean} The defer attribute is a boolean attribute.
         * If the defer attribute is set, it specifies that the script is downloaded
         * in parallel to parsing the page, and executed after the page has finished parsing.
         * */
        deferScriptLoad: true,
    },
}




export const GTM_CONFIG = {
    /**
     * @param id {String, Array}
     * Your GTM single container ID, array of container ids ['GTM-xxxxxx', 'GTM-yyyyyy'] or
     * array of objects [{id: 'GTM-xxxxxx', queryParams: { gtm_auth: 'abc123', gtm_preview: 'env-4', gtm_cookies_win: 'x'}},
     * {id: 'GTM-yyyyyy', queryParams: {gtm_auth: 'abc234', gtm_preview: 'env-5', gtm_cookies_win: 'x'}}],
     * Your GTM single container ID or array of container ids ['GTM-xxxxxx', 'GTM-yyyyyy']
     * */
    id: import.meta.env.VITE_APP_GTM_ID || "GTM-52WQDC2",

    /**
     * @param defer {boolean}
     * Script can be set to `defer` to speed up page load at the cost of less accurate results
     * (in case visitor leaves before script is loaded, which is unlikely but possible).
     * Defaults to false, so the script is loaded `async` by default
     * */
    defer: true,

    /**
     * @param enabled {boolean}
     * defaults to true. Plugin can be disabled by setting this to false
     * for Ex: enabled: !!GDPR_Cookie (optional)
     * */
    enabled: true,

    /**
     * @param debug {boolean}
     * Whether or not display console logs debugs (optional)
     * */
    debug: false,


    /**
     * @param loadScript {boolean}
     *  Whether or not to load the GTM Script (Helpful if you are including GTM manually,
     *  but need the dataLayer functionality in your components) (optional)
     * */
    loadScript: true,

    /**
     * @param vueRouter {router}
     * Pass the router instance to automatically sync with router (optional)
     * */
    vueRouter: router,

    /**
     * @param trackOnNextTick {boolean}
     * Whether or not call trackView in Vue.nextTick
     * */
    trackOnNextTick: false,
}