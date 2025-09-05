/**
 * Factory function to paginate an array of items.
 * @param {Array} items - The array of items to paginate.
 * @param {number} page - The current page number.
 * @param {number} itemPerPage - The number of items per page.
 * @returns {Array} - An array containing the items for the current page.
 */
export const paginateFactory = (items, page, itemPerPage) => {
    let newItems = [...items];
    return newItems.splice((page - 1) * itemPerPage, itemPerPage);
}

/**
 * A hook to provide pagination utilities.
 * @returns {Object} - An object containing pagination utilities.
 */
export const usePagination = () => {
    return { paginateFactory };
}