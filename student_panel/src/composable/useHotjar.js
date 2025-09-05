// src/composables/useHotjar.js
import { onMounted } from 'vue';

export function useHotjar() {
    const HOTJAR_EVENTS = {
        NOT_PAYED_ORDER: 'notpayedorder',
    };

    const sendEvent = (eventName, additionalData = {}) => {
        if (typeof window.hj === 'function') {
            // Send the event to Hotjar
            window.hj('event', eventName, additionalData);
            console.log(`Hotjar event sent: ${eventName}`, additionalData);
        } else {
            console.warn('Hotjar is not initialized');
        }
    };

    const trackPageView = (pageName) => {
        if (typeof window.hj === 'function') {
            // Track page view in Hotjar
            window.hj('stateChange', pageName);
            console.log(`Hotjar page view tracked: ${pageName}`);
        } else {
            console.warn('Hotjar is not initialized');
        }
    };

    // Optional: Check Hotjar initialization on mounted
    onMounted(() => {
        if (typeof window.hj !== 'function') {
            console.warn('Hotjar is not yet initialized');
        }
    });

    return { HOTJAR_EVENTS, sendEvent, trackPageView };
}
