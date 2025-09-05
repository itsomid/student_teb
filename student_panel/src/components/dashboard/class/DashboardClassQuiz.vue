<script setup>
import {useUrl} from "@/composable/useUrl";
import {computed} from "vue";
import { useDateFormatter } from "@/composable/useDate";
import {useNavigator} from "@/composable/useNavigator";

const props = defineProps({
  quizId : [String,Number],
  quizStatus : [String,Number],
  quiz : [Object],
  loading: Boolean,
})

import { QUIZ_STATES } from "@/constants/class.const";

const { navigateToQuiz, navigateToQuizAnswerSheet } = useNavigator();
const { defaultImageUrlBuilder } = useUrl();

const isQuizDisable       = computed(()=> props.quizStatus === QUIZ_STATES.DISABLED || props.quizStatus === QUIZ_STATES.RESULT_PENDING);
const isQuizForced        = computed(()=> props.quizStatus === QUIZ_STATES.FORCED);
const isQuizAnswered      = computed(()=> props.quizStatus === QUIZ_STATES.RESULT_PENDING || props.quizStatus === QUIZ_STATES.RESULT_RECEIVED);
const isQuizPending       = computed(()=> props.quizStatus === QUIZ_STATES.DISABLED && props.quiz.holding_date_from);
const isReadyToStartQuiz  = computed(()=> props.quizStatus === QUIZ_STATES.ACTIVE || props.quizStatus === QUIZ_STATES.DISABLED || props.quizStatus === QUIZ_STATES.FORCED )

const navigator = (status)=> {
  if (status === QUIZ_STATES.ACTIVE || status === QUIZ_STATES.FORCED){
    navigateToQuiz(props.quizId);
  }
  if (status === QUIZ_STATES.RESULT_RECEIVED){
    navigateToQuizAnswerSheet(props.quizId)
  }
  else {
    return false
  }
}
</script>

<template>
  <div class="d-flex flex-column">
    <div class="d-flex flex-row justify-space-between align-center mt-3">
      <span class="text-secondary">آزمون‌کلاسی</span>
      <v-btn @click="navigator(quizStatus)" border variant="tonal" color="primary" rounded="lg">
        <span v-if="isReadyToStartQuiz">شرکت در آزمون</span>
        <span v-if="isQuizPending" class="text-secondary mx-1" >(از {{useDateFormatter(quiz.holding_date_from, "HOUR_DATE")}} تا {{useDateFormatter(quiz.holding_date_to, "HOUR_DATE")}})</span>
        <span v-if="isQuizAnswered">نمایش پاسخنامه</span>
        <v-icon class="mr-2">$mdiChevronLeft</v-icon>
      </v-btn>
    </div>
    <span v-if="isQuizForced" class="text-caption text-error text-start mt-2">
               برای نمایش کلاس شرکت در آزمون اجباری است.
      </span>
  </div>
</template>

<style scoped lang="scss">

</style>