import { ref } from 'vue';
import { io } from 'socket.io-client';
import { SOCKET_URL, SOCKET_CONFIG } from "@/config/socket.config";

/**
 * Creates a socket connection.
 * @returns {Object} An object containing the socket connection and related functions.
 */
export function SocketService() {
     let socket = null;

    /**
     * Connects to the WebSocket server using the provided URL and options.
     * @param {Object} [URL=SOCKET_URL] - The URL object containing protocol, host, and port.
     * @param {Object} [OPTIONS=SOCKET_CONFIG] - The options object for configuring the connection.
     * @returns {Object} The socket connection object.
     * @tutorial https://socket.io/docs/v3/client-initialization/
     */
    function connect(URL = SOCKET_URL, OPTIONS = SOCKET_CONFIG) {
        socket = io(`${URL.PROTOCOL}://${URL.HOST}:${URL.PORT}`, OPTIONS);
        return socket;
    }

    /**
     * Disconnects the socket connection.
     */
    function disconnect() {
        if (socket) {
            socket.disconnect();
        }
    }

    return {
        /**
         * The socket connection object.
         * @type {Object}
         */
        socket,
        /**
         * Function to establish a socket connection.
         * @type {Function}
         */
        connect,
        /**
         * Function to disconnect the socket connection.
         * @type {Function}
         */
        disconnect,
    };
}
