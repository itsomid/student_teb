<script setup>
import {computed, onMounted, ref} from "vue";
import {useRoute} from "vue-router";
import RepositoryFactory from "@/repository/RepositoryFactory";
import {useAlert} from "@/composable/useAlert";
import ClLoadingOverlay from "@/components/base/ClLoadingOverlay.vue";
import StudyHubQuizAnswerResult from "@/components/course-class/study-hub/quiz/StudyHubQuizAnswerResult.vue";
import StudyHubQuizItem from "@/components/course-class/study-hub/quiz/StudyHubQuizItem.vue";

const { error } = useAlert();

const ClassRepository = RepositoryFactory.get("Class");
const loading = ref(true);
const answers = ref([]);
const finalResult = ref(null);

const route = useRoute();
const quizId = computed(()=> route.params.quiz_id);
const getResult = async (id)=> {
  try {
    loading.value = true;
    const { data: { data } } = await ClassRepository.getQuizAnswer(id);
    answers.value = data;
    finalResult.value = {
      score : {
        title: "درصد شما",
        value: answers.value.score,
        color: "info",
        icon: "$mdiListStatus"
      },
      correct_answers : {
        title: "تعداد جواب‌های درست",
        value: answers.value.correct_answers,
        percent: (answers.value.correct_answers /answers.value.questions.length) * 100,
        color: "success",
        icon: "$mdiCheckCircleOutline"
      },
      wrong_answers : {
        title: "تعداد جواب‌های غلط",
        value: answers.value.wrong_answers,
        percent: (answers.value.wrong_answers /answers.value.questions.length) * 100,
        color: "error",
        icon: "$mdiCloseCircleOutline"
      },
    }
  }catch (e) {
    error(e.error.message);
  }finally {
    loading.value = false;
  }
};

onMounted(() => {
  getResult(quizId.value);
})
</script>

<template>
  <div>
    <v-banner  bg-color="background" border="0" sticky>
      <template #text>
        <!-- Heading for notifications -->
        <h1 class="text-h6 font-weight-bold">
          نتایج آزمون
        </h1>
      </template>
    </v-banner>
<!--    <ClLoadingOverlay v-model="loading" scale="1" contained/>-->
    <v-row v-if="answers.score">
      <v-col cols="12">
        <StudyHubQuizAnswerResult :data="finalResult" />
      </v-col>
      <v-col cols="12">
        <StudyHubQuizItem
            v-for="(question,index) in answers.questions"
            :key="'quiz-question-' + index "
            :question="question"
            :index="index"
            :is-question="false"
        />
      </v-col>
    </v-row>
  </div>
</template>

<style scoped lang="scss">

</style>