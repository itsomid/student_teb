/**
 * Vuex module for managing selected courseClass in dashboard calendar.
 * @module courseClass
 */
export default {
    namespaced: true,
    state: () => ({
        /**
         * The selected course class in dashboard calendar.
         * @type {Object|null}
         */
        courseClass: null,
        notificationDrawer: false,
        classDrawer: false,
    }),
    getters: {
        /**
         * Get the selected course class.
         * @param {Object} state - The current state.
         * @returns {Object|null} The selected course class.
         */
        courseClass: (state) => state.courseClass,

        /**
         * Check if a course class is selected.
         * @param {Object} state - The current state.
         * @returns {boolean} True if a course class is selected, otherwise false.
         */
        classDrawer: (state) => state.classDrawer,
        notificationDrawer: (state) => state.notificationDrawer,
    },
    mutations: {
        /**
         * Set the selected course class.
         * @param {Object} state - The current state.
         * @param {Object} courseClass - The course class to set.
         */
        SET_COURSE_CLASS(state, courseClass) {
            state.courseClass = courseClass;
        },

        SET_CLASS_DRAWER(state,value){
            state.classDrawer = value;
        },
        SET_NOTIFICATION_DRAWER(state,value){
            state.notificationDrawer = value;
        }
    },
    actions: {
        /**
         * Update the selected course class.
         * @param {Function} commit - The Vuex commit function.
         * @param {Object} courseClass - The new course class to set.
         */
        async updateCourseClass({ commit }, courseClass) {
            commit('SET_COURSE_CLASS', courseClass);
        },
        async clearCourseClass({ commit }) {
            commit('SET_COURSE_CLASS', null);
        },
        openClassDrawer({ commit }){
            commit('SET_CLASS_DRAWER', true);
        },
        closeClassDrawer({ commit }){
            commit('SET_CLASS_DRAWER', false);
        },
        openNotificationDrawer({ commit }){
            commit('SET_NOTIFICATION_DRAWER', true);
        },
        closeNotificationDrawer({ commit }){
            commit('SET_NOTIFICATION_DRAWER', false);
        },
    },
};
