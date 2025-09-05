import { useCountDown } from "@/composable/useCountDown";
import RepositoryFactory from "@/repository/RepositoryFactory";
import { ref } from "vue";
import { useAlert } from "@/composable/useAlert";

const { error } = useAlert();

/**
 * Otp composable for handling OTP-related functionality.
 * @returns {Object} Otp composable methods and properties.
 */
export function useOtp() {
    const Auth = RepositoryFactory.get("Auth");
    const { startCountDown, countDown } = useCountDown();
    const time = ref(60);

    /**
     * Retrieves the lock time from the server and starts the countdown.
     * @async
     * @param {string} mobile - The user's mobile number.
     */
    async function getLockTime(mobile) {
        try {
            const { data: { lockTime } } = await Auth.lockTime({ 'mobile': mobile });
            time.value = lockTime || 60;
        } catch {
            time.value = 60;
        } finally {
            startCountDown(time.value);
        }
    }

    /**
     * sends the OTP to the user's mobile number.
     * @async
     * @param {string} mobile - The user's mobile number.
     */
    async function sendOtp(mobile) {
        try {
            const { data: { token } } = await Auth.sendOtp({ mobile: mobile });
            await getLockTime(mobile);
        } catch (e) {
            error(e.error?.message);
        }
    }

    // Return the composable methods and properties
    return {
        getLockTime,
        countDown,
        sendOtp
    };
}