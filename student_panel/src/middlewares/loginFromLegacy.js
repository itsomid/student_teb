import {useStore} from "vuex";
import useJwt from "@/composable/useJwt";

/**
 * Logs in a user using legacy authentication logic and updates the user profile.
 *
 * @function
 * @name loginFromLegacy
 * @async
 * @param {object} to - The target route object.
 * @param {function} next - The callback function to continue the navigation.
 */
export const loginFromLegacy = async (to, next)=>{
    /**
     * @typedef {object} LegacyQueryParams
     * @property {string} token - The authentication token.
     * @property {string} name - The user's name.
     * @property {string} mobile - The user's mobile number.
     * @property {string} route - The target route name.
     * @property {string} user_id - The user's ID for specific routes.
     */

    // Login from legacy logic
    const store = useStore();

    // Extracting parameters from the route
    const { token, name, mobile, route: routeName, user_id: userId } = to.query;

    // Check if essential parameters are missing
    if (!token || !name || !mobile || !routeName){
        return
    }
    // Clear local storage
    localStorage.clear()

    // Save user data in local storage

    let user = {
        'mobile': mobile,
        'name': name
    }
    localStorage.setItem('userData', JSON.stringify(user));

    // Set authentication token using useJwt
    useJwt.setToken(token)

    try {
        // Dispatch an action to update the user profile
        await store.dispatch('userStore/updateProfile');

        // Redirect based on the target route
        const redirectRoute = routeName === 'chat' ? { name: routeName, params: { 'user_id': userId } } : { name: 'dashboard' };

        console.log('------------------',redirectRoute,'----------------------------')
        next(redirectRoute);
    }catch (e) {
        console.error('Error updating user profile:', e);
    }
}
