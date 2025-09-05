/**
 * Configuration url for WebSocket connection.
 * @typedef {Object} SocketConfig
 * @property {string} PROTOCOL - The protocol used for WebSocket connection (either 'ws' or 'wss').
 * @property {string} HOST - The hostname of the WebSocket server.
 * @property {number} PORT - The port number of the WebSocket server.
 */

/**
 * Object containing WebSocket channel names.
 * @typedef {Object} SocketChannels
 * @property {string} CONNECT - Channel name for connection event.
 * @property {string} DISCONNECT - Channel name for disconnection event.
 * @property {string} CLIENT_RECEIVE_MESSAGE - Channel name for client receive message event.
 * @property {string} CLIENT_RECEIVE_HISTORY - Channel name for client receive history event.
 * @property {string} CLIENT_CONVERSATION_HISTORY - Channel name for client conversation history event.
 * @property {string} SERVER_JOIN - Channel name for server join event.
 * @property {string} SERVER_REFRESH_CHAT_BOX - Channel name for server refresh chat box event.
 * @property {string} SERVER_HISTORY - Channel name for server history event.
 * @property {string} SERVER_SEND_MESSAGE - Channel name for server send message event.
 */

/**
 * Configuration object for WebSocket connection.
 * @type {SocketConfig}
 */
export const SOCKET_CONFIG = {};

/**
 * Configuration url for WebSocket connection.
 * @type {SocketConfig}
 */
export const SOCKET_URL = {
    PROTOCOL: `${window.location.hostname}` === 'localhost' ? 'ws' : 'wss',
    HOST    : window.location.hostname,
    PORT    : 3003
};


/**
 * Object containing WebSocket channel names.
 * @type {SocketChannels}
 */
export const SOCKET_CHANNELS = {
    CONNECT                     : 'connect',
    DISCONNECT                  : 'disconnect',
    CLIENT_RECEIVE_MESSAGE      : 'client:receive-message',
    CLIENT_RECEIVE_HISTORY      : 'client:receive-history',
    CLIENT_CONVERSATION_HISTORY : 'client:conversation-history',
    SERVER_JOIN                 : 'server:join',
    SERVER_READ_CONVERSATION    : 'server:read-conversation',
    SERVER_REFRESH_CHAT_BOX     : 'server:refresh-chatbox',
    SERVER_HISTORY              : 'server:history',
    SERVER_SEND_MESSAGE         : 'server:send-message',

};