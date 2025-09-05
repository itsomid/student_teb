import { ref } from 'vue';

export function useOS() {
    const os = ref(null);

    const detectOS = () => {
        const userAgent = window.navigator.userAgent;
        const platform = window.navigator.platform;

        if (platform.indexOf('Win') !== -1) {
            os.value = 'Windows';
        } else if (platform.indexOf('Mac') !== -1) {
            os.value = 'MacOS';
        } else if (platform.indexOf('Linux') !== -1 || platform.indexOf('X11') !== -1) {
            os.value = 'Linux';
        } else if (/Android/.test(userAgent)) {
            os.value = 'Android';
        } else if (/iPhone|iPad|iPod/.test(userAgent)) {
            os.value = 'iOS';
        } else {
            os.value = 'Unknown';
        }
    };



    detectOS();

    return {
        os
    };
}
