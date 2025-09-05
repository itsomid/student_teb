/**
 * Enum representing various product statuses.
 * @readonly
 * @enum {string}
 */
export const PRODUCT_STATUS = {
    PURCHASED       : 'purchased',
    IN_CART         : 'in_cart',
    FREE            : 'free',
    AVAILABLE       : 'available',
    NOT_PURCHASABLE : 'not_purchasable',
}

/**
 * Enum representing various product types.
 * @readonly
 * @enum {number}
 */
export const PRODUCT_TYPE = {
    LIVE_COURSE             : 1,
    LIVE_COURSE_CLASS       : 2,
    SECTION_CONTENT         : 3,
    SECTION_VIDEO           : 4,
    SECTION_MBTI            : 5,
    SECTION_CHOOSE_MEASURE  : 6,
    CLASS_QUIZ              : 8,
    OFFLINE_COURSE          : 9,
    PRODUCT_PACKAGE         : 10,
    EXAM                    : 11,
    QUIZ_PACKAGE            : 12,
    EXAM_SECTION            : 13,
    VAT                     : 14,
    PRODUCT_CUSTOM_PACKAGE  : 15,
    PRODUCT_PLANZ_PACKAGE   : 17,
}

export const VALLE_PRODUCTS = import.meta.env.VITE_APP_VALLE_PRODUCT_IDS ? import.meta.env.VITE_APP_VALLE_PRODUCT_IDS.split(',') : ['60949','60928'];
export const FOURTIK_PRODUCTS = import.meta.env.VITE_APP_FOURTIK_PRODUCT_IDS ? import.meta.env.VITE_APP_FOURTIK_PRODUCT_IDS.split(',') : ['60949','60928'];
