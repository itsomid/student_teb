<script setup>

import {useUrl} from "@/composable/useUrl";
import {computed} from "vue";
import {useNavigator} from "@/composable/useNavigator";
import {useRoute} from "vue-router";

const props = defineProps({
  reportStatus : [String,Number],
  loading: Boolean,
})

const REPORT_STATES = {
  ACTIVE          : 401,
  FORCED          : 402,
  DISABLED        : 403,
}

const { navigateToReport } = useNavigator();
const { defaultImageUrlBuilder } = useUrl();

const isReportDisabled  = computed(()=> props.reportStatus === REPORT_STATES.DISABLED);
const isReportActive    = computed(()=> props.reportStatus === REPORT_STATES.ACTIVE);
const isReportForced    = computed(()=> props.reportStatus === REPORT_STATES.FORCED);

const route = useRoute();
const classId = computed(()=> route.params.id)
const navigator = (classId)=> {
  if (isReportDisabled.value){
    return false
  } else {
    navigateToReport(classId)
  }
}
</script>

<template>
  <v-hover>
    <template v-slot:default="{ isHovering,props }">
      <v-card
          :disabled="isReportDisabled"
          v-bind="props"
          :elevation="isHovering ? 8 : $vuetify.display.smAndDown ? 3 : 0"
          rounded="xl"
          class="d-flex flex-column justify-center align-center flex-grow-1"
          >
        <v-skeleton-loader v-if="loading" min-width="200" type="card" ></v-skeleton-loader>
        <v-card-text v-else class="d-flex flex-column justify-center align-center text-secondary">
          <v-icon :color="isReportForced ? 'error' : ''" size="x-large" color="secondary">$mdiTextBoxCheckOutline</v-icon>
          <p v-if="isReportActive || isReportForced" :class="isReportForced ? 'text-error' : ''"  class="mt-3">ارسال کارنامه</p>
          <p v-else-if="isReportDisabled" class="mt-3">شما گزارش کارنامه خود را ارسال کرده اید</p>
          <v-btn @click="navigator(classId)" rounded="lg" class="mt-1" variant="text" color="primary">
            آپلود فایل
            <v-icon>$mdiChevronLeft</v-icon>
          </v-btn>
          <div v-if="isReportForced" class="mt-3">
            برای <b>نمایش جلسه</b> ارسال کارنامه <b>اجباری</b> است
          </div>
        </v-card-text>
      </v-card>
    </template>
  </v-hover>
</template>

<style scoped lang="scss">

</style>