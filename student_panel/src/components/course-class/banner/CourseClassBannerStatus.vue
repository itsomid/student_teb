<script setup>
import {defineAsyncComponent, ref} from "vue";
import { CLASS_STATUS } from "@/constants/class.const";

import ClError from "@/components/app/ClError.vue";

const props = defineProps({
  data : Object,
  loading: Boolean,
  blockDetail: Object,
  blockLiveClass: Boolean,
})

const CourseClassBannerStatusSuspended = defineAsyncComponent({
  loader: () => import("./CourseClassBannerStatusSuspended.vue"),
  delay: 0,
  errorComponent: ClError,
  timeout: 3000,
});

const CourseClassBannerStatusForceMessage = defineAsyncComponent({
  loader: () => import("./CourseClassBannerStatusForceMessage.vue"),
  delay: 0,
  errorComponent: ClError,
  timeout: 3000,
});

const CourseClassBannerStatusOngoing = defineAsyncComponent({
  loader: () => import("./CourseClassBannerStatusOngoing.vue"),
  delay: 0,
  errorComponent: ClError,
  timeout: 3000,
});

const CourseClassBannerStatusPending = defineAsyncComponent({
  loader: () => import("./CourseClassBannerStatusPending.vue"),
  delay: 0,
  errorComponent: ClError,
  timeout: 3000,
});

const CourseClassBannerStatusDelayed = defineAsyncComponent({
  loader: () => import("./CourseClassBannerStatusDelayed.vue"),
  delay: 0,
  errorComponent: ClError,
  timeout: 3000,
});

const CourseClassBannerStatusConducted = defineAsyncComponent({
  loader: () => import("./CourseClassBannerStatusConducted.vue"),
  delay: 0,
  errorComponent: ClError,
  timeout: 3000,
});

const CourseClassStatusBannerBlocked = defineAsyncComponent({
  loader: () => import("./CourseClassStatusBannerBlocked.vue"),
  delay: 0,
  errorComponent: ClError,
  timeout: 3000,
});

const blockReason     = ref("");

const color = (banner_class_status) => {
  if(CLASS_STATUS.CONDUCTED.includes(banner_class_status) || CLASS_STATUS.PENDING.includes(banner_class_status)) return 'warning';
  else if(CLASS_STATUS.ONGOING.includes(banner_class_status)) return "success"
  else if(CLASS_STATUS.FORCE_MESSAGE.includes(banner_class_status) || CLASS_STATUS.SUSPENDED.includes(banner_class_status)) return "error"
  else if(CLASS_STATUS.DELAYED.includes(banner_class_status)) return "info"
}


</script>

<template>
  <v-skeleton-loader class="mb-6 rounded-xl" min-width="250" v-if="loading" type="card"></v-skeleton-loader>
  <v-card  variant="flat"  v-else  rounded="xl" width="492" class="mb-6">
    <v-card-title  v-if="!blockDetail && !CLASS_STATUS.DELAYED.includes(data.banner_class_status)"
                   class="d-flex flex-column justify-center align-content-end text-body-2 font-weight-bold text-center my-3">
       <span
           class="ml-0 ml-md-3 mb-2 mb-md-0">
         <v-btn size="small" variant="outlined" icon :color="color(data.banner_class_status)">
           <i class="icon-CL_exclamation text-h5"></i>
         </v-btn>
       </span>
    </v-card-title>
    <v-card-text class="text-center font-weight-bold text-body-2">
      <!--  Class Status Banner Messages     -->
      <CourseClassBannerStatusSuspended v-if="CLASS_STATUS.SUSPENDED.includes(data.banner_class_status)" :block-detail="blockDetail" />

      <CourseClassBannerStatusForceMessage v-if="CLASS_STATUS.FORCE_MESSAGE.includes(data.banner_class_status)" :status="data.banner_class_status" />

      <CourseClassBannerStatusOngoing
          v-if="CLASS_STATUS.ONGOING.includes(data.banner_class_status) && !blockLiveClass"
          :loading="loading"
          :class_id="data.class_id"
          :status="data.banner_class_status"
          :live_stream_link="data.cc_url"
      />

      <CourseClassBannerStatusPending v-if="CLASS_STATUS.PENDING.includes(data.banner_class_status)"/>

      <CourseClassBannerStatusDelayed v-if="CLASS_STATUS.DELAYED.includes(data.banner_class_status)"/>

      <CourseClassBannerStatusConducted
          v-if="CLASS_STATUS.CONDUCTED.includes(data.banner_class_status)"
          :record_video_hls_path="data.record_video_hls_path"
          :record_video_HD_hls_path="data.record_video_HD_hls_path"
          :record_video_kavimo="data.record_video_kavimo"
          :record_video_kavimo_HD="data.record_video_kavimo_HD"
          :class_id="data.class_id"
      />

      <CourseClassStatusBannerBlocked v-if="blockLiveClass"/>

    </v-card-text>
  </v-card>
</template>

<style scoped lang="scss">

</style>