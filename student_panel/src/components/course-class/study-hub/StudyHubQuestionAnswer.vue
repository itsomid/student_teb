<script setup>

import {useUrl} from "@/composable/useUrl";
import {useNavigator} from "@/composable/useNavigator";
import {useRoute} from "vue-router";
import {computed} from "vue";

const props = defineProps({
  courseId : [String,Number],
  questionAnswerStatus : [String,Number],
  loading: Boolean,
})

const { navigateToQuestionAnswer } = useNavigator();
const { defaultImageUrlBuilder } = useUrl();

const route = useRoute();
const classId = computed(()=> route.params.id)

const navigator = (classId)=> {
  if (!props.questionAnswerStatus){
    return false
  } else {
    navigateToQuestionAnswer(props.courseId,classId)
  }
}
</script>

<template>
  <v-hover>
    <template v-slot:default="{ isHovering,props }">
      <v-card
          :disabled="!questionAnswerStatus"
          v-bind="props"
          :elevation="isHovering ? 8 : $vuetify.display.smAndDown ? 3 : 0"
          rounded="xl"
          class="d-flex flex-column justify-center align-center flex-grow-1">
        <v-skeleton-loader v-if="loading" min-width="200" type="card" ></v-skeleton-loader>
        <v-card-text v-else class="d-flex flex-column justify-center align-center text-secondary">
          <v-icon size="x-large" color="secondary">$mdiForumOutline</v-icon>
          <p class="mt-3">رفع اشکال</p>
          <v-btn @click="navigator(classId)" rounded="lg" class="mt-1" variant="text" color="primary">
            پرسش و پاسخ
            <v-icon>$mdiChevronLeft</v-icon>
          </v-btn>
        </v-card-text>
      </v-card>
    </template>
  </v-hover>
</template>

<style scoped lang="scss">

</style>