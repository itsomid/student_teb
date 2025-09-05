
import axiosInstance from "@/config/axios.config";
import axios from "axios";
// The base resource path for the API
const resource = '/api/user';


/**
 * Repository for chat-related API calls.
 * @namespace ChatRepository
 * @property {string} resource - The base resource path for the API.
 */
const ChatRepository = {
    /**
     * get User Unread Messages
     * Method | get
     * Api address| /api/user/notification/unread-message/count
     *
     * @function
     * @memberof ChatRepository
     * @name getUserUnreadMessage
     * @returns {Promise} - A promise representing the result of the getUserUnreadMessage API call.
     * @throws Will throw an error if the request fails.
     */
    getUserUnreadMessage() {
        return axiosInstance.get(`${resource}/notification/unread-message/count`);
    },

    /**
     * delete chat
     * Method | delete
     * Api address| /api/user/client/chat/${chat_id}
     *
     * @function
     * @memberof ChatRepository
     * @name deleteChat
     * @returns {Promise} - A promise representing the result of the deleteChat API call.
     * @throws Will throw an error if the request fails.
     */
    deleteChat(chat_id) {
        return axiosInstance.delete(`${resource}/client/chat/${chat_id}`);
    },

    /**
     * upload voice
     * Method | post
     * Api address| VITE_APP_STORE_FOUR_UPLOAD_BASE_URL/api/upload/chat
     *
     * @function
     * @memberof ChatRepository
     * @name uploadVoice
     * @returns {Promise} - A promise representing the result of the uploadVoice API call.
     * @throws Will throw an error if the request fails.
     */
    uploadVoice(payload) {
        return axios.post(`${import.meta.env.VITE_APP_STORE_FOUR_UPLOAD_BASE_URL}/api/upload/chat`,payload);
    },
}

export default ChatRepository;