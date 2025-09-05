import {NAVBAR_ACTIONS} from "@/constants/navbarActions.const";

export default {
    namespaced: true,
    state: {
        title: '',
        actions: Object.values(NAVBAR_ACTIONS),
    },
    getters: {
        title : (state) => state.title,
        actions : (state) => state.actions,
    },
    mutations:{
        SET_TITLE(state, value){
            state.title = value;
        },
        SET_ACTIONS(state,value) {
            state.actions = value;
        },
    },
    actions:{
        updateTitle(context, payload){
            context.commit('SET_TITLE', payload)
        },
        updateActions(context, payload){
            context.commit('SET_ACTIONS', payload)
        },
    },
}
