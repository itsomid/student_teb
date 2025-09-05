import {VUE_VERSION} from "@/constants/app.const";

export const initGlobalPropertiesService  = (app) => {
    app.provide('$storeFourUploadBaseUrl', import.meta.env.VITE_APP_STORE_FOUR_UPLOAD_BASE_URL);
    app.provide('$newStudentPanel', import.meta.env.VITE_APP_NEW_STUDENT_PANEL)
    app.provide('app_version', VUE_VERSION);
    app.provide('$fourtik', import.meta.env.VITE_APP_FOURTIK_BASE_URL);
}
