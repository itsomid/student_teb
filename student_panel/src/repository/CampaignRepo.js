import axiosInstance from "@/config/axios.config";

const resource = '/v1/campaign';

const CampaignRepository = {
  getHadsinoStudentMarks(){
    return axiosInstance.get(`${resource}/get_real_marks`);
  },
  getHadsinoMarks(){
    return axiosInstance.get(`${resource}/get_marks`);
  },
  updateHadsinoMarks(payload){
    return axiosInstance.patch(`${resource}/update_marks`, payload);
  },
  submitFinalMarks(payload){
    return axiosInstance.post(`${resource}/submit_final_result`, payload);
  },
}

export default CampaignRepository;