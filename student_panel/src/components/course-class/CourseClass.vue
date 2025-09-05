<script setup>
/**
 * Vue component for displaying user course class with search functionality.
 * @component
 * @vue
 */
import { onMounted, ref } from "vue";
import RepositoryFactory from "@/repository/RepositoryFactory";
import { useAlert } from "@/composable/useAlert";
import { useRoute, useRouter } from "vue-router";
import CourseClassBanner from "@/components/course-class/banner/CourseClassBanner.vue";
import StudyHub from "@/components/course-class/study-hub/StudyHub.vue";
import GuideInsightHub from "@/components/course-class/guide-insight-hub/GuideInsightHub.vue";
import {useNavigator} from "@/composable/useNavigator";

const { error, info } = useAlert();
const { navigateToMyCourses } = useNavigator();
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

const courseBanner = ref({})
/**
 * Ref for tracking the loading state.
 * @type {import('vue').Ref<boolean>}
 */
const loading = ref(false);

/**
 * class repository instance.
 * @type {import('@/repository/Repository').default}
 */
const ClassRepository = RepositoryFactory.get("Class");

/**
 * Function to fetch user course's class from the repository.
 * @async
 * @function
 * @returns {Promise<void>}
 */
const getUserCourseClass = async () =>{
  try {
    loading.value = true;
    await router.isReady();
    const { data: { data } } = await ClassRepository.getUserCourseClass(route.params.id);
    course.value = data;
  }catch (e) {
    if (e.error?.status === 403) {
      await router.push({name: 'store'});
      info("دوره انتخابی خریداری نشده ابتدا دوره مورد نظر را خریداری کنید");
    }
    if (e.error?.status === 404) {
      await router.push({name: 'error-404'});
    }
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
  getUserCourseClass();
})
</script>

<template>
  <v-row>
    <v-col cols="12">
      <CourseClassBanner :data="course" :loading="loading" />
    </v-col>
    <v-col cols="12">
      <StudyHub :data="course" :loading="loading" />
    </v-col>
    <v-col cols="12">
      <v-row>
        <v-col cols="12" lg="6">
          <GuideInsightHub :description="course.description" :className="course.name" :loading="loading"/>
        </v-col>
      </v-row>
    </v-col>
  </v-row>
</template>

<style scoped lang="scss">

</style>