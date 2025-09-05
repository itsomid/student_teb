import { useUTMMA } from "@/composable/useUTMMA";
import { useRouter } from "vue-router";
import { useCookies } from "@/composable/useCookies";

/**
 * A composable function that provides methods for navigating and handling UTM_MA data.
 *
 * @typedef {object} UseNavigatorType
 * @property {Function} navigateToLoginWithPassword - Navigates to the login page with a password.
 * @property {Function} navigateToRegister - Navigates to the registration page with UTM_MA data.
 */

/**
 * Creates a composable function for navigating and handling UTM_MA data.
 *
 * @function
 * @name useNavigator
 * @returns {UseNavigatorType} - Object containing functions for navigation and UTM_MA handling.
 */
export function useNavigator() {
    const router = useRouter();

    const { sendUTMMA, saveUTMMA } = useUTMMA();
    const { getRedirectPath } = useCookies();
    /**
     * Navigates to the auth page
     *
     * @async
     * @function
     * @name navigateToAuth
     * @returns {Promise<void>}
     */
    async function navigateToAuth() {
        await router.push({
            name: 'authentication',
        });
    }

    /**
     * Navigates to the login page with a password.
     *
     * @async
     * @function
     * @name navigateToLoginWithPassword
     * @param {string} mobile - The mobile number for authentication.
     * @returns {Promise<void>}
     */
    async function navigateToLoginWithPassword(mobile) {
        await router.push({
            name: 'login-pass',
            params: { mobile: mobile }
        });
    }

    /**
     * Navigates to the login page with a OTP.
     *
     * @async
     * @function
     * @name navigateToLoginWithOTP
     * @param {string} mobile - The mobile number for authentication.
     * @returns {Promise<void>}
     */
    async function navigateToLoginWithOTP(mobile) {
        await router.push({
            name: 'login-otp',
            params: { mobile: mobile }
        });
    }

    /**
     * Navigates to the registration page with UTM_MA data.
     *
     * @async
     * @function
     * @name navigateToRegister
     * @param {string} mobile - The mobile number for registration.
     * @param {string} utmma - The UTM_MA data to be saved.
     * @returns {Promise<void>}
     */
    async function navigateToRegister(mobile, utmma = "") {
        window.location.href = `${import.meta.env.VITE_APP_NEW_STUDENT_PANEL_BASE_URL}/auth/signup/state/${mobile}`;
        //await saveUTMMA(utmma);
        // await router.push({
        //     name: 'signup.otp',
        //     params: { mobile: mobile }
        // });
    }

    /**
     * Navigates to the registration state page.
     *
     * @async
     * @function
     * @name navigateToRegisterState
     * @param {string} mobile - The mobile number for registration.
     * @returns {Promise<void>}
     */
    async function navigateToRegisterState(mobile) {
        await router.push({
            name: 'signup.state',
            params: { mobile: mobile }
        });
    }

    /**
     * Navigates to the profile
     *
     * @async
     * @function
     * @name navigateToProfile
     * @returns {Promise<void>}
     */
    async function navigateToProfile() {
        await router.push({
            name: 'profile',
        });
    }

    /**
     * Navigates to the dashboard page.
     *
     * @async
     * @function
     * @name navigateToDashboard
     * @returns {Promise<void>}
     */
    async function navigateToDashboard(query = null) {
        await router.push({ name: 'dashboard', query: { ...query } });
    }

    /**
     * Navigates to the redirect path if available.
     *
     * @async
     * @function
     * @name navigateToRedirectPath
     * @returns {Promise<boolean>} - Returns true if redirected, false otherwise.
     */
    async function navigateToRedirectPath() {
        const redirectPath = getRedirectPath('redirect_path');
        if (redirectPath) {
            await router.push(redirectPath);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Navigates to the 'signup.terms' route with the specified mobile parameter.
     *
     * @async
     * @function
     * @param {string} mobile - The mobile parameter to be passed to the 'signup.terms' route.
     * @returns {Promise<void>} A promise that resolves once the navigation is successful.
     */
    async function navigateToTerms(mobile){
        await router.push({
            name: 'signup.terms',
            params: { mobile: mobile }
        });
    }

    /**
     * Navigates to the 'authentication' route after logging out.
     *
     * @async
     * @function
     * @returns {Promise<void>} A promise that resolves once the navigation is successful.
     */
    async function navigateToAuthAfterLogout(){
        await router.push({ name: "authentication" })
    }

    /**
     * Navigates to the 'notifications' route.
     *
     * @async
     * @function
     * @returns {Promise<void>} A promise that resolves once the navigation is successful.
     */
    async function navigateToNotification(){
        await router.push({ name: "notifications" })
    }

    /**
     * Navigates to the 'course' route.
     *
     * @async
     * @function
     * @param {string} quizId - The id parameter to be passed to the 'course' route.
     * @returns {Promise<void>} A promise that resolves once the navigation is successful.
     */
    async function navigateToCourse(courseId){
        await router.push({ name: "course", params:{id: courseId} })
    }

    /**
     * Navigates to the 'quiz' route.
     *
     * @async
     * @function
     * @param {string} quizId - The quiz id parameter to be passed to the 'quiz' route.
     * @returns {Promise<void>} A promise that resolves once the navigation is successful.
     */
    async function navigateToQuiz(quizId){
        await router.push({ name: "quiz", params:{quiz_id: quizId} })
    }

    /**
     * Navigates to the 'answer-sheet' route.
     *
     * @async
     * @function
     * @param {string} quizId - The quiz id parameter to be passed to the 'answer-sheet' route.
     * @returns {Promise<void>} A promise that resolves once the navigation is successful.
     */
    async function navigateToQuizAnswerSheet(quizId){
        await router.push({ name: "answer-sheet", params:{quiz_id: quizId} })
    }

    /**
     * Navigates to the 'homework' route.
     *
     * @async
     * @function
     * @param {string} classId - The class id parameter to be passed to the 'homework' route.
     * @returns {Promise<void>} A promise that resolves once the navigation is successful.
     */
    async function navigateToHomework(classId){
        await router.push({ name: 'homework' , params:{class_id: classId}})
    }

    /**
     * Navigates to the 'report' route.
     *
     * @async
     * @function
     * @param {string} classId - The class id parameter to be passed to the 'report' route.
     * @returns {Promise<void>} A promise that resolves once the navigation is successful.
     */
    async function navigateToReport(classId){
        await router.push({ name: 'report' , params:{class_id: classId}})
    }

    /**
     * Navigates to the 'question-answer' route.
     *
     * @async
     * @function
     * @param {string} courseId - The course id parameter to be passed to the 'question-answer' route.
     * @param {string} classId - The class id parameter to be passed to the 'question-answer' route.
     * @returns {Promise<void>} A promise that resolves once the navigation is successful.
     */
    async function navigateToQuestionAnswer(courseId, classId){
        await router.push({ name: 'question-answer' , params:{course_id: courseId, class_id: classId}})
    }

    /**
     * Navigates to the 'show-class' route.
     *
     * @async
     * @function
     * @param {string} classId - The class id parameter to be passed to the 'show-class' route.
     * @returns {Promise<void>} A promise that resolves once the navigation is successful.
     */
    async function navigateToClass(classId){
        await router.push({ name: 'show-class' , params:{id: classId}})
    }

    /**
     * Navigates to the 'my-courses' route.
     *
     * @async
     * @function
     * @returns {Promise<void>} A promise that resolves once the navigation is successful.
     */
    async function navigateToMyCourses(query = null){
        await router.push({ name: 'my-courses', query })
    }

    /**
     * Navigates to the 'store' route.
     *
     * @async
     * @function
     * @returns {Promise<void>} A promise that resolves once the navigation is successful.
     */
    async function navigateToStore(){
        await router.push({ name: 'store' })
    }

    /**
     * Navigates to the 'cart' route.
     *
     * @async
     * @function
     * @returns {Promise<void>} A promise that resolves once the navigation is successful.
     */
    async function navigateToCart(query = null){
        await router.push({ name: 'cart', query })
    }

    /**
     * Navigates to the 'product' route.
     *
     * @async
     * @function
     * @param {string} productId - The id parameter to be passed to the 'product' route.
     * @returns {Promise<void>} A promise that resolves once the navigation is successful.
     */
    async function navigateToProduct(productId){
        await router.push({ name: 'product',  params:{ id: productId } })
    }

    /**
     * Navigates to the 'package' route.
     *
     * @async
     * @function
     * @param {string} productId - The id parameter to be passed to the 'product' route.
     * @returns {Promise<void>} A promise that resolves once the navigation is successful.
     */
    async function navigateToPackage(productId){
        await router.push({ name: 'package',  params:{ id: productId } })
    }

    /**
     * Navigates to the 'plan z package' route.
     *
     * @async
     * @function
     * @param {string} productId - The id parameter to be passed to the 'product' route.
     * @returns {Promise<void>} A promise that resolves once the navigation is successful.
     */
    async function navigateToPlanZPackage(productId){
        await router.push({ name: 'package.planz',  params:{ id: productId } })
    }

    /**
     * Navigates to the 'finance' route.
     *
     * @async
     * @function
     * @returns {Promise<void>} A promise that resolves once the navigation is successful.
     */
    async function navigateToFinance(){
        await router.push({ name: 'finance' })
    }

    /**
     * Navigates to the 'ostadino' route.
     *
     * @async
     * @function
     * @returns {Promise<void>} A promise that resolves once the navigation is successful.
     */
    async function navigateToOstadino(){
        await router.push({ name: 'ostadino' });
    }

    /**
     * Navigates to the '404' route.
     *
     * @async
     * @function
     * @returns {Promise<void>} A promise that resolves once the navigation is successful.
     */
    async function navigateTo404(){
        await router.push({ name: 'error-404' })
    }

    return {
        navigateToAuth,
        navigateToRegister,
        navigateToRegisterState,
        navigateToTerms,
        navigateToLoginWithPassword,
        navigateToLoginWithOTP,
        navigateToProfile,
        navigateToDashboard,
        navigateToRedirectPath,
        navigateToAuthAfterLogout,
        navigateToNotification,
        navigateToCourse,
        navigateToQuiz,
        navigateToQuizAnswerSheet,
        navigateToHomework,
        navigateToReport,
        navigateToQuestionAnswer,
        navigateToClass,
        navigateToMyCourses,
        navigateToCart,
        navigateToProduct,
        navigateToPackage,
        navigateToPlanZPackage,
        navigateToStore,
        navigateToFinance,
        navigateToOstadino,
        navigateTo404,
    };
}
