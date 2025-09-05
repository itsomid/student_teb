import {onMounted, ref} from "vue";
import {useDate} from "@/composable/useDate";
import LocalStorageService from "@/services/LocalStorage.service";
const { isDaysPast } = useDate();
export function usePWAStatus() {
    const DAYS_SINCE_PWA_WIZARD_SHOWN = import.meta.env.VITE_APP_DAYS_SINCE_PWA_WIZARD_SHOWN || 5;
    const isInstalled = ref(false);
    const isDaysPassed = ref(false);

    const checkPWAStatus = () => {
        // Check if the app is running in standalone mode (PWA installed)
        if (window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true) {
            isInstalled.value = true;
        } else {
            isInstalled.value = false;
        }
    };

    const checkDaysPassed = ()=> {
        const userPwaRejectionDate = LocalStorageService.get('user-pwa-wizard-rejection-date');
        // Check if the cart was updated beyond the specified
        if (isDaysPast(userPwaRejectionDate, DAYS_SINCE_PWA_WIZARD_SHOWN) || !userPwaRejectionDate) {
            isDaysPassed.value = true;
        }
        else isDaysPassed.value = false;
    }

    // Listen to the appinstalled event
    window.addEventListener('appinstalled', () => {
        isInstalled.value = true;
        console.log('PWA was installed');
    });

    // Check PWA installability with beforeinstallprompt
    window.addEventListener('beforeinstallprompt', (e) => {
        console.log('PWA can be installed');
    });

    onMounted(() => {
        checkPWAStatus();
        checkDaysPassed();
    });

    return {
        isInstalled,
        isDaysPassed
    };
}
