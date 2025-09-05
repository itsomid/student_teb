
import axiosInstance from "@/config/axios.config";

// The base resource path for the API
const resource = '/v1/dashboard';


/**
 * Repository for weekly-schedule-related API calls.
 * @namespace BulletinBoardRepository
 * @property {string} resource - The base resource path for the API.
 */
const WeeklyScheduleRepository = {
    getUserClassesWithinWeek(params) {
        return axiosInstance.get(`${resource}/live_class_within_week`, {
            params : {
                ...params
            }
        });
    },
}

export default WeeklyScheduleRepository;