import { createApp } from 'vue'
import App from './App.vue'
import { router } from './router'
// import { loadFonts } from './plugins/webfontloader'
// import { sentryInit } from "@/config/sentry.config";
import {appInit} from "@/services/initializer.service";
import { registerSW } from 'virtual:pwa-register'
import {registerPlugins} from "@/plugins";

registerSW({
    immediate: true,
    onOfflineReady() {
        console.log('offline ready');
    },
});


// loadFonts().then(r => (console.log(r + "load")))
const app = createApp(App)

registerPlugins(app);

appInit(app,router);

// sentryInit(app, router);

app.mount('#app')