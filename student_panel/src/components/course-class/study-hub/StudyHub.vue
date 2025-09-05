<script setup>
import { useUrl } from "@/composable/useUrl";
import StudyHubHandout from "@/components/course-class/study-hub/StudyHubHandout.vue";
import StudyHubQuiz from "@/components/course-class/study-hub/StudyHubQuiz.vue";
import StudyHubHomework from "@/components/course-class/study-hub/StudyHubHomework.vue";
import StudyHubReport from "@/components/course-class/study-hub/StudyHubReport.vue";
import StudyHubQuestionAnswer from "@/components/course-class/study-hub/StudyHubQuestionAnswer.vue";

const props = defineProps({
  data : Object,
  loading: Boolean,
})

const { defaultImageUrlBuilder } = useUrl();
</script>

<template>
      <v-card rounded class="rounded-xl pa-4"  >
          <v-card-text>
            <div class="d-flex flex-column flex-md-row  align-items-stretch " style="gap: 16px">
              <StudyHubHandout :handoutLink="data.handout_link" :loading="loading"/>
              <v-divider v-if="$vuetify.display.lgAndUp" vertical/>
              <StudyHubQuiz :quizId="data.quiz_id" :quizStatus="data.quiz_status" :quiz="data.quiz"  :loading="loading"/>
              <v-divider v-if="$vuetify.display.lgAndUp" vertical />
              <StudyHubHomework :homeWorkStatus="data.homework_status" :homeworkScore="data.homework_score" :loading="loading"/>
              <v-divider v-if="$vuetify.display.lgAndUp" vertical />
              <StudyHubReport :reportStatus="data.report_status" :loading="loading"/>
              <v-divider v-if="$vuetify.display.lgAndUp" vertical />
              <StudyHubQuestionAnswer :questionAnswerStatus="data.qa_status" :courseId="data.course_id" :loading="loading"/>
            </div>
          </v-card-text>
      </v-card>
</template>

<style scoped lang="scss">
</style>