/**
 * A composable function for formatting numbers using the Intl.NumberFormat API.
 * @returns {object} An object containing the `numberFormatter` function.
 */
export function useNumberFormatter() {
    /**
     * Formats a number according to the specified formatting options.
     * @function
     * @param {number} number - The number to be formatted.
     * @param {string} [type='fa'] - The formatting type, such as 'fa' for Farsi (Persian) numbering system. Defaults to 'fa'.
     * @returns {string} The formatted number as a string.
     */
    function numberFormatter(number, type = 'fa') {
        return Intl.NumberFormat(type).format(number);
    }

    function formatPriceNumberForGtm(price) {
        return  new Intl.NumberFormat('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
            useGrouping: false
        }).format(price)
    }

    return {
        numberFormatter,
        formatPriceNumberForGtm,
    };
}