-<script setup>
import {computed, onMounted, ref} from "vue";
import RepositoryFactory from "@/repository/RepositoryFactory";
import {useRoute} from "vue-router";
import ClLoadingOverlay from "@/components/base/ClLoadingOverlay.vue";
import {useAlert} from "@/composable/useAlert";
import {useNavigator} from "@/composable/useNavigator";
import StudyHubQuizExamTimer from "@/components/course-class/study-hub/quiz/StudyHubQuizExamTimer.vue";
import {useDateFormatter} from "@/composable/useDate";
import StudyHubQuizItem from "@/components/course-class/study-hub/quiz/StudyHubQuizItem.vue";

const { success, error, info } = useAlert();

const ERROR_STATES = {
  ACCESS_DENIED   : 403,
  RESULT_RECEIVED : 409,
}

const min = ref(0);
const sec = ref(0);

const { navigateToMyCourses,navigateToQuizAnswerSheet,navigateToClass } = useNavigator();
const ClassRepository = RepositoryFactory.get("Class");
const loading = ref(true);
const quiz = ref([]);
const quizAnswersFromStudent = ref({});

const route = useRoute();
const quizId = computed(()=> route.params.quiz_id);

const onErrorNavigator = (status) => {
  if(status === ERROR_STATES.ACCESS_DENIED) navigateToMyCourses();
  else if(status === ERROR_STATES.RESULT_RECEIVED) navigateToQuizAnswerSheet(quizId.value)
}

const onSuccessNavigator = () => {
  if(quiz.value.class_id) navigateToClass(quiz.value.class_id);
  if(quiz.value.correct_quiz && quiz.value.course_id) navigateToQuizAnswerSheet(quizId.value);
  else if(quiz.value.course_id) navigateToMyCourses(quiz.value.course_id);
}
const OnErrorAnswer = (status) => {
  if(status === ERROR_STATES.RESULT_RECEIVED) {
    error("شما قبلا در این آزمون شرکت کرده اید");
    navigateToClass(quiz.value.class_id);
  }else if(status === ERROR_STATES.ACCESS_DENIED) error("شما به این دوره دسترسی ندارید. لطفا با پشتیبان خود تماس بگیرید.");
}
const onUnansweredNavigator = ()=> {
  quiz.value.class_id ? navigateToClass(quiz.value.class_id) : navigateToMyCourses(quiz.value.class_id.course_id)
}

const hasHoldingDate = computed(()=> quiz.value.holding_date_from && quiz.value.holding_date_to);
const unanswered = computed(()=> Object.keys(quizAnswersFromStudent.value).length === 0);
const getQuiz = async ()=> {
  try {
    loading.value = true;
    const { data : { data } } = await ClassRepository.getQuiz(quizId.value);
    quiz.value = data;
  }catch (e) {
    error(e.error.message);
    onErrorNavigator(e.error.status);
  }finally {
    loading.value = false;
  }
}

const setQuizItemAnswer = (answer) => {
  quizAnswersFromStudent.value[answer.question_id] = answer.answer_id;
  if(!answer.answer_id) delete quizAnswersFromStudent.value[answer.question_id];
}

const sendAnswer = async ()=> {
  loading.value = true
  if(unanswered.value) {
    onUnansweredNavigator();
    error("شما هیچ پاسخی نداده اید. مجددا در آزمون شرکت کنید");
  }else {
      try {
        await ClassRepository.sendQuizAnswer(quiz.value.quiz_id, { result: quizAnswersFromStudent.value });
        success("آزمون با موفقیت انجام شد.");
        onSuccessNavigator();
      }catch (e) {
        OnErrorAnswer(e.error.status);
      }finally {
        loading.value = false;
      }
  }
}
const expiredHandler = (type)=> {
  if(type === 'less-than-one-minutes') info("کمتر از یک دقیقه از زمان آزمون شما باقی مانده")
  else if(type === 'expired') sendAnswer();
}

onMounted(()=> {
  getQuiz();
})
</script>

<template>
  <div>
    <!-- Banner for notifications -->
    <v-banner  bg-color="background" border="0" sticky>
      <template #text>
        <!-- Heading for notifications -->
        <h1 class="text-h6 font-weight-bold">
          آزمون
          <StudyHubQuizExamTimer v-if="quiz.limit_time_seconds" :exam-limit-time="quiz.limit_time_seconds" @expired="expiredHandler"/>
        </h1>
      </template>
    </v-banner>
    <ClLoadingOverlay v-model="loading" scale="1" contained/>
    <div v-if="!loading">

      <v-card v-if="hasHoldingDate" color="info" variant="tonal" rounded="xl" width="100%" class="d-flex flex-column justify-center align-center mt-6">
        <v-card-text class="pa-6">
          آزمون از <strong>{{ useDateFormatter(quiz.holding_date_from, "LONG") }}</strong> تا
          <strong>{{ useDateFormatter(quiz.holding_date_to, "LONG") }}</strong> در دسترس میباشد.
        </v-card-text>
      </v-card>
      <div v-if="quiz.is_published" rounded="xl" width="100%">
            <v-card-text class="d-flex flex-column pa-1 pa-lg-4">
              <StudyHubQuizItem
                  v-for="(question,index) in quiz.questions"
                  :key="'quiz-question-' + index "
                  :question="question"
                  :index="index"
                  @setAnswer="setQuizItemAnswer"
              />
            </v-card-text>
        <v-divider />
            <v-card-actions class="px-4 mt-3">
              <v-btn
                  @click="sendAnswer"
                  :disabled="unanswered"
                  :loading="loading"
                  color="primary"
                  variant="elevated"
                  size="x-large"
                  rounded="xl"
                  min-width="160">
                جواب آزمون
              </v-btn>
            </v-card-actions>
      </div>
    </div>
  </div>
</template>

<style scoped lang="scss">

</style>