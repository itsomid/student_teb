export default {
    namespaced: true,
    state: {
        dialog: false,
    },
    getters: {
        dialog(state) {
            return state.dialog
        }
    },
    mutations:{
        CHANGE_DIALOG_STATE(state, val){
            state.dialog = val
        },
        TOGGLE_DIALOG(state){
            state.dialog = !state.dialog;
        }
    },
    actions:{
        openDialog(context){
            context.commit('CHANGE_DIALOG_STATE', true)
        },
        closeDialog(context) {
            context.commit('CHANGE_DIALOG_STATE', false)
        },
        toggleDialog(context) {
            context.commit('TOGGLE_DIALOG')
        }
    },
}
