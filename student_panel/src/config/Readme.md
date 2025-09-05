# Config

In the config directory you can put any runtime config files for your application
and third-party services. For instance, if you use a service like Firebase or OIDC
for authentication, you will need to add configuration files and use them in your
app. This is the directory for them. Just make sure not to confuse config with
environmental variables, as anything that goes here will be present in the build
bundle.

## Content

1. [PWA Config File](#pwa-config-file-pwaconfigjs)
   - [Config Options](#config-options-pwaconfigjs)
     - [registerType](#registerType)
     - [injectRegister](#injectregister)
     - [workbox](#workbox)
       - [cleanupOutdatedCaches](#cleanupoutdatedcaches)
       - [sourcemap](#sourcemap)
       - [globPatterns](#globpatterns)
     - [includeAssets](#includeassets)
     - [devOptions](#devoptions)
   - [OptionsPWA (all project pwa configs)](#optionspwa)
2. [Manifest Config File](#manifest-config-file-manifestconfigjs)
3. [How to add Vite PWA to project](#how-to-add-vite-pwa-to-project)
4. [Sentry Config File](#sentry-config-file-sentryconfigjs)
   - [What is Sentry](#what-is-sentry)
   - [Config options](#config-options-sentryconfigjs)
   - [SENTRY_DNS](#sentrydns)
   - [TRACE_PROPAGATION_TARGETS](#tracepropagationtargets)
   - [TRACES_SAMPLE_RATE](#tracessamplerate)
   - [REPLAYS_SESSION_SAMPLE_RATE](#replayssessionsamplerate)
   - [sentryInit](#sentryinit)
5. [How to add Sentry to project](#how-to-add-sentry-to-project)
6. [JWT Authentication Configuration Guide](#jwt-authentication-configuration-guide-jwtdefauktconfigjs)
7. [google tag manager](#google-tag-manager-vue-gtm)
5. [vue-gtag](#vue-gtag)
6. [vue meta](#vue-meta)

---

## PWA Config File [`pwa.config.js`](pwa.config.js)

    src/config/pwa.config.js

Progressive Web Apps (PWAs) are web application built and enhanced with modern APIs to deliver enhanced capabilities, reliability, and installability while reaching anyone, anywhere, on any device, all with a single codebase.
we use `vite-plugin-pwa` in this project.
we can choose two method to make our app PWA.

- `generateSW` see [how to config](https://vite-pwa-org.netlify.app/workbox/generate-sw.html)
- `injectManifest` see [how to config](https://vite-pwa-org.netlify.app/workbox/inject-manifest.html)

we choose `generateSw` method in our project.

to see all configurations please visit [Vite PWA guide](https://vite-pwa-org.netlify.app/guide/)

### Config Options [`pwa.config.js`](pwa.config.js)

- #### registerType

  By `registerType` option you can set how to create service worker. we have a `REGISTER_TYPE` const to define registerType. `REGISTER_TYPE` constant is an object with 2 properties, `AUTO_UPDATE` and `PROPMT`.
  If you don't set REGISTER_TYPE in options `vite-plugin-pwa` set it as `prompt`.

  - `AUTO_UPDATE:`

    With this behavior, once the browser detects a new version of your application,
    then, it will update the caches and will reload any browser windows/tabs
    with the application opened automatically to take the control.

    [see: https://vite-pwa-org.netlify.app/guide/auto-update.html](https://vite-pwa-org.netlify.app/guide/auto-update.html)

  - `PROMPT:`

    show a prompt to the user with refresh and cancel buttons inside onNeedRefresh method.

    [see:https://vite-pwa-org.netlify.app/guide/prompt-for-update.html](https://vite-pwa-org.netlify.app/guide/prompt-for-update.html)

    /src/config/pwa.config.js

```javascript
//pwa.config.js

const REGISTER_TYPE = {
  AUTO_UPDATE: Symbol('autoUpdate'),
  PROMPT: Symbol('prompt')
}

export const OptionsPWA = {
  registerType: REGISTER_TYPE.AUTO_UPDATE
  //...
}
```

- #### injectRegister

  Plugin will register the service worker automatically for you, using the injectRegister.

  [see: https://vite-pwa-org.netlify.app/guide/register-service-worker.html](https://vite-pwa-org.netlify.app/guide/register-service-worker.html)

  /src/config/pwa.config.js

```javascript
//pwa.config.js

const INJECT_REGISTER = 'auto'

export const OptionsPWA = {
  //...

  injectRegister: INJECT_REGISTER

  //...
}
```

- #### workbox

  Workbox is a massive package with many modules to make service worker development more enjoyable and remove the need to deal with the low-level service worker API.
  to see full detail about work box visit [vite pwa workbox docs](https://vite-pwa-org.netlify.app/workbox/).

  - ##### cleanupOutdatedCaches

    this config can handle how to behave with `out date caches` after new build detects.

        /src/config/pwa.config.js

    ```javascript
    //pwa.config.js

    const WORKBOX_CLEANUP_OUT_DATE_CACHES = true

    export const OptionsPWA = {
      //...

      workbox: {
        cleanupOutdatedCaches: WORKBOX_CLEANUP_OUT_DATE_CACHES
        //...
      }

      //...
    }
    ```

  - ##### sourcemap

    Your service worker source map will be generated when Vite's build.
    sourcemap configuration option has the value true, 'online' or 'hidden',
    and you have not configured the workbox.sourcemap option in the plugin configuration.
    If you configure the workbox.sourcemap option, the plugin will not change that value.

        /src/config/pwa.config.js

    ```javascript
    //pwa.config.js

    const WORKBOX_SOURCEMAP = true

    export const OptionsPWA = {
      //...

      workbox: {
        //...
        sourcemap: WORKBOX_SOURCEMAP
        //...
      }

      //...
    }
    ```

  - ##### globPatterns

    If you need to include other assets that are not under Vite's publicDir option directory, you can use
    the globPatterns parameter of workbox or injectManifest plugin options.
    /src/config/pwa.config.js

    ```javascript
    //pwa.config.js

    const WORKBOX_GLOB_PATTERNS = ['**/*.{js,css,html,ico,png,svg,jpg,jpeg,webp,ttf,woff,woff2}']

    export const OptionsPWA = {
      //...

      workbox: {
        //...
        globPatterns: WORKBOX_GLOB_PATTERNS
        //...
      }

      //...
    }
    ```

- #### includeAssets

  The includeAssets option will be resolved using
  fast-glob found under Vite's publicDir option directory,
  and so you can use regular expressions to include those assets,

```javascript
       // /src/config/pwa.config.js

      const INCLUDE_ASSETS = ['favicon.ico','apple-touch-icon-180x180.png','fonts/*.ttf','icons/*.ico']

      export const OptionsPWA =  {
        //...

         workbox: {
          //...
          includeAssets: INCLUDE_ASSETS,
          //...
          },

        //...
      }
```

- #### manifest

  A web application manifest, defined in the Web Application Manifest specification, is a JSON text file that provides information about a web application.

  to see manifest create guide [click here](#manifest-config-file)

  [manifest.config.js](manifest.config.js)

- #### devOptions

If you want to check it in dev, add the devOptions option to the plugin configuration.
To enable the service worker on development, you only need to add the following options to the plugin configuration:

To enable this option just need to set `DEV_MODE` const to `true`

    /src/config/pwa.config.js

```javascript
//pwa.config.js

const DEV_MODE = true

export const OptionsPWA = {
  //...
  devOptions: {
    enabled: DEV_MODE
  }
  //...
}
```

### OptionsPWA

All project PWA configs exported as OptionsPWA object in `pwa.config.js`

```javascript
// /src/config/pwa.config.js

export const OptionsPWA = {
  registerType: REGISTER_TYPE.AUTO_UPDATE,
  injectRegister: INJECT_REGISTER,
  workbox: {
    cleanupOutdatedCaches: WORKBOX_CLEANUP_OUT_DATE_CACHES,
    sourcemap: WORKBOX_SOURCEMAP,
    globPatterns: WORKBOX_GLOB_PATTERNS
  },
  includeAssets: INCLUDE_ASSETS,
  manifest: MANIFEST,
  devOptions: {
    enabled: DEV_MODE
  }
}
```

---

## Manifest Config File [manifest.config.js](manifest.config.js)

Project manifest config file.

    /src/config/manifest.config.js

You can customize [manifest.config.js](manifest.config.js) as your own.

Some tools to customize project `manifest.config.js`

- [Web App manifests all configuration options](https://developer.mozilla.org/en-US/docs/Web/Manifest);
- [@vite-pwa/assets-generator](https://vite-pwa-org.netlify.app/assets-generator/)
- [pwa online asset generator for android/windows/ios](https://www.pwabuilder.com/imageGenerator)

---

## How to add Vite PWA to project

Progressive Web Apps (PWAs) are web application built and enhanced with modern APIs to deliver enhanced capabilities, reliability, and installability while reaching anyone, anywhere, on any device, all with a single codebase.

If you want to build a Progressive Web App, you may be wondering where to start, if it's possible to upgrade a website to a PWA without starting from scratch, or how to move from a platform-specific app to a PWA.

### Configuring vite-plugin-pwa

1.  Edit your vite.config.js / vite.config.ts file and add the vite-plugin-pwa:

    Vite config file: [vite.config.js](../../vite.config.js)

        rootDir/vite.config.js

2.  import `VitePWA` and [`OptionsPWA`](#optionspwa) to your `vite.config.js`

    ```javascript
    import { fileURLToPath, URL } from 'node:url'
    import { defineConfig } from 'vite'
    import vue from '@vitejs/plugin-vue'

    import { VitePWA } from 'vite-plugin-pwa' // import VitePWA
    import { OptionsPWA } from './src/config/pwa.config' //import Project PWA configs

    export default defineConfig({
      plugins: [
        vue(),
        VitePWA({
          ...OptionsPWA //establish VitePWA with OptionsPWA config object
        })
      ],
      resolve: {
        alias: {
          '@': fileURLToPath(new URL('./src', import.meta.url))
        }
      }
    })
    ```

With this minimal configuration of the vite-plugin-pwa plugin, your application is now able to generate the Web App Manifest and inject it at the entry point, generate the service worker and register it in the browser.

You can find the full list of the vite-plugin-pwa plugin configuration options in the following [client.d.ts](https://github.com/vite-pwa/vite-plugin-pwa/blob/main/src/types.ts).

---

## Sentry config file [`sentry.config.js`](sentry.config.js)

    src/config/sentry.config.js

### What is Sentry

Sentry's SDKs enable automatic reporting of errors and exceptions.
to use sentry we should create and account in [https://sentry.io/signup/](https://sentry.io/signup/).
after sign up you should create a project to get client key. [follow guide to create project](https://docs.sentry.io/product/sentry-basics/integrate-frontend/create-new-project/)
to see Sentry Vue complete reference visit [Sentry Vue complete reference](https://docs.sentry.io/platforms/javascript/guides/vue/?original_referrer=https%3A%2F%2Fwww.google.com%2F)

1. Sign up in sentry [https://sentry.io/signup/](https://sentry.io/signup/)
2. [Create a project](https://docs.sentry.io/product/sentry-basics/integrate-frontend/create-new-project/)
3. [Get client key](https://docs.sentry.io/product/relay/projects/#:~:text=You%20can%20obtain%20the%20key,2244%20%2C%20the%20key%20is%2012345abcdb1e4c123490ecec89c1f199%20.)
4. follow [How to add Sentry to project](#how-to-add-sentry-to-project)

### Config Options [`sentry.config.js`](sentry.config.js)

Configuration should happen as early as possible in your application's lifecycle.

We have a sentry config file to config essential option to our Sentry SDK and run it on our project.

[sentry.config.js](sentry.config.js)

#### SENTRY_DSN

A DSN tells a Sentry SDK where to send events so the events are associated with the correct project.
The DSN configures the protocol, public key, server address, and project identifier.
It is composed of the following parts:

{PROTOCOL}://{PUBLIC_KEY}:{SECRET_KEY}@{HOST}{PATH}/{PROJECT_ID}

@type {string}

```javascript
const SENTRY_DNS =  import.meta.env.VITE_SENTRY_DSN || "sentry.client.key";
```

Import `SENTRY_DNS` from project env file with `VITE_SENTRY_DNS` key.

#### All sentry panel DSN's
```javascript
// All sentry panels dsn

    SENTRY_BOILERPLATE_DSN = "https://90d317844bfb4cc084914bdbd7731433@o4505397220081664.ingest.sentry.io/4505397271396352";
    SENTRY_BUSINESS_DSN = "https://aca4b0823b224017b0069116c431aa64@o4505397220081664.ingest.sentry.io/4505397275131904";
    SENTRY_CATEGORY_UI_DSN = "https://ca7c19ac0cf748be8b8d93b5f3c06d4b@o4505397220081664.ingest.sentry.io/4505397276049408";
    SENTRY_COMMERCIAL_DSN = "https://47786a911b9c465883e7197ca24b1924@o4505397220081664.ingest.sentry.io/4505397277032449";
    SENTRY_HUMAN_RESOURCE_DSN = "https://325cb6514398451a8872ad2fb038a262@o4505397220081664.ingest.sentry.io/4505397272576000";
    SENTRY_LEGAL_DSN = "https://e520e5440c354fa79d9dd1ba5bf98425@o4505397220081664.ingest.sentry.io/4505397278081024";
    SENTRY_LOGISTICS_DSN = "https://18bf5ee2a7da40b59a5424e91651d783@o4505397220081664.ingest.sentry.io/4505397279195136";
    SENTRY_MARKETING_DSN = "https://236ca9cffb5e44fcad5ce317192b4936@o4505397220081664.ingest.sentry.io/4505397280833536";
    SENTRY_QUALITY_CONTROL_DSN = "https://f43cee263b814a05b13e52ba8f150279@o4505397220081664.ingest.sentry.io/4505397282930689";
    SENTRY_SHOP_DSN = "https://526766329fad4a81be49b3d0af9389be@o4505397220081664.ingest.sentry.io/4505397265301504";
    SENTRY_SUPPORT_DSN = "https://42474c30af73480691a684f5d0751748@o4505397220081664.ingest.sentry.io/4505397285093376";
```

#### TRACE_PROPAGATION_TARGETS

The tracePropagationTargets option matches the entire request URL, not just the domain.
Using stricter regex to match certain parts of the URL ensures that requests don't unnecessarily have additional headers attached.
@type {array}

```javascript
const TRACE_PROPAGATION_TARGETS = ["localhost", /^https:\/\/yourserver\.io\/api/];
```

#### TRACES_SAMPLE_RATE

Set tracesSampleRate to 1.0 to capture 100%
of transactions for performance monitoring.
We recommend adjusting this value in production
@type {number}

```javascript
const TRACES_SAMPLE_RATE = 1.0;
```

#### REPLAYS_SESSION_SAMPLE_RATE

Session Replay helps you get to the root cause of
an error or latency issue faster by providing you
with a video-like reproduction of what was happening
in the user's browser before, during, and after the issue.
Capture Replay for 10% of all sessions,
plus for 100% of sessions with an error
@type {number}

```javascript
    const REPLAYS_SESSION_SAMPLE_RATE = 0.1;
    const REPLAYS_ON_ERROR_SAMPLE_RATE = 1.0;
```

### sentryInit

For initializing Sentry SDK in project

```javascript
// /src/config/sentry.config.js

/**
* @param app {Vue} vue instance
* @param router {VueRouter} vue-router
* @description initialize Sentry
*/
    sentryInit(app,router)
    {
        //...
    }
```

---

## How to add Sentry to project

To initialize Sentry in your Vue application, add the following code snippet to your main.js:

1.  import `sentryInit` from `/src/config/sentry.config.js`

```javascript
   // /src/main.js
   import { sentryInit } from "@/config/sentry.config";
```

2.  Call `sentryInit` at the end of `main.js` with `app` and `router` params.

```javascript
import { createApp } from 'vue'
import App from './App.vue'
import router from './router'

import { sentryInit } from '@/config/sentry.config'

const app = createApp(App).use(router).mount('#app')

sentryInit(app, router)
```

3. Verify
   Add a button to your page that throws an error:

```vue
    //App.vue

    <template>
      // ...
      <button @click="throwError"> Throw error </button>
      // ... 
    </template>

    <script>
    export default {
      // ...
      methods: {
        throwError() {
          throw new Error('Sentry Error');
        }
      }
    };
    </script>

```

To view and resolve the recorded error, log into [sentry.io](https://sentry.io/) and open your project. Clicking on the error's title will open a page where you can see detailed information and mark it as resolved.

To see complete doc read this [article](https://docs.sentry.io/platforms/javascript/guides/vue/?original_referrer=https%3A%2F%2Fwww.google.com%2F).

---

## JWT Authentication Configuration Guide [`jwtDefauktConfig.js`](jwtDefauktConfig.js)

This document explains the structure and use of the `jwtConfig` module, which outlines the necessary configuration settings for JSON Web Token (JWT) authentication within your application.

## About `jwtConfig`

The `jwtConfig` is a simple configuration object that holds key information for handling JWTs between the client and the server. It is vital for maintaining secure communication by ensuring tokens are correctly handled and stored.

## Configuration Details

The configuration consists of the following elements:

- `TOKEN_TYPE`: Specifies the token type that is used in the Authorization header when making HTTP requests. This is typically set as `'Bearer'`.
- `STORAGE_TOKEN_KEY_NAME`: The key name under which the JWT access token is stored in local storage or any other client-side storage option.
- `STORAGE_REFRESH_TOKEN_KEY_NAME`: The key name for storing the JWT refresh token, which may be used to obtain a new access token once the previous one expires without asking the user to log in again.

## Exported Configuration Object

```javascript
{
  TOKEN_TYPE: 'Bearer',
  STORAGE_TOKEN_KEY_NAME: 'accessToken',
  STORAGE_REFRESH_TOKEN_KEY_NAME: 'refreshToken'
}
```

## Usage
___________


To use the configuration in your application, first import the module:

```javascript
import jwtConfig from "@/config/jwtConfig";
```

Then you can refer to the individual properties as needed, for example:

```javascript
// Using stored tokens
const accessToken = localStorage.getItem(jwtConfig.STORAGE_TOKEN_KEY_NAME);
const refreshToken = localStorage.getItem(jwtConfig.STORAGE_REFRESH_TOKEN_KEY_NAME);

// Setting authorization header
const authHeader = `${jwtConfig.TOKEN_TYPE} ${accessToken}`;
```

## Integration
__________________

Ensure to implement logic in your application to correctly use the access and refresh tokens as per the JWT authentication flow you have in place. The keys provided here should match those expected by your server’s authentication system.

## Best Practices
____________________
It is recommended to secure the storage and retrieval of tokens in the client application, and to handle token rotation and invalidation securely server-side.

## Google Tag MANAGER (vue-gtm)

You can config your GTM in [google.analytics.config.js](./google.analytics.config.js)

    /src/configs/google.analytics.config.js
```javascript
// /src/configs/google.analytics.config.js
...
export const GTM_CONFIG = {
    /**
     * @param id {String, Array}
     * Your GTM single container ID, array of container ids ['GTM-xxxxxx', 'GTM-yyyyyy'] or
     * array of objects [{id: 'GTM-xxxxxx', queryParams: { gtm_auth: 'abc123', gtm_preview: 'env-4', gtm_cookies_win: 'x'}},
     * {id: 'GTM-yyyyyy', queryParams: {gtm_auth: 'abc234', gtm_preview: 'env-5', gtm_cookies_win: 'x'}}],
     * Your GTM single container ID or array of container ids ['GTM-xxxxxx', 'GTM-yyyyyy']
     * */
    id: import.meta.env.VITE_APP_GTM_ID || "GTM-52WQDC2",

    /**
     * @param defer {boolean}
     * Script can be set to `defer` to speed up page load at the cost of less accurate results
     * (in case visitor leaves before script is loaded, which is unlikely but possible).
     * Defaults to false, so the script is loaded `async` by default
     * */
    defer: true,

    /**
     * @param enabled {boolean}
     * defaults to true. Plugin can be disabled by setting this to false
     * for Ex: enabled: !!GDPR_Cookie (optional)
     * */
    enabled: true,

    /**
     * @param debug {boolean}
     * Whether or not display console logs debugs (optional)
     * */
    debug: false,


    /**
     * @param loadScript {boolean}
     *  Whether or not to load the GTM Script (Helpful if you are including GTM manually,
     *  but need the dataLayer functionality in your components) (optional)
     * */
    loadScript: true,

    /**
     * @param vueRouter {router}
     * Pass the router instance to automatically sync with router (optional)
     * */
    vueRouter: router,

    /**
     * @param trackOnNextTick {boolean}
     * Whether or not call trackView in Vue.nextTick
     * */
    trackOnNextTick: false,
}
```

to see all configuration option see this [document](https://github.com/mib200/vue-gtm)

## vue-gtag
The global site tag (gtag.js) is a JavaScript tagging framework and API that allows you to send event data to Google Analytics, Google Ads, and Google Marketing Platform. For general gtag.js [documentation](https://developers.google.com/analytics/devguides/collection/gtagjs), read the gtag.js developer guide.

You can config your vue-gtag in [vue-gtag config](./google.analytics.config.js)

    /src/configs/google.analytics.config.js

```javascript
// /src/configs/google.analytics.config.js

/**
 * @description The global site tag (gtag.js) is a JavaScript tagging framework and API
 * that allows you to send event data to Google Analytics, Google Ads,
 * and Google Marketing Platform. For general gtag.js [documentation](https://developers.google.com/analytics/devguides/collection/gtagjs),
 * read the gtag.js developer guide.
 * to see all config options
 * @tutorial https://matteo-gabriele.gitbook.io/vue-gtag/v/master/plugin-options
 * */
export const GTAG_CONFIG = {
    config: {
        /**
         * @param id {String} google analytics UA id
         * */
        id: import.meta.env.VITE_APP_UA_ID || "UA-121613918-1",


        /**
         * * @param deferScriptLoad {boolean} The defer attribute is a boolean attribute.
         * If the defer attribute is set, it specifies that the script is downloaded
         * in parallel to parsing the page, and executed after the page has finished parsing.
         * */
        deferScriptLoad: true,
    },
}
```

to see all configuration option see this [document](https://matteo-gabriele.gitbook.io/vue-gtag/v/master/)

## Vue Meta

vue-meta is a plugin for Vue.js which helps you to manage your app's metadata using Vue's built-in reactivity

      /src/configs/vue.meta.config.js

```javascript
// /src/configs/vue.meta.config.js

export const VUE_META_CONFIG = {
    /**
     * @type { string }
     * @default metaInfo
     * @description The name of the component option that contains all 
     * the information that gets converted to the various meta tags & 
     * attributes for the page
     * */
   keyName: 'metaInfo',


   /**
    * @type { string }
    * @default data-vue-meta
    * @description The name of the attribute vue-meta arguments on elements 
    * to know which it should manage and which it should ignore.
    * */
   attribute: 'data-vue-meta',

   /**
    * @type { string }
    * @default data-vue-meta-server-rendered
    * @description The name of the attribute that is added to the html tag 
    * to inform vue-meta that the server has already generated the meta tags
    * for the initial render
    * */
   ssrAttribute: 'data-vue-meta-server-rendered',

   /**
    * @type { string }
    * @default vmid
    * @description The property that tells vue-meta to overwrite (instead of append)
    * an item in a tag list. For example, if you have two meta tag list items that
    * both have vmid of 'description', then vue-meta will overwrite the shallowest one with 
    * the deepest one.
    * */
   tagIDKeyName: 'vmid',

   /**
    * @type { boolean }
    * @default false
    * @description When true then vue-meta will pause updates once page navigation
    * starts and resumes updates when navigation finishes (resuming also triggers an update). 
    * This could both be a performance improvement as a possible fix for 'flickering'
    * when you are e.g. replacing stylesheets
    * */
   refreshOnceOnNavigation: true
}
```

more config option here: [see full plugin options](https://vue-meta.nuxtjs.org/api/#plugin-options)