/**
 * @created        15/09/2023 - 18:09
 * @author         Nariman Palangi
 * @user           ragnarok
 * @organization
 * @project        boilerplate-vue-3
 * @file name      useLayout.js
 * @file dir       src/composable
 */

import { ref } from "vue";

/**
 * Enum representing different layout types.
 * @readonly
 * @enum {Symbol}
 */
export const LAYOUTS = {
    standard: Symbol("default"),
    auth: Symbol("auth"),
};

/**
 * Reference to the current layout type.
 * @type {Ref<Symbol>}
 */
const layout = ref(LAYOUTS.standard);

/**
 * Function to set the layout type.
 * @param {Symbol} layoutType - The layout type to set.
 */
const setLayout = (layoutType) => {
    layout.value = layoutType;
};

/**
 * Composable function for managing layouts.
 * @function
 * @name useLayout
 * @returns {object} An object containing references and functions related to layouts.
 */
export const useLayout = () => {
    return {
        layout,
        setLayout,
        LAYOUTS,
    };
};
