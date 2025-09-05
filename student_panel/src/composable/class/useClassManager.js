
// src/composables/useClassManager.js

import { ref } from 'vue';
import RepositoryFactory from '@/repository/RepositoryFactory';
import { useAlert } from '@/composable/useAlert';

// Class repository instance
const ClassRepository = RepositoryFactory.get('Class');

export function useClassManager() {
    const { error } = useAlert();

    // Refs for storing state
    const course = ref({});
    const loading = ref(false);

    /**
     * Function to fetch user course's class from the repository.
     * @async
     * @function
     * @param {number} class_id - The ID of the class to fetch.
     * @returns {Promise<void>}
     */
    const getUserCourseClass = async (class_id) => {
        try {
            loading.value = true;
            const { data: { data } } = await ClassRepository.getUserCourseClass(class_id);
            course.value = data;
        } catch (e) {
            error(e.error?.message);
        } finally {
            loading.value = false;
        }
    };

    return {
        course,
        loading,
        getUserCourseClass
    };
}
