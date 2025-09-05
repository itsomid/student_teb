<script setup>

import {useUrl} from "@/composable/useUrl";
import {computed, ref} from "vue";
import {useNavigator} from "@/composable/useNavigator";
import {useRoute} from "vue-router";

const props = defineProps({
  homeworkScore : [String,Number],
  homeWorkStatus : [String,Number],
  handout: String,
  loading: Boolean,
  classId: [String,Number],
})

import { HOMEWORK_STATES } from "@/constants/class.const";
import StudyHubSendHomeworkUploader from "@/components/course-class/study-hub/homwork/StudyHubSendHomeworkUploader.vue";
import DashboardClassHomeworkUploader from "@/components/dashboard/class/DashboardClassHomeworkUploader.vue";

const { navigateToHomework } = useNavigator();
const { defaultImageUrlBuilder } = useUrl();

const isHomeworkSent      = computed(()=> props.homeWorkStatus === HOMEWORK_STATES.SENT);
const isHomeworkDisabled  = computed(()=> props.homeWorkStatus === HOMEWORK_STATES.DISABLED);
const isHomeworkActive    = computed(()=> props.homeWorkStatus === HOMEWORK_STATES.ACTIVE);
const isHomeworkForced    = computed(()=> props.homeWorkStatus === HOMEWORK_STATES.FORCED);
const hasHomeworkScore    = computed(()=> !!props.homeworkScore);

const isHomeworkUploaded = ref('false');
const navigator = (classId)=> {
  if (isHomeworkDisabled.value || isHomeworkSent.value){
    return false
  } else {
    navigateToHomework(classId)
  }
}
</script>

<template>
  <div class="d-flex flex-column">
    <div class="d-flex flex-row justify-space-between align-center">
      <span class="text-secondary">تکلیف</span>
      <p v-if="isHomeworkSent" class="mt-3">ارسال کرده اید</p>
      <p v-else-if="isHomeworkDisabled" class="mt-3">ندارد</p>
      <p v-else-if="isHomeworkActive || isHomeworkForced"  class="mt-3">دارد</p>
    </div>
    <div v-if="!isHomeworkDisabled && !isHomeworkSent" class="d-flex flex-row justify-space-between align-center mt-3">
      <span class="text-secondary">ارسال تکلیف</span>
    </div>
<!--    <div class="d-flex flex-row justify-space-between align-center mt-3">-->
<!--      <span class="text-secondary">جزییات تکلیف</span>-->
<!--      <v-btn :href="handout" target="_blank" border variant="tonal" color="primary" rounded="lg">-->
<!--        دانلود جزییات تکلیف-->
<!--        <v-icon class="mr-2">$mdiChevronLeft</v-icon>-->
<!--      </v-btn>-->
<!--    </div>-->
    <div class="py-4">
      <DashboardClassHomeworkUploader :isHomeworkSent="isHomeworkSent" :classId="classId" />
    </div>
  </div>
</template>

<style scoped lang="scss">

</style>