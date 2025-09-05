import RepositoryFactory from "@/repository/RepositoryFactory";

const Chat = RepositoryFactory.get("Chat");
export default {
    namespaced: true,
    state: {
        userChatUnreadMessage:''
    },
    getters: {
        userChatUnreadMessage(state){
            return state.userChatUnreadMessage
        }
    },
    mutations:{
        UNREAD_MESSAGES(state, val){
            state.userChatUnreadMessage = val
        }
    },
    actions:{
        async getUserUnreadMessage(context){
            Chat.getUserUnreadMessage().then((res)=> {
                const { data: { data } } = res;
                context.commit('UNREAD_MESSAGES', data.unread_message)
            }).catch(()=>{
                console.log('خطای ارتباط با سرور')
            })
        }
    },
}
