// composables/useThemeManager.js
import { useTheme } from 'vuetify';
import localStorageService from '@/services/LocalStorage.service';
import {useCycleList} from "@vueuse/core";
import {themes} from "@/config/themes.config";
import {computed, onUnmounted, watch} from "vue";

export const useThemeManager = () => {
    const { name: themeName, global: globalTheme } = useTheme();

    const {
        state: currentThemeName,
        next: getNextThemeName,
        index: currentThemeIndex,
    } = useCycleList(themes.map(t => t.name), { initialValue: themeName });

    const isDark = computed(() => globalTheme.current.value.dark);

    /**
     * Change the application theme to the next theme in the cycle list.
     * @function
     * @returns {void}
     */
    const changeTheme = () => {
        globalTheme.name.value = getNextThemeName();
    };

    const getUserTheme = () => {
        globalTheme.name.value = localStorageService.get('theme') || themeName;
    };

    const unwatch = watch(() => globalTheme.name.value, val => {
        currentThemeName.value = val;
        localStorageService.set('theme',globalTheme.name.value);
    });


    const cleanup = () => {
        unwatch();
    };

    onUnmounted(()=> {
        cleanup();
    })

    return { getUserTheme, changeTheme, currentThemeIndex, getNextThemeName, currentThemeName, isDark };
};