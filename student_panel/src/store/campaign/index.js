import axios from "axios";
import RepositoryFactory from "@/repository/RepositoryFactory";

const CampaignRepo = RepositoryFactory.get("Campaign");
export default {
    namespaced: true,
    state: {
        report: null,
        real_report: null,
    },
    getters: {
        report(state){
            return state.report;
        },
        real_report(state){
            return state.real_report;
        },
        hasReport(state){
            return !!state.report?.avg_score
        },
        hasRealReport(state){
            return !!state.real_report?.real_avg_score
        }
    },
    mutations: {
        UPDATE_REPORT(state, val) {
            state.report = val
        },
        UPDATE_REAL_REPORT(state, val) {
            state.real_report = val
        },
    },
    actions: {
        async getStudentRealReport(context) {
            const { data } = await CampaignRepo.getHadsinoStudentMarks();
            context.commit('UPDATE_REAL_REPORT', data)
        },
        async getStudentReport(context) {
            const { data } = await CampaignRepo.getHadsinoMarks();
            context.commit('UPDATE_REPORT', data)
        },
        async updateStudentReport(context, payload) {
            try {
                const { data } = await CampaignRepo.updateHadsinoMarks(payload);
                await context.dispatch('getStudentReport');

            }catch (e) {
                console.log(e)
                return Promise.reject(e);
            }
        },
        async submitStudentFinalReport(context, payload) {
            try {
                const { data } = await CampaignRepo.submitFinalMarks(payload);
            }catch (e) {
                console.log(e)
                return Promise.reject(e);
            }
        },
    },
}
