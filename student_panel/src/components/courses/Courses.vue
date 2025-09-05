<script setup>
/**
 * Vue component for displaying user courses with search functionality.
 * @component
 * @vue
 */
import {onMounted, ref, watch} from "vue";
import RepositoryFactory from "@/repository/RepositoryFactory";
import {useAlert} from "@/composable/useAlert";
import ClLoading from "@/components/base/ClLoading.vue";
import Course from "@/components/courses/Course.vue";
import CoursesSearch from "@/components/courses/CoursesSearch.vue";
import CourseEmpty from "@/components/courses/CourseEmpty.vue";

const { error } = useAlert();
/**
 * Ref for tracking the loading state.
 * @type {import('vue').Ref<boolean>}
 */
const loading = ref(false);

/**
 * User repository instance.
 * @type {import('@/repository/Repository').default}
 */
const CourseRepository = RepositoryFactory.get("Course");

/**
 * Ref for storing the array of all user courses.
 * @type {import('vue').Ref<Array<Object>>}
 */
const items = ref([]);

/**
 * Ref for storing the array of filtered user courses based on search.
 * @type {import('vue').Ref<Array<Object>>}
 */
const filteredItems = ref([]);

/**
 * Ref for storing the search term.
 * @type {import('vue').Ref<string>}
 */
const search = ref("");

/**
 * Function to fetch user courses from the repository.
 * @async
 * @function
 * @returns {Promise<void>}
 */
const getUserCourses = async () =>{
  try {
    loading.value = true;
    const { data: { data } } = await CourseRepository.getUserCourses();
    items.value = data;
    filteredItems.value = data;
  }catch (e) {
    error(e.error?.message);
  }finally {
    loading.value = false;
  }
};

/**
 * Lifecycle hook that runs after the component has been mounted.
 * Fetches user courses.
 */
onMounted(()=>{
  getUserCourses();
})

/**
 * Watcher for the search term.
 * Filters the items array based on the search term.
 */
watch(search, (newValue) => {
  filteredItems.value = [];
  filteredItems.value = items.value.filter((item)=> item.name.includes(newValue))
})
</script>

<template>
  <ClLoading v-if="loading" />
  <v-row v-else>
    <v-col v-if="items.length" cols="12">
        <v-row align="center" justify="center" >
          <v-col cols="12" md="6" lg="4" class="mt-11">
            <CoursesSearch v-model="search"/>
          </v-col>
        </v-row>
    </v-col>
    <template v-if="items.length">
      <v-col cols="12" md="4" lg="3" v-for="item in filteredItems" :key="'course-' + item.course_id">
        <Course  :item="item" />
      </v-col>
    </template>
    <div v-else class="mx-3 w-100">
      <CourseEmpty />
    </div>
  </v-row>
</template>

<style scoped lang="scss">

</style>