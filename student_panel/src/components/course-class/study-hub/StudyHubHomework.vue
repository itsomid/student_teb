<script setup>

import {useUrl} from "@/composable/useUrl";
import {computed} from "vue";
import {useNavigator} from "@/composable/useNavigator";
import {useRoute} from "vue-router";
import { HOMEWORK_STATES } from "@/constants/class.const";

const props = defineProps({
  homeworkScore : [String,Number],
  homeWorkStatus : [String,Number],
  loading: Boolean,
})


const { navigateToHomework } = useNavigator();
const { defaultImageUrlBuilder } = useUrl();

const isHomeworkSent      = computed(()=> props.homeWorkStatus === HOMEWORK_STATES.SENT);
const isHomeworkDisabled  = computed(()=> props.homeWorkStatus === HOMEWORK_STATES.DISABLED);
const isHomeworkActive    = computed(()=> props.homeWorkStatus === HOMEWORK_STATES.ACTIVE);
const isHomeworkForced    = computed(()=> props.homeWorkStatus === HOMEWORK_STATES.FORCED);
const hasHomeworkScore    = computed(()=> !!props.homeworkScore);

const route = useRoute();
const classId = computed(()=> route.params.id)
const navigator = (classId)=> {
  if (isHomeworkDisabled.value || isHomeworkSent.value){
    return false
  } else {
    navigateToHomework(classId)
  }
}
</script>

<template>
  <v-hover>
    <template v-slot:default="{ isHovering,props }">
      <v-card
          :disabled="isHomeworkDisabled || isHomeworkSent"
          v-bind="props"
          :elevation="isHovering ? 8 : $vuetify.display.smAndDown ? 3 : 0"
          rounded="xl"
          class="d-flex flex-column justify-center align-center flex-grow-1"
          >
        <v-skeleton-loader v-if="loading" min-width="200" type="card" ></v-skeleton-loader>
        <v-card-text v-else class="d-flex flex-column justify-center align-center text-secondary">
          <v-icon :color="isHomeworkForced ? 'error' : ''" size="x-large" color="secondary">$mdiFileUploadOutline</v-icon>
          <p v-if="isHomeworkSent" class="mt-3">شما تکلیف خود را ارسال کرده اید</p>
          <p v-else-if="isHomeworkDisabled" class="mt-3">ارسال تکلیف برای این جلسه غیر فعال است</p>
          <p v-else-if="isHomeworkActive || isHomeworkForced"  :class="isHomeworkForced ? 'text-error' : ''" class="mt-3">ارسال تکالیف</p>
          <v-btn @click="navigator(classId)" class="my-1" variant="text" color="primary" rounded="lg">
           آپلود فایل
            <v-icon>$mdiChevronLeft</v-icon>
          </v-btn>
          <span v-if="isHomeworkForced">برای شرکت در جلسه تکالیف خود را ارسال کنید</span>
          <span v-if="!hasHomeworkScore" class="mt-2 ">(نمره داده نشده است)</span>
          <p v-if="hasHomeworkScore">
            <span>
              نمره تکلیف:
            </span>
            <b>{{ homeworkScore }} از ۱۰</b>
          </p>
        </v-card-text>
      </v-card>
    </template>
  </v-hover>
</template>

<style scoped lang="scss">

</style>