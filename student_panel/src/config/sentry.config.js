/**
 * @created        19/06/2023 - 13:18
 * @author         Nariman Palangi
 * @user           ragnarok
 * @organization
 * @project        student-panel-v3
 * @file name      sentry.config.js
 * @file dir       src/config
 * @export sentryInit
 */

/**
 * configuration doc
 * @see https://docs.sentry.io/platforms/javascript/guides/vue/
 * */
import * as Sentry from "@sentry/vue";


/**
 * A DSN tells a Sentry SDK where to send events so the events are associated with the correct project.
 * The DSN configures the protocol, public key, server address, and project identifier. It is composed of the following parts:
 * {PROTOCOL}://{PUBLIC_KEY}:{SECRET_KEY}@{HOST}{PATH}/{PROJECT_ID}
 *
 * SENTRY_BOILERPLATE_DSN = "https://90d317844bfb4cc084914bdbd7731433@o4505397220081664.ingest.sentry.io/4505397271396352";
 * @type {string}
 * */
const SENTRY_DNS =  import.meta.env.VITE_SENTRY_DSN || "";


/**
 * The tracePropagationTargets option matches the entire request URL, not just the domain.
 * Using stricter regex to match certain parts of the URL ensures that requests don't unnecessarily have additional headers attached.
 * @type {array}
 * */
const TRACE_PROPAGATION_TARGETS = ["localhost", /^https:\/\/yourserver\.io\/api/];

/**
 * Set tracesSampleRate to 1.0 to capture 100%
 * of transactions for performance monitoring.
 * We recommend adjusting this value in production
 * @type {number}
 */
const TRACES_SAMPLE_RATE = 1.0;


/**
 * Session Replay helps you get to the root cause of
 * an error or latency issue faster by providing you
 * with a video-like reproduction of what was happening
 * in the user's browser before, during, and after the issue.
 * Capture Replay for 10% of all sessions,
 * plus for 100% of sessions with an error
 * @type {number}
 */
const REPLAYS_SESSION_SAMPLE_RATE = 0.1;
const REPLAYS_ON_ERROR_SAMPLE_RATE = 1.0;


/**
 * @param app {Vue} vue instance
 * @param router {VueRouter} vue-router
 * @description initialize Sentry
 * */
export const sentryInit = function (app,router){
    Sentry.init({
        app,
        dsn: SENTRY_DNS,
        integrations: [
            new Sentry.BrowserTracing({
                // Set `tracePropagationTargets` to control for which URLs distributed tracing should be enabled
                tracePropagationTargets: TRACE_PROPAGATION_TARGETS,
                routingInstrumentation: Sentry.vueRouterInstrumentation(router),
            }),
            new Sentry.Replay(),
        ],

        // Set tracesSampleRate to 1.0 to capture 100%
        // of transactions for performance monitoring.
        // We recommend adjusting this value in production
        tracesSampleRate: TRACES_SAMPLE_RATE,

        // Capture Replay for 10% of all sessions,
        // plus for 100% of sessions with an error
        replaysSessionSampleRate: REPLAYS_SESSION_SAMPLE_RATE,
        replaysOnErrorSampleRate: REPLAYS_ON_ERROR_SAMPLE_RATE,
    });
}
