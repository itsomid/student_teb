<script setup>

import {useUrl} from "../../composable/useUrl";

const { defaultImageUrlBuilder } = useUrl();
import { Vue3Lottie } from 'vue3-lottie'
import checkMark from '../../assets/images/icons/checkmark2.json'
</script>

<template>
  <v-card flat rounded="xl" border class="text-center d-flex flex-column justify-center align-center pa-4 py-12">
    <div class="position-relative mt-10">
      <div class="bg-success-lighten-3 circle-big rounded-circle position-relative overflow-visible">
        <div class="bg-success-lighten-1 circle-medium rounded-circle">
          <div class="bg-success circle-small rounded-circle position-relative">
            <Vue3Lottie style="transform: translate(17.5px,-17.5px)" :loop="false" :animationData="checkMark" :height="95" :width="95" />
          </div>
        </div>
      </div>
      <div class="d-flex flex-column justify-center align-center" style="height: 150px;width: 150px;position: absolute;transform: translatey(-150px)">
        <v-img min-width="25" class="star star-one" :src="defaultImageUrlBuilder('assets/images/payment/2.svg')" />
        <v-img min-width="40" class="star star-two" :src="defaultImageUrlBuilder('assets/images/payment/3.svg')" />
        <v-img min-width="30" class="star star-three" :src="defaultImageUrlBuilder('assets/images/payment/4.svg')" />
        <v-img min-width="15" class="star star-four" :src="defaultImageUrlBuilder('assets/images/payment/5.svg')" />
        <v-img min-width="25" class="star star-five" :src="defaultImageUrlBuilder('assets/images/payment/6.svg')" />
      </div>
    </div>
    <v-card-text class="mt-6">
      <h2 class="font-weight-bold mt-6">خرید شما انجام شد</h2>
      <p class="mt-3">از الان در صفحه دوره‌های من به تمامی محتوای این دوره‌ها دسترسی داری.</p>
    </v-card-text>
    <v-card-actions>
      <v-btn :to="{name: 'my-courses'}" variant="tonal" color="info" class="px-3">
        مشاهده در لیست دروس من
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
    animation: 1s normal success-circle;
  }

  @keyframes success-circle {
    0% {
      transform: scale(0);
    }
    100% {
      transform: scale(1);
    }
  }

  .star {
    position: absolute;
    transition: all 0.5s;
    z-index: 1!important;
  }

  .star-one {
    animation-delay: 1s;
    animation: 0.8s normal star-1;
    transform: translate(70px,70px);
  }
  @keyframes star-1 {
    0% {
      transform: translate(0px,0px);
    }
    100% {
      transform: translate(70px,70px);
    }
  }

  .star-two {
    animation-delay: 1s;
    animation: 0.3s normal star-2;
    transform: translate(-70px,80px) scale(0.8);
  }
  @keyframes star-2 {
    0% {
      transform: translate(0,0);
    }
    100% {
      transform: translate(-70px,80px) scale(0.8);
    }
  }

  .star-three {
    animation-delay: 2.5s;
    animation: 1.5s normal star-3;
    transform: translate(-100px,-70px);
  }
  @keyframes star-3 {
    0% {
      transform: translate(0,0);
    }
    100% {
      transform: translate(-100px,-70px);
    }
  }

  .star-four {
    animation-delay: 2s;
    animation: 0.6s normal star-4;
    transform: translate(70px,-80px);
  }
  @keyframes star-4 {
    0% {
      transform: translate(0,0);
    }
    100% {
      transform: translate(70px,-80px);
    }
  }

  .star-five {
    animation-delay: 1.5s;
    animation: 1s normal star-5;
    transform: translate(100px,0px);
    z-index: 1!important;
  }
  @keyframes star-5 {
    0% {
      transform: translate(0,0);
    }
    100% {
      transform: translate(100px,0px);
    }
  }
</style>