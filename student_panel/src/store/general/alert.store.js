/**
 * @created        15/09/2023 - 18:57
 * @author         Nariman Palangi
 * @user           ragnarok
 * @organization
 * @project        boilerplate-vue-3
 * @file name      alert.store.js
 * @file dir       src/store/general
 */
const state =()=>({
    /**
     * @description alert data example: {
     *     text: "alert text message",
     *     type: "alert type ['error','success','warning']"
     * }
     * @type {Object}
     * */
    data: {}

}) ;

const getters={
    data : (state)=>state.data,
};

const mutations  ={
    CHANGE_ALERT_DATA(state,val){
        state.data = val
    }
};

const actions ={
    setAlertData(context, payload){
        context.commit('CHANGE_ALERT_DATA', payload)
    },
};

export default  {
    namespaced: true,
    name :"alert",
    state,
    getters,
    mutations,
    actions,
}