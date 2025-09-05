/**
 * @created        30/09/2023 - 19:15
 * @author         Nariman Palangi
 * @user           ragnarok
 * @organization
 * @project        boilerplate-vue-3
 * @file name      theme.store.js
 * @file dir       src/store/general
 */
import localStorageService from "../../services/LocalStorage.service";
const theme = localStorageService.get("theme");
const state =()=>({
    /**
     * @description keep current theme
     * @type {String}
     * */
    theme: theme || "dark"

}) ;

const getters={
    theme : (state)=>state.theme,
};

const mutations  ={
    CHANGE_THEME(state,val){
        state.theme = val
        localStorageService.set("theme", val);
    }
};

const actions ={
    setTheme(context, payload){
        context.commit('CHANGE_THEME', payload)
    },
};

export default  {
    namespaced: true,
    name :"theme",
    state,
    getters,
    mutations,
    actions,
}