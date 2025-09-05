
import axiosInstance from "@/config/axios.config";

// The base resource path for the API
const resource = '/api';



/**
 * Repository for notification-related API calls.
 * @namespace NotificationRepository
 * @property {string} resource - The base resource path for the API.
 */
const NotificationRepository = {
    /**
     * get user notification
     * Method | get
     * Api address| /api/user_profile/show
     *
     * @function
     * @memberof NotificationRepository
     * @name getUserNotification
     * @returns {Promise} - A promise representing the result of the getUserNotification API call.
     * @throws Will throw an error if the request fails.
     */
    getUserNotification() {
        return axiosInstance.get(`${resource}/unread`);
    },

    /**
     * get user notifications based on notification type
     * Method | get
     * Api address| /api/:type
     *
     * @function
     * @memberof NotificationRepository
     * @name getUserNotification
     * @params type { String }
     * @returns {Promise} - A promise representing the result of the getUserNotifications based on notification type API call.
     * @throws Will throw an error if the request fails.
     */
    getUserNotifications(type) {
        return axiosInstance.get(`${resource}/${type}`);
    },

    /**
     * remove user notifications based on notification type
     * Method | delete
     * Api address| /api/:type
     *
     * @function
     * @memberof NotificationRepository
     * @name removeUserNotifications
     * @params type { String }
     * @returns {Promise} - A promise representing the result of the removeUserNotifications based on notification type API call.
     * @throws Will throw an error if the request fails.
     */
    removeUserNotifications(type) {
        return axiosInstance.delete(`${resource}/${type}`);
    },

    /**
     * get user all notifications
     * Method | get
     * Api address| /api/all
     *
     * @function
     * @memberof NotificationRepository
     * @name getUserAllNotifications
     * @returns {Promise} - A promise representing the result of the getUserAllNotifications API call.
     * @throws Will throw an error if the request fails.
     */
    getUserAllNotifications() {
        return axiosInstance.get(`${resource}/all`);
    },

    /**
     * mark notifications as read messages
     * Method | post
     * Api address| /api/mark-as-read/unread
     *
     * @function
     * @memberof NotificationRepository
     * @name markAsReadNotifications
     * @returns {Promise} - A promise representing the result of the markAsReadNotifications API call.
     * @throws Will throw an error if the request fails.
     */
    markAsReadNotifications() {
        return axiosInstance.post(`${resource}/mark-as-read/unread`);
    },

    /**
     * mark special notifications as read messages
     * Method | post
     * Api address| /api/mark-as-read/special
     *
     * @function
     * @memberof NotificationRepository
     * @name markAsReadNotifications
     * @params payload { Array }
     * @returns {Promise} - A promise representing the result of the markAsReadSpecialNotifications API call.
     * @throws Will throw an error if the request fails.
     */
    markAsReadSpecialNotifications(payload) {
        return axiosInstance.post(`${resource}/mark-as-read/special`,payload);
    },


}

export default NotificationRepository;