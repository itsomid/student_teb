import VueMeta from 'vue-meta'
import {VUE_META_CONFIG} from "@/configs/vue.meta.config";
export const initializeMetaTagHandler = (app) => {
    app.use(VueMeta, {
        ...VUE_META_CONFIG
    })
}

//TODO ADD VUE-META compatible with VUE.JS 3