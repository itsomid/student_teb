import {GTAG_CONFIG, GTM_CONFIG} from "@/config/google.analytics.config";
import { createGtm } from "@gtm-support/vue-gtm";

export const initializeAnalytics = (app,router) => {
    app.use(
        createGtm({
            ...GTM_CONFIG,
            vueRouter: router
        })
    );
    // app.use(
    //     VueGtag,
    //     {
    //         ...GTAG_CONFIG
    //     },
    //     router
    // );
}