
import axiosInstance from "@/config/axios.config";

// The base resource path for the API
const resource = '/api/user/courses';
const resource_quiz_activity = '/api/user/quiz/chart';
/**
 * Repository for user-related API calls.
 * @namespace CourseRepository
 * @property {string} resource - The base resource path for the API.
 */
const CourseRepository = {

    /**
     * Retrieves a list of user courses.
     * Method | get
     * Api address| /api/user/courses
     *
     * @function
     * @memberof CourseRepository
     * @name getUserCourses
     * @returns {Promise} - A promise representing the result of the getUserCourses API call.
     * @throws Will throw an error if the request fails.
     */
    getUserCourses() {
        return axiosInstance.get(`${resource}`)
    },

    /**
     * Retrieves details of a specific user course by its ID.
     * Method | get
     * Api address| /api/user/courses/:id
     *
     * @function
     * @memberof CourseRepository
     * @name getUserCourse
     * @param {string} course_id - ID of the course to retrieve details for.
     * @returns {Promise} A promise representing the result of the getUserCourse API call.
     * @throws {Error} Will throw an error if the request fails.
     */
    getUserCourse(course_id) {
        return axiosInstance.get(`${resource}/${course_id}`)
    },

    /**
     * Retrieves details of a specific user course activity by its course ID.
     * Method | get
     * Api address| /api/user/courses/:id
     *
     * @function
     * @memberof CourseRepository
     * @name getCourseActivity
     * @param {string} course_id - ID of the course to retrieve details for.
     * @returns {Promise} A promise representing the result of the getCourseActivity API call.
     * @throws {Error} Will throw an error if the request fails.
     */
    getCourseActivity(course_id){
        return axiosInstance.get(`${resource_quiz_activity}/${course_id}`)
    },

    /**
     * Retrieves a user class absence situation.
     * Method | get
     * Api address| /api/user/courses/absence/situation/:course_id
     *
     * @function
     * @memberof CourseRepository
     * @name getUserCourses
     * @returns {Promise} - A promise representing the result of the getUserAbsenceSituation API call.
     * @throws Will throw an error if the request fails.
     */
    getUserAbsenceSituation(course_id) {
        return axiosInstance.get(`${resource}/absence/situation/${course_id}`);
    },
}

export default CourseRepository;