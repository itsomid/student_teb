 import axios from "axios";
 import RepositoryFactory from "@/repository/RepositoryFactory";

 const User = RepositoryFactory.get("User");
export default {
    namespaced: true,
    state: {
        user: JSON.parse(localStorage.getItem('userData')) || {
            name: '',
            mobile: '',
            credit: '',
            imgFileName: '',
            uid: '',
            id: '',
            grade: '',
            nationalCodeStatus: '',
            is_profile_updated: 0,
            block: '',
            blockReasonDescription: '',
            blockReasonImage: '',
            city: '',
            province: '',
            sex: '',
        },
        isLoading: false,
    },
    getters: {
        id(state){
          return state.user.id;
        },
        userData(state) {
            return state.user
        },
        blockReason(state){
            return{
                image: state.user.blockReasonImage,
                description: state.user.blockReasonDescription
            }
        },
        userImage(state){
            return state.user.imgFileName
        },
        credit(state) {
            return state.user.credit;
        },
        grade(state) {
            return state.user.grade ? state.user.grade : null;
        },
        fieldOfStudy(state) {
            return state.user.grade ? Number(state.user.field_of_study) : null;
        },
        isProfileUpdated(state){
            // return !!state.user.is_profile_updated
            return !!state.user.is_profile_updated
        }
    },
    mutations: {
        UPDATE_PROFILE(state, val) {
            state.user = val
            localStorage.setItem('userData', JSON.stringify(state.user))
        },
        TURN_LOADING_ON(state, status) {
            state.isLoading = status
        },
    },
    actions: {
        async updateProfile(context) {
            context.commit('TURN_LOADING_ON', true);
            const { data: { data } } = await User.userProfile();
            context.commit('UPDATE_PROFILE', data)
            context.commit('TURN_LOADING_ON', false)
        },
    },
}
