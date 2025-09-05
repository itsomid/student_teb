import {watch,ref} from "vue";

/**
 * Composable function to handle section and course selection.
 *
 * @param {Ref<Object>} product - A ref that holds the product data.
 * @returns {Object} - An object containing the selected courses, a function to get the selected course for a section,
 *                     a function to select a course, and a function to mark the selection as finished.
 * @property {Object} selectedCourses - A reactive object that holds the selected courses by section ID.
 * @property {Function} sectionSelected - A function that returns the selected course for a given section ID.
 * @property {Function} select - A function to select a course for a given section.
 * @property {Function} onClickFinish - A function to mark the selection process as finished.
 */
export function useSectionSelection(product,initialSelectedItems) {
    // Reactive object to store selected courses by section ID
    const selectedCourses = initialSelectedItems;

    const currentStep = ref(0);

    // Ref to store the finished state
    const finished = ref(false);

    /**
     * Returns the selected course for a given section ID.
     *
     * @param {number} sectionId - The ID of the section.
     * @returns {Object} - The selected course for the given section.
     */
    const sectionSelected = (sectionId) => {
        const productId = selectedCourses[sectionId];
        const section = product.value.sections.find(section => section.id == sectionId);
        return section.courses.find(course => course.product_id === productId);
    };

    /**
     * Selects a course for a given section.
     *
     * @param {Object} item - An object containing the section ID and product ID of the course to be selected.
     */
    const select = (item) => {
        selectedCourses[item.section_id] = item.product_id;
    };

    /**
     * Marks the selection process as finished.
     */
    const onClickFinish = () => {
        finished.value = true;
    };

    watch(selectedCourses,(value)=>{
        if(value && Object.keys(value).length) {
            currentStep.value = Object.keys(value).length + 1;
        }
    },{immediate:true})

    return { selectedCourses, sectionSelected, select, onClickFinish, currentStep };
}
