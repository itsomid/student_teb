/**
 * @created        17/06/2023 - 12:22
 * @author         Nariman Palangi
 * @user           ragnarok
 * @organization
 * @project        boilerplate-vue-3
 * @file name      theme.js
 * @file dir       src/plugins/vuetify-options
 */

import dark from "./dark";
import light from "./light";
import localStorageService from "@/services/LocalStorage.service";


/** @description import vuetify-options to vuetify instance */
const defaultTheme = localStorageService.get('theme') || 'light'
export default {
    defaultTheme: defaultTheme,
    /** @see how to configure variation
        @tutorial https://vuetifyjs.com/en/features/theme/#color-variations */
    variations: {
        colors: ['primary', 'secondary', 'success', 'error','surface'],
        lighten: 8,
        darken: 5,
    },
    themes: {
        dark: dark,
        light: light,
    },
};
