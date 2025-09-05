
import axiosInstance from "@/config/axios.config";

// The base resource path for the API
const resource = '/api/user/course';

//TODO CHANGE THIS PREFIX ON SERVER WRITE TO 'api/user/course/:class_id/comment'
const resource_comment = "api/panel/course"
const resource_report = "api/panel/class"
const resource_quiz = "api/user/quiz"
const resource_quizzes = "api/panel/quizzes"
const resource_absence = "api/panel/absence"

/**
 * Repository for user-related API calls.
 * @namespace ClassRepository
 * @property {string} resource - The base resource path for the API.
 */
const ClassRepository = {

    /**
     * Retrieves details of a specific user course class by class ID.
     * Method | get
     * Api address| /api/user/course/classes/:id
     *
     * @function
     * @memberof ClassRepository
     * @name getUserCourseClass
     * @param {string} class_id - ID of the class of course to retrieve details for.
     * @returns {Promise} A promise representing the result of the getUserCourseClass API call.
     * @throws {Error} Will throw an error if the request fails.
     */
    getUserCourseClass(class_id) {
        return axiosInstance.get(`${resource}/classes/${class_id}`)
    },

    /**
     * Retrieves grade of a specific user course class by class ID.
     * Method | get
     * Api address| /api/user/course/classes/:id/grade
     *
     * @function
     * @memberof ClassRepository
     * @name getUserCourseGrade
     * @param {string} class_id - ID of the class of course to retrieve grade for.
     * @returns {Promise} A promise representing the result of the getUserCourseGrade API call.
     * @throws {Error} Will throw an error if the request fails.
     */
    getUserCourseGrade(class_id) {
        return axiosInstance.get(`${resource}/classes/${class_id}/grade`)
    },


    /**
     * send feedback of a specific user course about class by class ID.
     * Method | post
     * Api address| /api/panel/course/:class_id/comment
     *
     * @function
     * @memberof ClassRepository
     * @name feedback
     * @param {Object} payload - The payload containing feedback information.
     * @param {string} class_id - ID of the class of course to retrieve details for.
     * @returns {Promise} A promise representing the result of the feedback API call.
     * @throws {Error} Will throw an error if the request fails.
     */
    feedback(class_id,payload) {
        return axiosInstance.post(`${resource_comment}/${class_id}/comment`, payload)
    },

    /**
     * send feedback of a specific user course about class by class ID.
     * Method | post
     * Api address| /api/panel/class/:class_id/report
     *
     * @function
     * @memberof ClassRepository
     * @name report
     * @param {Object} payload - The payload containing report information.
     * @param {string} class_id - ID of the class of course to retrieve details for.
     * @returns {Promise} A promise representing the result of the report API call.
     * @throws {Error} Will throw an error if the request fails.
     */
    report(class_id,payload) {
        return axiosInstance.post(`${resource_report}/${class_id}/report`, payload)

    },

    /**
     * send feedback of a specific user course about class by class ID.
     * Method | post
     * Api address| /api/panel/class/:class_id/homeworks
     *
     * @function
     * @memberof ClassRepository
     * @name homework
     * @param {Object} payload - The payload containing homework information.
     * @param {string} class_id - ID of the class of course to retrieve details for.
     * @returns {Promise} A promise representing the result of the homework API call.
     * @throws {Error} Will throw an error if the request fails.
     */
    homework(class_id,payload) {
        return axiosInstance.post(`${resource_report}/${class_id}/homeworks`, payload)
    },

    /**
     * Retrieves quiz of a specific user course class by quiz ID.
     * Method | get
     * Api address| /api/user/quiz/:quiz_id
     *
     * @function
     * @memberof ClassRepository
     * @name getQuiz
     * @param {string} quiz_id - ID of the quiz of class to retrieve quiz for.
     * @returns {Promise} A promise representing the result of the getQuiz API call.
     * @throws {Error} Will throw an error if the request fails.
     */
    getQuiz(quiz_id) {
        return axiosInstance.get(`${resource_quiz}/${quiz_id}`)
    },

    /**
     * send answer of a specific user course quiz by quiz ID.
     * Method | post
     * Api address| /api/panel/quizzes/:quiz_id
     *
     * @function
     * @memberof ClassRepository
     * @name sendQuizAnswer
     * @param {Object} payload - The payload containing answers information.
     * @param {string} quiz_id - ID of the quiz of course/class to retrieve details for.
     * @returns {Promise} A promise representing the result of the sendQuizAnswer API call.
     * @throws {Error} Will throw an error if the request fails.
     */
    sendQuizAnswer(quiz_id,payload) {
        return axiosInstance.post(`${resource_quizzes}/${quiz_id}`, payload)
    },

    /**
     * Retrieves answer of a specific user course quiz by quiz ID.
     * Method | get
     * Api address| /api/user/quiz/:quiz_id/answer-sheet
     *
     * @function
     * @memberof ClassRepository
     * @name getQuizAnswer
     * @param {string} quiz_id - ID of the quiz of class to retrieve answer for.
     * @returns {Promise} A promise representing the result of the getQuizAnswer API call.
     * @throws {Error} Will throw an error if the request fails.
     */
    getQuizAnswer(quiz_id) {
        return axiosInstance.get(`${resource_quiz}/${quiz_id}/answer-sheet`)
    },

    /**
     * Retrieves recorded classes of a specific user course  by class ID.
     * Method | get
     * Api address| api/user/course/classes/recorded/:class_id
     *
     * @function
     * @memberof ClassRepository
     * @name getRecordedClass
     * @param {string} class_id - ID of the class to retrieve recorded video for.
     * @returns {Promise} A promise representing the result of the getRecordedClass API call.
     * @throws {Error} Will throw an error if the request fails.
     */
    getRecordedClass(class_id) {
        return axiosInstance.get(`${resource}/classes/recorded/${class_id}`)
    },

    /**
     * set present of a specific user course  by class ID.
     * Method | post
     * Api address| api/panel/absence/:class_id
     *
     * @function
     * @memberof ClassRepository
     * @name setUserClassPresent
     * @param {string} class_id - ID of the class to set present for.
     * @param {object} payload - watch online.
     * @returns {Promise} A promise representing the result of the setUserClassPresent API call.
     * @throws {Error} Will throw an error if the request fails.
     */
    setUserClassPresent(class_id,payload = {}) {
        return axiosInstance.post(`${resource_absence}/${class_id}`,payload)
    },

    /**
     * Retrieves user question and answer about a classes  by class ID.
     * Method | get
     * Api address| api/user/course/classes/:class_id/question_answer
     *
     * @function
     * @memberof ClassRepository
     * @name getQuestionAnswer
     * @param {string} class_id - ID of the class to retrieve qa for.
     * @returns {Promise} A promise representing the result of the getQuestionAnswer API call.
     * @throws {Error} Will throw an error if the request fails.
     */
    getQuestionAnswer(class_id) {
        return axiosInstance.get(`${resource}/classes/${class_id}/question_answer`);
    },

    /**
     * Retrieves user question and answer classes about a  by class ID.
     * Method | get
     * Api address| api/user/courses/classes/:class_id?check_purchased=1
     *
     * @function
     * @memberof ClassRepository
     * @name getQuestionAnswerClasses
     * @param {string} class_id - ID of the class to retrieve qa classes.
     * @returns {Promise} A promise representing the result of the getQuestionAnswerClasses API call.
     * @throws {Error} Will throw an error if the request fails.
     */
    getQuestionAnswerClasses(class_id) {
        return axiosInstance.get(`${resource}s/classes/${class_id}?check_purchased=1`);
    },

    /**
     * ask question about a specific class of course.
     * Method | post
     * Api address| /api/panel/class/:class_id/question_answer
     *
     * @function
     * @memberof ClassRepository
     * @name askQuestion
     * @param {Object} payload - The payload containing question information.
     * @param {string} class_id - ID of the class of course .
     * @returns {Promise} A promise representing the result of the askQuestion API call.
     * @throws {Error} Will throw an error if the request fails.
     */
    askQuestion(class_id,payload) {
        return axiosInstance.post(`${resource_report}/${class_id}/question_answer`, payload)
    },
}

export default ClassRepository;