<script setup>
import StudyHubSendReportHints from "@/components/course-class/study-hub/report/StudyHubSendReportHints.vue";
import StudyHubSendReportUploader from "@/components/course-class/study-hub/report/StudyHubSendReportUploader.vue";

</script>

<template>
  <div>
    <!-- Banner for notifications -->
    <v-banner  bg-color="background" border="0" sticky>
      <template #text>
        <!-- Heading for notifications -->
        <h1 class="text-h6 font-weight-bold">ارسال گزارش</h1>
      </template>
    </v-banner>
    <v-card rounded="xl" width="100%" class="d-flex flex-column justify-center align-center mt-6">
      <v-card-text class="pa-6">
          <h2  class="text-center text-h6 font-weight-bold px-6 mt-6">
            عکس از گزارش
            خود بگیرید و عکس‌ها را در این قسمت ارسال کنید.
          </h2>
        <StudyHubSendReportHints class="mt-6"/>
        <v-divider inset class="mx-auto" />
        <v-col cols="12" md="6" class="mx-auto">
          <StudyHubSendReportUploader />
        </v-col>
      </v-card-text>
    </v-card>
  </div>
</template>

<style scoped lang="scss">

</style>