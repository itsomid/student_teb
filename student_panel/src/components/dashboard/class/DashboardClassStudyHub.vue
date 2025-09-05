<script setup>
import { QUIZ_STATES, HOMEWORK_STATES } from '@/constants/class.const';
import DashboardClassQuiz from '@/components/dashboard/class/DashboardClassQuiz.vue';
import DashboardClassHomework from '@/components/dashboard/class/DashboardClassHomework.vue';

const props = defineProps({
  course: Object,
  loading: Boolean
});
</script>

<template>
  <div class="d-flex flex-column">
    <div v-if="course.handout_link" class="d-flex flex-row justify-space-between align-center mt-3">
      <span class="text-secondary">جزوه</span>
      <v-btn
          v-if="course.handout_link"
          :href="course.handout_link"
          target="_blank"
          border
          variant="tonal"
          color="primary"
          rounded="lg"
      >
        دانلود جزوه
        <v-icon class="mr-2">$mdiDownloadOutline</v-icon>
      </v-btn>
    </div>
    <DashboardClassQuiz
        v-if="course.quiz_status !== QUIZ_STATES.DISABLED"
        :quizId="course.quiz_id"
        :quizStatus="course.quiz_status"
        :quiz="course.quiz"
        :loading="loading"
    />
    <v-divider v-if="course.homework_status !== HOMEWORK_STATES.DISABLED" class="my-4" />
    <DashboardClassHomework
        v-if="course.homework_status !== HOMEWORK_STATES.DISABLED"
        :homeWorkStatus="course.homework_status"
        :homeworkScore="course.homework_score"
        :handout="course.handout_link"
        :classId="course.class_id"
        :loading="loading"
    />
  </div>
</template>

<style scoped lang="scss">

</style>