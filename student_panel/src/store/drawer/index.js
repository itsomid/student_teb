export default {
    namespaced: true,
    state: {
        drawer: true,
    },
    getters: {
        drawer(state) {
            return state.drawer
        }
    },
    mutations:{
        CHANGE_DRAWER_STATE(state, val){
            state.drawer = val
        },
        TOGGLE_DRAWER(state){
            state.drawer = !state.drawer;
        }
    },
    actions:{
        openDrawer(context){
            context.commit('CHANGE_DRAWER_STATE', true)
        },
        closeDrawer(context) {
            context.commit('CHANGE_DRAWER_STATE', false)
        },
        toggleDrawer(context) {
            context.commit('TOGGLE_DRAWER')
        }
    },
}
