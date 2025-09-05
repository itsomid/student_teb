import localStorageService from "@/services/LocalStorage.service";

const PRE_FIX = "CACHE_"
export const CACHE = {
    get(key) {
        return localStorageService.get(PRE_FIX+key) || false;
    },

    set(key, value){
        localStorageService.set(PRE_FIX+key,value);
    },

    remove(key) {
        localStorageService.remove(PRE_FIX+key)
    },

    purge(){
        //TODO REMOVE ALL CACHES FROM LOCALSTORAGE
    }
};

