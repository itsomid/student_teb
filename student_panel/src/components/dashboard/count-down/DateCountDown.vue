<script setup>
import {ENTRANCE_EXAM_DATE, LAST_ENTRANCE_EXAM_DATE} from "@/constants/app.const";
import {useCountDownDate} from "@/composable/useCountDown";
import {useDateFormatter} from "@/composable/useDate";

const date = new Date().toUTCString();

import CurrentDateSimple from "@/components/dashboard/CurrentDate/CurrentDateSimple.vue";
import CountDownProgress from "@/components/dashboard/count-down/CountDownProgress.vue";
import CountDownSimple from "@/components/dashboard/count-down/CountDownSimple.vue";

</script>

<template>
  <v-hover>
    <template v-slot:default="{ isHovering,props }">
      <v-card
          v-bind="props"
          :elevation="isHovering ? 8 : 1"
          rounded
          class="rounded-xl pa-3 pa-4"
          height="100%">
        <div class="d-flex  flex-column flex-lg-row flex-wrap align-center justify-center">
          <CurrentDateSimple />
          <v-divider v-if="$vuetify.display.lgAndUp" class="my-6" vertical=""/>
          <div class="d-flex flex-column pa-4 px-lg-8" style="flex-grow: 1!important;">
            <div class="d-flex flex-column flex-lg-row justify-center align-center">
              <CountDownSimple />
<!--              <CountDownProgress />-->
            </div>
            <v-divider class="my-6" />
            <div class="d-flex flex-column flex-lg-row justify-center align-center">
              <CountDownSimple />
<!--              <CountDownProgress />-->
            </div>
          </div>
        </div>
      </v-card>
    </template>
  </v-hover>
</template>

<style scoped lang="scss">
</style>