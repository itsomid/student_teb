import { i18n } from './i18n';
import { router } from '../router'
import { store } from '../store'
import vuetify from './vuetify'

export function registerPlugins (app) {
    app
        .use(router)
        .use(store)
        .use(vuetify)
        .use(i18n)
}
