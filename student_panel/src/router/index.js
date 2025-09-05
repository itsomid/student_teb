import { createRouter, createWebHistory } from 'vue-router'
import { useStore } from 'vuex'
import { isUserLoggedIn } from "@/services/Auth.service";
import { loginFromLegacy } from "@/middlewares/loginFromLegacy";
import { handleRedirectAfterLogin } from "@/middlewares/handleRedirectAfterLogin";
import { EXCLUDE_ROUTES } from "@/constants/app.const";
import authentication from "./routes/auth";
import panel from "./routes/panel";
import ReagentView from "@/views/ReagentView.vue";


/**
 * Vue Router instance for handling navigation within the application.
 *
 * @constant {Object} router
 * @type {VueRouter}
 * @see {@link https://router.vuejs.org/} for more information on Vue Router.
 */
export const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    { path: '/redirectAfterLogin/:root/:value?/:representer?', name: 'redirectAfterLogin' },
    { path: '', redirect: { name: 'dashboard' }},
    ...authentication,
    ...panel,
    {
      path: '/:pathMatch(.*)*',
      redirect: {name: 'error-404'},
    },
    {
      path: '/c/:reagent_code',
      component: ReagentView,
      name: 'reagent',
      meta: {
        redirectIfLoggedIn: true
      }
    }
  ]
})

/**
 * Middleware for handling redirection after login.
 *
 * @function
 * @name handleRedirectMiddleware
 * @param {RouteLocationNormalized} to - The target route object.
 * @param {RouteLocationNormalized} from - The source route object.
 * @param {Function} next - The callback function to continue the navigation.
 * @returns {void}
 */
const handleRedirectMiddleware = (to, from, next) => {
  handleRedirectAfterLogin(to, from, next);
};

/**
 * Middleware for legacy login.
 *
 * @function
 * @name legacyLoginMiddleware
 * @async
 * @param {RouteLocationNormalized} to - The target route object.
 * @param {RouteLocationNormalized} from - The source route object.
 * @param {Function} next - The callback function to continue the navigation.
 * @returns {Promise<void>}
 */
const legacyLoginMiddleware = async (to, from, next) => {
  to.query.token ?  await loginFromLegacy(to, next) : next()
};

/**
 * Main navigation guard for additional checks and actions.
 *
 * @function
 * @name mainNavigationGuard
 * @async
 * @param {RouteLocationNormalized} to - The target route object.
 * @param {RouteLocationNormalized} from - The source route object.
 * @param {Function} next - The callback function to continue the navigation.
 * @returns {Promise<void>}
 */
const mainNavigationGuard = async (to, from, next) => {
  const isLoggedIn = isUserLoggedIn();
  const user = JSON.parse(localStorage.getItem('userData'));
  const store = useStore();

  if (!to.meta.redirectIfLoggedIn && !isLoggedIn) {
    return next({ name: 'authentication.auth', query: { ...to.query } });
  }

  if (!!user && !EXCLUDE_ROUTES.includes(to.name)) {
    await store.dispatch('chatStore/getUserUnreadMessage');
  }

  if (to.name !== 'finance.increase-credit' && to.name !== 'finance' && to.name !== 'finance.main' && user && user.credit < 0) {
    next({ name: 'finance.increase-credit', params: { amount: Math.abs(user.credit) } });
  }

  if (to.name !== 'blocked' && to.name !== 'login' && user && (user.block === 1 || user.block === 4)) {
    next({ name: 'blocked' });
  }

  if (to.name !== 'blocked' && to.name !== 'profile' && user && user.nationalCodeStatus === 3) {
    next({ name: 'profile' });
  }

  document.title = to.meta.title || 'کلاسینو';
  await store.dispatch('navbar/updateTitle',to.meta.title || 'کلاسینو')
  return next();
};

// Apply middlewares to the router instance
router.beforeEach(handleRedirectMiddleware);
router.beforeEach(legacyLoginMiddleware);
router.beforeEach(mainNavigationGuard);

const history = []; // Custom history tracker

router.beforeEach((to, from, next) => {
  if (from.name) {
    history.push(from.name); // Track the previous route
  }
  next();
});

router.historyStack = history; // Attach it for easy access


/**
 * Default export: The configured Vue Router instance.
 *
 * @default
 * @type {VueRouter}
 * @see {@link https://router.vuejs.org/} for more information on Vue Router.
 */
export default router
