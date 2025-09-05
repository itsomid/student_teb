<script setup>
import {useUrl} from "@/composable/useUrl";
import {computed} from "vue";
import { useDateFormatter } from "@/composable/useDate";
import {useNavigator} from "@/composable/useNavigator";
import {useThemeManager} from "@/composable/useThemeManager";

const props = defineProps({
  quizId : [String,Number],
  quizStatus : [String,Number],
  quiz : [Object],
  loading: Boolean,
})

const QUIZ_STATES = {
  DISABLED        : 201,
  ACTIVE          : 202,
  FORCED          : 203,
  RESULT_PENDING  : 204,
  RESULT_RECEIVED : 205,
}

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
const { isDark } = useThemeManager();
</script>

<template>
  <v-hover>
    <template v-slot:default="{ isHovering,props }">
      <v-card
          :disabled="isQuizDisable"
          v-bind="props"
          :elevation="isHovering ? 8 : $vuetify.display.smAndDown ? 3 : 0"
          rounded="xl"
          class="d-flex flex-column justify-center align-center flex-grow-1"
          >
        <v-skeleton-loader v-if="loading" min-width="200" type="card" ></v-skeleton-loader>
        <v-card-text v-else class="d-flex flex-column justify-center align-center text-secondary mb-1">
          <v-icon :color="isQuizForced ? 'error' : ''" size="x-large" color="secondary">$mdiListBoxOutline</v-icon>
          <p :class="isQuizForced ? 'text-error' : ''" class="mt-3">آزمون کلاسی</p>
          <v-btn @click="navigator(quizStatus)" class="mt-1" variant="text" color="primary" rounded="lg">
            <span v-if="isReadyToStartQuiz">شرکت در آزمون</span>
            <span v-if="isQuizPending" :class="isDark ? 'text-secondary-lighten-5' : 'text-secondary-darken-5'" class="mx-1" >(از {{useDateFormatter(quiz.holding_date_from, "HOUR_DATE")}} تا {{useDateFormatter(quiz.holding_date_to, "HOUR_DATE")}})</span>
            <span v-if="isQuizAnswered">نمایش پاسخنامه</span>
            <span v-if="isQuizForced">
               برای <b>نمایش جلسه</b> آزمون کلاسی <b>اجباری</b> است
            </span>
            <v-icon>$mdiChevronLeft</v-icon>
          </v-btn>
<!--          <span>نمره شما ۱۵ است</span>-->
        </v-card-text>
      </v-card>
    </template>
  </v-hover>
</template>

<style scoped lang="scss">

</style>