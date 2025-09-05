import RepositoryFactory from "@/repository/RepositoryFactory";

const Notification = RepositoryFactory.get("Notification");

export default {
    namespaced: true,
    state: {
        items:[],
        modalItems:[],
        count:0,
        markAsRead: false,
        tab: '',
        notifications: [],
    },
    getters: {
        items(state) {
            return state.items
        },
        modalItems(state){
            return state.modalItems
        },
        count(state){
            return state.count
        },
        notifications: (state) => state.notifications,
        unreadCount: (state)=> {
            return state.notifications.filter((item) => item.unread).length
        }

    },
    mutations:{
        GET_NOTIFICATION_DATA(state, val){
            const notifications = val.filter(value => value.is_modal === false)
            state.items = notifications
            state.count = notifications.length
            state.modalItems = val.filter(value => value.is_modal === true)
        },
        CHANGE_NOTIFICATION_COUNT(state){
            state.count = 0
        },
        MARK_AS_READ(state) {
            state.notifications = state.notifications.map((item)=> {
                return {
                    ...item,
                    unread: false,
                }
            });
        },
        SET_NOTIFICATIONS(state, val) {
            state.notifications = val;
        },
    },
    actions:{
        updateNotificationCount(context, action){
            context.commit('CHANGE_NOTIFICATION_COUNT', action)
        },
        async getUserNotification(context){
            try {
                const { data: { notifications } } = await Notification.getUserNotification();
                context.commit('GET_NOTIFICATION_DATA', notifications)
            }catch (e) {
                console.log(e)
            }
        },
        updateNotifications (context, payload) {
            context.commit('SET_NOTIFICATIONS',payload);
        },
        markAsReadNotifications(context){
            context.commit('MARK_AS_READ');
        },
    },
}
