import useJwt from "@/composable/useJwt"
import { useRouter } from "vue-router";
import { useStore } from 'vuex'

const router = useRouter();

/**
 * Checks if the user is logged in by verifying the presence of user data and a valid JWT token.
 *
 * @function
 * @name isUserLoggedIn
 * @returns {boolean} True if the user is logged in, false otherwise.
 */
export const isUserLoggedIn = () => {
  return !! localStorage.getItem('userData') && !!useJwt.getToken();
}


/**
 * Retrieves the user data from local storage.
 *
 * @function
 * @name getUserData
 * @returns {Object|null} The user data object if available, otherwise null.
 */
export const getUserData = () => JSON.parse(localStorage.getItem('userData'))

/**
 * Returns the home route for a logged-in user.
 *
 * @function
 * @name getHomeRouteForLoggedInUser
 * @returns {RouteLocationRaw} The home route object for a logged-in user.
 */
export const getHomeRouteForLoggedInUser = () => {
  return {name: 'dashboard'}
}
