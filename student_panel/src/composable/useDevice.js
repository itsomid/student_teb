import { ref, onMounted } from 'vue';

export function useDevice() {
    const isMobile = ref(false);

    const checkDevice = () => {
        const userAgent = navigator.userAgent || navigator.vendor || window.opera;
        isMobile.value = /android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(userAgent)
            || window.matchMedia("(max-width: 767px)").matches;
    };

    onMounted(() => {
        checkDevice();
        window.addEventListener('resize', checkDevice);
    });

    return {
        isMobile
    };
}