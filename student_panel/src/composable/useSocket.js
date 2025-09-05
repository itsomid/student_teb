import { ref } from 'vue';
import { SocketService } from "@/services/Socket.service";
import {SOCKET_CHANNELS } from "@/config/socket.config";


export function useSocketService() {
    const socket = ref(null);

    function connectSocket(callback) {
        socket.value = new SocketService().connect();
        listener(SOCKET_CHANNELS.CONNECT, callback);
        return socket;
    }

    function disconnectSocket() {
        if (socket.value) {
            socket.value.disconnect();
        }
    }

    function connectListener(callback){
        listener(SOCKET_CHANNELS.CONNECT, callback);
    }
    function receiveMessageSocketListener(callback){
        listener(SOCKET_CHANNELS.CLIENT_RECEIVE_MESSAGE, callback);
    }

    function emitToGetServerHistoryListener(payload,callBack) {
        emitter(SOCKET_CHANNELS.SERVER_READ_CONVERSATION,payload,callBack);
    }

    function receiveHistoryListener(callback) {
        listener(SOCKET_CHANNELS.CLIENT_RECEIVE_HISTORY, callback);
    }

    function conversationHistoryListener(callback) {
        listener(SOCKET_CHANNELS.CLIENT_CONVERSATION_HISTORY, callback);
    }

    function requestToJoinChatServer(payload,callBack){
        emitter(SOCKET_CHANNELS.SERVER_JOIN,payload,callBack);
    }

    function serverHistorySocketEmitter(payload,callBack){
        emitter(SOCKET_CHANNELS.SERVER_HISTORY,payload,callBack);
    }

    function serverRefreshChatBoxSocketEmitter(payload,callBack){
        emitter(SOCKET_CHANNELS.SERVER_REFRESH_CHAT_BOX,payload,callBack);
    }

    function serverSendMessageEmitter(socket,payload,callBack){
        socket.value.emit(SOCKET_CHANNELS.SERVER_SEND_MESSAGE,payload,(response) => callBack(response));
        // emitter(SOCKET_CHANNELS.SERVER_SEND_MESSAGE,payload,callBack);
    }

    function listener(channel, callback) {
        socket.value.on(channel,(response) => callback(response))
    }

    function emitter(channel,payload,callback){
        socket.value.emit(channel,payload,(response) => callback(response));
    }


    return {
        socket,
        connectSocket,
        connectListener,
        disconnectSocket,
        receiveMessageSocketListener,
        receiveHistoryListener,
        conversationHistoryListener,
        requestToJoinChatServer,
        serverHistorySocketEmitter,
        serverRefreshChatBoxSocketEmitter,
        serverSendMessageEmitter,
        emitToGetServerHistoryListener,
        listener,
        emitter,
    };
}

