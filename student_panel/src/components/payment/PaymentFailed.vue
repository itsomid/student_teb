<script setup>

import {useUrl} from "../../composable/useUrl";
import {computed} from "vue";
import {useRoute} from "vue-router";

const { defaultImageUrlBuilder } = useUrl();
const props = defineProps(['error']);
const route = useRoute();
const errorMessage = computed(()=> route.query.message);
const ERROR = {
  404: 'رسید پرداخت از سرور دریافت نشد برای مشاهده رسید پرداختی به صفحه امور مالی مراجعه کنید‌!',
}
</script>

<template>
  <v-card flat rounded="xl" border class="text-center d-flex flex-column justify-center align-center pa-4 py-12">
    <div class="position-relative mt-10">
      <div class="bg-error-lighten-3 circle-big rounded-circle position-relative overflow-visible">
        <div class="bg-error-lighten-1 circle-medium rounded-circle">
          <div class="bg-error circle-small rounded-circle position-relative d-flex justify-center align-center">
            <v-icon size="50">$mdiClose</v-icon>
          </div>
        </div>
      </div>
    </div>
    <v-card-text class="mt-6">
      <h2 class="font-weight-bold mt-6">خرید شما ناموفق بود!</h2>
      <p class="mt-3" v-if="error">{{  ERROR[error] || errorMessage }}</p>
    </v-card-text>
    <v-card-actions>
      <v-btn :to="{name:'finance'}" variant="elevated" flat color="info" class="px-3">
       تلاش مجدد
      </v-btn>
    </v-card-actions>
  </v-card>
</template>

<style scoped lang="scss">
.circle-big {
  width:    150px;
  height:   150px;
  padding: 25px;
  transition: all 0.5s;
  animation: 0.5s normal success-circle;
  z-index: 100!important;
}
.circle-medium {
  width:    100px;
  height:   100px;
  padding: 20px;
  transition: all 0.5s;
  animation-delay: 0.5s;
  animation: 0.5s normal success-circle;
}

.circle-small {
  width:    60px;
  height:   60px;
  transition: all 0.5s;
  animation-delay: 0.5s;
  animation: 1s normal error-circle;
}

@keyframes error-circle {
  0% {
    transform: scale(0);
  }
  100% {
    transform: scale(1);
  }
}


</style>