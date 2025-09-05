<script setup>
/**
 * Vue component for displaying user courses with search functionality.
 * @component
 * @vue
 */
import {computed, defineAsyncComponent, onMounted, reactive, ref, watch} from "vue";
import RepositoryFactory from "@/repository/RepositoryFactory";
import { useAlert } from "@/composable/useAlert";
import { useRoute, useRouter } from "vue-router";
import CourseBanner from "@/components/course/CourseBanner.vue";
import CourseQuizes from "@/components/course/CourseQuizes.vue";
import CourseClasses from "@/components/course/CourseClasses.vue";
import ClError from "@/components/app/ClError.vue";
import {useNavigator} from "@/composable/useNavigator";
import {FOURTIK_PRODUCTS, VALLE_PRODUCTS} from "@/constants/product";
import CourseValleQuizes from "@/components/course/CourseValleQuizes.vue";

const { error } = useAlert();
const { navigateToMyCourses } = useNavigator();
/**
 * Represents the course subscription component.
 * @type {import('vue').DefineComponent}
 */
const CourseSubscription = defineAsyncComponent({
  loader: () => import("./CourseSubscription.vue"),
  delay: 0,
  errorComponent: ClError,
  timeout: 3000,
});

/**
 * Vue router instance.
 * @type {import('vue-router').Router}
 */
const router  = useRouter();

/**
 * Vue route instance.
 * @type {import('vue-router').RouteLocationNormalized}
 */
const route   = useRoute();

/**
 * Ref for storing the current course.
 * @type {import('vue').Ref<Object>}
 */
const course = ref({});

const valleExams = ref();
const isValleExam = computed(()=> VALLE_PRODUCTS.includes(route.params.id));
const isFourTik = computed(()=> FOURTIK_PRODUCTS.includes(route.params.id));

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
const ValleRepository  = RepositoryFactory.get("Valle");

/**
 * Function to fetch user courses from the repository.
 * @async
 * @function
 * @returns {Promise<void>}
 */
const getUserCourse = async () =>{
  try {
    loading.value = true;
    await router.isReady();
    const { data: { data } } = await CourseRepository.getUserCourse(route.params.id);
    course.value = data;
  }catch (e) {
    error(e.error?.message);
    navigateToMyCourses();

  }finally {
    loading.value = false;
  }
};

const getValleExam = async () =>{
  try {
    loading.value = true;
    await router.isReady();
    const { data } = await ValleRepository.getValleExams(route.params.id);
    valleExams.value = data;
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
  getUserCourse();
  if(isValleExam.value) {
    getValleExam();
  }
})

</script>

<template>
  <v-row>
    <CourseSubscription v-if="course.end_subscription_at" :end-date="course.end_subscription_at"/>
    <v-col cols="12">
      <CourseBanner :data="course" :loading="loading" />
    </v-col>
    <v-col cols="12">
      <CourseValleQuizes v-if="isValleExam" :quizzes="valleExams" @update-valle="getValleExam" :loading="loading" />
      <CourseQuizes v-else :quizzes="course.quizzes" :is-fortik="isFourTik"/>
    </v-col>
    <v-col cols="12">
      <CourseClasses :classes="course.classes"/>
    </v-col>
  </v-row>
</template>

<style scoped lang="scss">

</style>