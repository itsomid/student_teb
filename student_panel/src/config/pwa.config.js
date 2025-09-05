import {MANIFEST} from "./manifest.config";
import {CACHE_CONFIG} from "./pwaCache.config";

/**
 * To enable the service worker on development, you only need to add the following options to the plugin configuration:
 * @type {boolean}
 * */
const DEV_MODE = true

/**
* If you want to unregister the service worker from your PWA application, you only need to add selfDestroying: true to the plugin configuration.
* */
const SELF_DESTROYING = false;

const REGISTER_TYPE = {
  /**
   * With this behavior, once the browser detects a new version of your application,
   * then, it will update the caches and will reload any browser windows/tabs
   * with the application opened automatically to take the control.
   * @type {object}
   * @tutorial https://vite-pwa-org.netlify.app/guide/auto-update.html
   * */
  AUTO_UPDATE: 'autoUpdate',

  /**
   * show a prompt to the user with refresh and cancel buttons inside onNeedRefresh method.
   * @tutorial https://vite-pwa-org.netlify.app/guide/prompt-for-update.html
   * */
  PROMPT: 'prompt',
}

/**
 * plugin will register the service worker automatically for you, using the injectRegister
 * @type {string}
 * @tutorial https://vite-pwa-org.netlify.app/guide/register-service-worker.html
 * */
const INJECT_REGISTER = 'auto'

/**
 * @type {boolean}
 * */
const WORKBOX_CLEANUP_OUT_DATE_CACHES = true

/**
 * Your service worker source map will be generated when Vite's build.
 * sourcemap configuration option has the value true, 'online' or 'hidden',
 * and you have not configured the workbox.sourcemap option in the plugin configuration.
 * If you configure the workbox.sourcemap option, the plugin will not change that value.
 * @type {boolean}
 * */
const WORKBOX_SOURCEMAP = true // true, 'online', 'hidden'


/**
 * If you need to include other assets that are not under Vite's publicDir option directory, you can use
 * the globPatterns parameter of workbox or injectManifest plugin options.
 * @type {array}
 * */
const WORKBOX_GLOB_PATTERNS = ['**/*.{js,css,html,ico,png,svg,jpg,jpeg,webp,ttf,woff,woff2}'];

/**
 * The includeAssets option will be resolved using
 * fast-glob found under Vite's publicDir option directory,
 * and so you can use regular expressions to include those assets,
 * @type {array}
 * */
const INCLUDE_ASSETS = [
  'favicon.ico',
  'robots.txt',
  'apple-touch-icon-180x180.png',
  'maskable-icon-512x512.png',
  'android-chrome-64x64.png',
  'android-chrome-192x192.png',
  'android-chrome-512x512.png',
  'favicon-16x16.ico',
  'favicon-32x32.ico',
  'fonts/*.ttf',
  'fonts/*.woff',
  'fonts/*.woff2',
  'images/*.png',
  'images/*.svg',
  'images/*.jpg',
  'images/*.jpeg',
  'icons/*.png',
  'icons/*.ico'
]

export const OptionsPWA =  {
  selfDestroying: SELF_DESTROYING,
  registerType: REGISTER_TYPE.AUTO_UPDATE,
  injectRegister: INJECT_REGISTER,
  workbox: {
    cleanupOutdatedCaches: WORKBOX_CLEANUP_OUT_DATE_CACHES,
    sourcemap: WORKBOX_SOURCEMAP,
    globPatterns: WORKBOX_GLOB_PATTERNS,
    skipWaiting: true,
    clientsClaim: true,
    runtimeCaching: CACHE_CONFIG,
  },
  includeAssets: INCLUDE_ASSETS,
  manifest: MANIFEST,
  devOptions: {
    enabled: DEV_MODE
  }
}
