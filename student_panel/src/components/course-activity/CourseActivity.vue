<script setup>

import ClLoadingOverlay from "@/components/base/ClLoadingOverlay.vue";
import {computed, onMounted, ref} from "vue";
import {useStore} from "vuex";
import {useRoute, useRouter} from "vue-router";
import RepositoryFactory from "@/repository/RepositoryFactory";
import CourseActivityQuizChart from "@/components/course-activity/CourseActivityQuizChart.vue";
import CourseActivityQuizzes from "@/components/course-activity/CourseActivityQuizzes.vue";
import CourseActivityUserAbsenceSituation from "@/components/course-activity/CourseActivityUserAbsenceSituation.vue";

const route = useRoute();
const router = useRouter();

/**
 * Ref for tracking the loading state.
 * @type {import('vue').Ref<boolean>}
 */
const loading = ref(false);

const quizData = ref();
const store = useStore();
const user = computed(()=> store.getters['userStore/userData']);

/**
 * User repository instance.
 * @type {import('@/repository/Repository').default}
 */
const CourseRepository = RepositoryFactory.get("Course");

/**
 * Function to fetch user courses from the repository.
 * @async
 * @function
 * @returns {Promise<void>}
 */
const getCourseActivity = async () =>{
  try {
    loading.value = true;
    await router.isReady();
    const { data: { data } } = await CourseRepository.getCourseActivity(route.params.course_id);
    quizData.value = data;
  }catch (e) {
    if(e.error.status === 404) error(`وضعیت تحصیلی برای این دوره یافت نشد.`);
    else if(e.error.status === 403) error('شما به این دوره دسترسی ندارید. لطفا با پشتیبان خود تماس بگیرید.');
    else error(e.error?.message);
    await router.push({name: 'course', params: {id: route.params.course_id}})
  }finally {
    loading.value = false;
  }
};

onMounted(()=> {
  getCourseActivity();
})

</script>

<template>
  <v-row>
      <ClLoadingOverlay v-if="loading" v-model="loading" :contained="false"  />
      <v-col v-else cols="12">
        <section >
          <h4 class="font-weight-regular"  v-if="quizData">
            وضعیت تحصیلی <b>{{ user.name }}</b> در دوره <b>{{ quizData.course_name }}</b>
          </h4>
        </section>
      </v-col>
      <v-col cols="12" class="d-flex flex-grow-1">
        <v-row>
          <v-col cols="12" lg="6">
           <v-row>
             <v-col cols="12">
                <CourseActivityQuizChart v-if="quizData" :quiz="quizData" />
             </v-col>
             <v-col cols="12">
                <CourseActivityQuizzes v-if="quizData" :quiz="quizData" />
             </v-col>
           </v-row>
          </v-col>
          <v-col cols="12" lg="6">
            <CourseActivityUserAbsenceSituation />
          </v-col>
        </v-row>
      </v-col>
  </v-row>
</template>

<style scoped lang="scss">

</style>