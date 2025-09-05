import {useRoute, useRouter} from "vue-router";
import {useSerializer} from "@/composable/useSerializer";

/**
 * Composable function for utilities.
 * @returns {{
 *  filterEmptyProperties: (obj: Object<string, any>) => Object<string, any>,
 *  replaceQueryParams: (currentQueryParams: Object<string, any>, newQueryParams: Object<string, any>) => Object<string, any>,
 *  arrayParsToNum: (arr: any[]) => number[],
 *  pushWithQuery: (newQueryParams: Object<string, any>) => Promise<void>,
 *  valueParser: (value: string) => any
 * }} An object containing utility functions.
 */
export function useUtils() {
    const router = useRouter();
    const route = useRoute();

    /**
     * Filters out empty properties from an object.
     * @param {Object<string, any>} obj The object to filter.
     * @returns {Object<string, any>} The object with empty properties removed.
     */
    function filterEmptyProperties(obj) {
        Object.keys(obj).forEach((key) => {
            if (obj[key] == null || !obj[key]) {
                delete obj[key];
            }
            else if ((typeof obj[key] !== 'boolean' && typeof obj[key] === 'object' && !obj[key].length)) {
                delete obj[key];
            }
        });
        return obj;
    }

    /**
     * Replaces query parameters in the current query with new ones.
     * @param {Object<string, any>} currentQueryParams The current query parameters.
     * @param {Object<string, any>} newQueryParams The new query parameters to replace.
     * @returns {Object<string, any>} The updated query parameters.
     */
    function replaceQueryParams(currentQueryParams, newQueryParams) {
        Object.keys(newQueryParams).forEach((key) => {
            currentQueryParams[key] = newQueryParams[key];
        });
        currentQueryParams = filterEmptyProperties(currentQueryParams);
        return currentQueryParams;
    }


    /**
     * Converts an array of strings representing numbers to an array of actual numbers.
     * @param {any[]} arr The array of strings to convert.
     * @returns {number[]} An array of numbers.
     */
    function arrayParsToNum (arr) {
        let newArr = JSON.parse(JSON.stringify(arr));
        for( const index of newArr.keys()) {
            newArr[index] = Number(newArr[index]);
        }
        return newArr;
    }

    /**
     * Pushes a new route with updated query parameters.
     * @param {Object<string, any>} newQueryParams The new query parameters to set.
     * @returns {Promise<void>}
     */
    async function updateRouteWithQueryParams(newQueryParams) {
        const { commaSeparatedSerializer } = useSerializer();
        const updatedQueryParams = replaceQueryParams({...route.query} , newQueryParams);
        const serializedQueryParams = commaSeparatedSerializer(updatedQueryParams);
        await router.push({query: serializedQueryParams});
    }

    /**
     * Parses the value to its appropriate type.
     * @param {string} value The value to parse.
     * @returns {any} The parsed value with the correct type.
     */
    function valueParser(value) {
        if(value.includes(',')) return arrayParsToNum(value.split(','))
        else if(['false','true'].includes(value)) return value === 'true';
        else if(!isNaN(value)) return +value;
        else return value
    }

    function convertPersianToEnglish(input) {
        // Replace Persian digits with corresponding English digits
        return input.replace(/[۰-۹]/g, (char) => {
            // Convert each Persian digit to its English equivalent
            return String.fromCharCode(char.charCodeAt(0) - 1728);
        });
    }

    function convertArabicToEnglish(input) {
        // Replace Arabic digits with corresponding English digits
        return input.replace(/[٠-٩]/g, (char) => {
            // Convert each Arabic digit to its English equivalent
            return String.fromCharCode(char.charCodeAt(0) - 1632);
        });
    }

    function extractNumbersOrReturnZero(input) {
        input = convertPersianToEnglish(input);
        input = convertArabicToEnglish(input);
        // Extract numbers from the input string
        const numbers = input.match(/\d+/g);

        // Join all numbers into a single string
        const result = numbers ? numbers.join('') : '0';

        return result;
    }

    function getFileExtension(fileName) {
        const parts = fileName.split('.');
        return parts.length > 1 ? parts.pop() : '';
    }

    function isImageFile(fileName) {
        // List of common image file extensions
        const imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'webp', 'tiff', 'ico'];

        // Get the file extension
        const fileExtension = getFileExtension(fileName);

        // Check if the file extension is in the list of image extensions
        return imageExtensions.includes(fileExtension);
    }
    return {
        filterEmptyProperties,
        replaceQueryParams,
        arrayParsToNum,
        updateRouteWithQueryParams,
        valueParser,
        convertPersianToEnglish,
        convertArabicToEnglish,
        extractNumbersOrReturnZero,
        getFileExtension,
        isImageFile,
    };
}