import {ref} from "vue";
import RepositoryFactory from "@/repository/RepositoryFactory";
import {useStore} from "vuex";
import {useAlert} from "@/composable/useAlert";

export function useNotifications(){
    const store = useStore();
    const { error } = useAlert();
    const loading = ref(false);
    /**
     * Instance of the Notification repository.
     * @type {import('@/repository/Repository').default}
     */
    const NotificationRepository = RepositoryFactory.get("Notification");

    /**
     * Function to fetch all user notifications.
     * @async
     * @returns {Promise<void>}
     */
    const getUserAllNotifications = async (type) => {
        try {
            loading.value = true;
            const { data } = await NotificationRepository.getUserNotifications(type);
            await store.dispatch('notificationStore/updateNotifications', data.notifications);
        } catch (e) {
            error(e.error?.message);
        } finally {
            loading.value = false;
        }
    };

    const clearNotifications = async ()=> {
        await store.dispatch('notificationStore/updateNotifications', []);
    }
    return {
        loading,
        clearNotifications,
        getUserAllNotifications
    }
}