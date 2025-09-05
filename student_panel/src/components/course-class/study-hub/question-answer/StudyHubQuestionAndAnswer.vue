<script setup>
import ClLoading from "@/components/base/ClLoading.vue";
import {useAlert} from "@/composable/useAlert";
import {useRoute, useRouter} from "vue-router";
import {onMounted, ref} from "vue";
import RepositoryFactory from "@/repository/RepositoryFactory";
import {useStore} from "vuex";
import StudyHubQuestionAnswerChangeClass
  from "@/components/course-class/study-hub/question-answer/StudyHubQuestionAnswerChangeClass.vue";
import StudyHubAskQuestion from "@/components/course-class/study-hub/question-answer/StudyHubAskQuestion.vue";
import StudyHubQuestionAndAnswerConversation
  from "@/components/course-class/study-hub/question-answer/StudyHubQuestionAndAnswerConversation.vue";
const { error } = useAlert();

const store = useStore();
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
 * Ref for storing the current course questions and answers.
 * @type {import('vue').Ref<Object>}
 */
const questionAndAnswer = ref({});
const totalQuestions = ref(0);

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
 * Function to fetch user course question and answers class from the repository.
 * @async
 * @function
 * @returns {Promise<void>}
 */
const getQuestionAndAnswerCourseClass = async () =>{
  try {
    loading.value = true;
    await router.isReady();
    const { data: { data } } = await ClassRepository.getQuestionAnswer(route.params.class_id);
    questionAndAnswer.value = data;
    questionAndAnswer.value ? totalQuestions.value = questionAndAnswer.value.length : 0;
    store.dispatch('navbar/updateTitle',`پرسش و پاسخ با استاد ${questionAndAnswer.value.teacher_name}` )
  }catch (e) {
    error(e.error?.message);
  }finally {
    loading.value = false;
  }
};

const updateConversation = (conversation) => {
  console.log(conversation, 'conversation')
  questionAndAnswer.value.qa.push(conversation);
  totalQuestions.value++;
}

/**
 * Lifecycle hook that runs after the component has been mounted.
 * Fetches user courses.
 */
onMounted(()=>{
  getQuestionAndAnswerCourseClass();
})


</script>

<template>
  <div>
    <cl-loading v-if="loading" />
    <div v-else class="mt-6">
      <p class="">
        درمورد {{ questionAndAnswer.class_name }}
        - {{ questionAndAnswer.course_name }}
      </p>
      <v-row class="mt-6">
        <v-col cols="12" xl="3" lg="4" md="6">
          <StudyHubQuestionAnswerChangeClass />
        </v-col>
        <v-col cols="12" xl="9" lg="8" md="6">
          <v-row>
            <v-col cols="12">
              <StudyHubQuestionAndAnswerConversation
                  v-if="questionAndAnswer"
                  :conversation="questionAndAnswer"
                  :total-count="totalQuestions"
              />
            </v-col>
            <v-col cols="12">
              <StudyHubAskQuestion
                  :teacher="questionAndAnswer.teacher_name"
                  :className="questionAndAnswer.class_name"
                  @update-questions="updateConversation"
              />
            </v-col>
          </v-row>
        </v-col>
      </v-row>
    </div>
  </div>
</template>

<style scoped lang="scss">

</style>