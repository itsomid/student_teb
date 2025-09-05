import {computed} from 'vue';
import jwt from "@/composable/useJwt";

export function usePaymentAddress() {
    const PAYMENT_GATEWAY = computed(()=> `${window.location.protocol}//${window.location.hostname}${import.meta.env.VITE_APP_ENV ? ':4002' : ''}/write/v1/api/panel/pay/cart?token=${jwt.getToken()}&panel=new`);
    const PAYMENT_GATEWAY_CREDIT = computed(()=> `${window.location.protocol}//${window.location.hostname}${import.meta.env.VITE_APP_ENV ? ':4002' : ''}/write/v1/api/panel/pay/credit?token=${jwt.getToken()}&panel=new`)

    return {
        PAYMENT_GATEWAY,
        PAYMENT_GATEWAY_CREDIT
    };
}
