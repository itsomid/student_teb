export default {
    namespaced: true,
    state: {
        filters: null,
        professor: null,
        planz: {},
    },
    getters:{
        selectedProfessor(state) {
            return state.professor
        },
        filters(state){
            return state.filters;
        }
    },
    mutations: {
        SET_PROFESSOR(state, professor){
            state.professor = professor
        },
        SET_FILTERS(state, filters){
            state.filters = filters
        },
        ADD_COURSE_TO_PLANZ_PACKAGE(state, payload){
            state.planz[`${payload.sectionId}`] = payload.teacherId;
        }
    },
    actions: {
        updateProfessor(context, payload){
            context.commit('SET_PROFESSOR', payload)
        },
        updateFilters(context, payload){
            context.commit('SET_FILTERS', payload)
        },
    },
}
