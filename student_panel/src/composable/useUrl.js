/**
 * Utility function for building image URLs.
 *
 * @typedef {Object} UrlFunctions
 * @property {function(image: string): string} imageUrlBuilder - Function to build an image URL based on the provided image path.
 * @property {function(image: string): string} defaultImageUrlBuilder - Function to build a default image URL based on the provided image path.
 */

import {FILE_PATH} from "@/config/filePath.config";

/**
 * Provides utility functions for working with URLs related to images.
 *
 * @returns {UrlFunctions} An object containing functions for building image URLs.
 */
export function useUrl() {
    /**
     * Builds an image URL using the specified image path.
     *
     * @param {string} image - The image name.
     * @param {string} path - The path to the image.
     * @returns {string} The constructed image URL.
     */
    function imageUrlBuilder(image, path) {
        return `${import.meta.env.VITE_APP_STORE_FOUR_BASE_URL}/${FILE_PATH[path]}/${image}`;
    }

    /**
     * Builds a default image URL using the specified image path relative to the current module's URL.
     *
     * @param {string} image - The path to the image.
     * @returns {string} The constructed default image URL.
     */
    function defaultImageUrlBuilder(image) {
        return new URL(`../${image}`, import.meta.url).href;
    }

    /**
     * Builds a file URL using the specified image path.
     *
     * @param {string} image - The image name.
     * @param {string} path - The path to the image.
     * @returns {string} The constructed image URL.
     */
    function fileUrlBuilder(image, path) {
        return `${import.meta.env.VITE_APP_STORE_FOUR_BASE_URL}/${FILE_PATH[path]}/${image}`;
    }


    function introduceVideoUrlBuilder(image){
        return `${import.meta.env.VITE_APP_STORE_FOUR_BASE_URL}/${FILE_PATH.INTRODUCE_VIDEO}/${image}.mp4`;
    }
    return {
        imageUrlBuilder,
        fileUrlBuilder,
        defaultImageUrlBuilder,
        introduceVideoUrlBuilder
    };
}

