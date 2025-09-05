import { useGtm } from "@gtm-support/vue-gtm";
import {PRODUCT_TYPE} from "@/constants/product";
import {useNumberFormatter} from "@/composable/useNumberFormatter";
import {useStore} from "vuex";


/**
 * A hook for tracking events using Google Tag Manager (GTM).
 * @returns {Object} An object containing functions to track login and signup events.
 */
export function useGoogleTagManager() {
    const gtm = useGtm();
    const { formatPriceNumberForGtm } = useNumberFormatter();

    const store = useStore();
    function trackEvent(eventName,eventParams) {
        if (!gtm) {
            console.warn('GTM is not initialized.');
            return;
        }
        gtm.trackEvent({
            event: eventName,
            ...eventParams,
        });
    }


    /**
     * Tracks a login event and pushes the data to GTM.
     *
     * @param {Object} data - The data to be pushed with the login event.
     * @param {string} data.userId - The ID of the user logging in.
     * @param {string} data.authentication_method - The method of login (e.g., 'email', 'google').
     * @param {number} data.timestamp - The timestamp of the login event.
     */
    function trackEventLogin(data) {
        if(!gtm.enabled()) return;
        window.dataLayer.push({
            event: 'login',
            value: data,
            ...data,
        });
    }

    /**
     * Tracks a signup event and pushes the data to GTM.
     *
     * @param {Object} data - The data to be pushed with the signup event.
     * @param {string} data.userId - The ID of the user signing up.
     * @param {string} data.authentication_method - The method of signup (e.g., 'email', 'google').
     * @param {number} data.timestamp - The timestamp of the signup event.
     */
    function trackEventSignup(data){
        // if(!gtm.enabled()) return;
        window.dataLayer.push({
            event: 'signup',
            value: data,
            ...data,
        });
    }

    function trackSelectItemEvent({name,id, off_price,original_price,product_type_id, quantity}){
        const coupon = store.getters['cartStore/discount'];
        trackEvent('select_item', {
            currency: "USD",
            value: original_price,
            items: [{
                item_name: name, // insert an actual product name
                item_id: id, // insert an actual product ID
                price: formatPriceNumberForGtm(off_price || original_price), // insert an actual product price.Number or a string. Don't include currency code
                quantity: quantity || 1,  // product quantity of how many products were added to a cart
                item_category: product_type_id === PRODUCT_TYPE.PRODUCT_CUSTOM_PACKAGE ? 'package' : 'single_product'
            }],
        });
    }

    function trackViewItemEvent({name,id, off_price,original_price,product_type_id, quantity}){
        const coupon = store.getters['cartStore/discount'];
        trackEvent('view_item', {
            currency: "USD",
            value: original_price,
            items: [{
                item_name: name, // insert an actual product name
                item_id: id, // insert an actual product ID
                price: formatPriceNumberForGtm(off_price || original_price), // insert an actual product price.Number or a string. Don't include currency code
                quantity: quantity || 1,  // product quantity of how many products were added to a cart
                item_category: product_type_id === PRODUCT_TYPE.PRODUCT_CUSTOM_PACKAGE ? 'package' : 'single_product'
            }],
        });
    }

    function trackAddToCartEvent({name,id,original_price,off_price,product_type_id, quantity}) {
        const coupon = store.getters['cartStore/discount'];
        trackEvent('add_to_cart', {
            item_brand  : 'Classino',
            currency    : 'USD',
            coupon      : coupon,
            value       : formatPriceNumberForGtm(original_price),
            // an array with a product that was clicked
            items: [{
                item_name: name, // insert an actual product name
                item_id: id, // insert an actual product ID
                price: formatPriceNumberForGtm(off_price || original_price), // insert an actual product price.Number or a string. Don't include currency code
                quantity: quantity || 1,  // product quantity of how many products were added to a cart
                item_category: product_type_id === PRODUCT_TYPE.PRODUCT_CUSTOM_PACKAGE ? 'package' : 'single_product'
            }],
        });
    }

    function trackRemoveFromCartEvent({product_name,product_id, product_price,product_calculated_price,is_package ,quantity}) {
        const coupon = store.getters['cartStore/discount'];
        trackEvent('remove_from_cart', {
            item_brand  : 'Classino',
            currency    : 'USD',
            coupon      : coupon,
            value       : formatPriceNumberForGtm(product_price),
            items: [{
                item_name       : product_name, // insert an actual product name
                item_id         : product_id, // insert an actual product ID
                discount        : product_price !== product_calculated_price ? formatPriceNumberForGtm(product_price - product_calculated_price) : '',
                price           : formatPriceNumberForGtm(product_price), // insert an actual product price.Number or a string. Don't include currency code
                quantity        : quantity || 1,  // product quantity of how many products were added to a cart
                item_category   : is_package ? 'package' : 'single_product'
            }],
        });
    }

    function trackBeginCheckOutEvent(cartItems,final_price) {
        const coupon = store.getters['cartStore/discount'];
        const items = cartItems.map((item)=> {
            return {
                item_brand: 'Classino',
                item_name   : item.product_name,
                item_id     : item.product_id,
                discount    : item.product_price !== item.product_calculated_price ? formatPriceNumberForGtm(item.product_price - item.product_calculated_price) : '',
                price       : formatPriceNumberForGtm(item.product_price),
                quantity    : 1,
                item_category: item.is_package ? 'package' : 'single_product'
            }
        })
        trackEvent('begin_checkout', {
            currency: 'USD',
            coupon: coupon,
            value: formatPriceNumberForGtm(final_price),
            items: items,
        });
    }

    return {
        trackEvent,
        trackEventLogin,
        trackEventSignup,
        trackSelectItemEvent,
        trackViewItemEvent,
        trackAddToCartEvent,
        trackRemoveFromCartEvent,
        trackBeginCheckOutEvent
    };
}