<script setup>
import {ENTRANCE_EXAM_DATE, LAST_ENTRANCE_EXAM_DATE} from "@/constants/app.const";
  import { useCountDownDate } from "@/composable/useCountDown";
import {computed, ref} from "vue";
  const expireTimes = ref( [{
    start: LAST_ENTRANCE_EXAM_DATE,
    end: ENTRANCE_EXAM_DATE
  }]);

  const { days,hours,minutes,seconds, progress } = useCountDownDate(expireTimes.value);

  const color = computed(()=>{
    if(0 < progress.value && progress.value <= 40) return 'success';
    else if(40 < progress.value && progress.value < 90) return 'warning'
    else return 'error'
  })

</script>

<template>
  <v-hover>
    <template v-slot:default="{ isHovering,props }">
      <v-card v-bind="props" :elevation="isHovering ? 8 : 1" rounded class="rounded-xl pa-3 d-flex flex-column justify-center align-center" height="100%">
      <div>
        <v-card-title class="text-center py-6">
          زمان باقی مانده تا کنکور ۱۴۰۴
        </v-card-title>
        <v-card-text class="text-center mt-3 font-weight-bold">
          <div id="time" class="d-flex flex-row justify-space-between text-center">
            <div class="d-flex flex-column justify-center align-center text-center">
           <span class="text-h4 timer-item d-flex flex-column justify-center align-center" :class="`text-${color}`">
            {{ seconds }}
          </span>
              <span class="text-caption font-weight-bold">ثانیه</span>
            </div>

            <span class="text-h5">:</span>
            <div class="d-flex flex-column">
             <span class="text-h4 timer-item d-flex flex-column justify-center align-center" :class="`text-${color}`">
            {{ minutes }}
          </span>
              <span class="text-caption font-weight-bold">دقیقه</span>
            </div>

            <span class="text-h5">:</span>
            <div class="d-flex flex-column">
          <span class="text-h4 timer-item d-flex flex-column justify-center align-center" :class="`text-${color}`">
            {{ hours }}
          </span>
              <span class="text-caption font-weight-bold">ساعت</span>
            </div>

            <span class="text-h5">:</span>
            <div class="d-flex flex-column">
             <span class="text-h4 timer-item d-flex flex-column justify-center align-center" :class="`text-${color}`">
            {{ days }}
          </span>
              <span class="text-caption font-weight-bold">روز</span>
            </div>

          </div>
        </v-card-text>
        <v-card-text class="text-center">
          <v-chip rounded="xl" variant="elevated" :color="color">
            % {{  Math.ceil(progress) }}
          </v-chip>
          <span class="mr-1 font-weight-bold text-body-2">
         از زمان شما باقی مانده
      </span>

          <v-progress-linear
              height="25" rounded class="mt-6 d-flex flex-row-reverse" :model-value="progress" :color="color">
            <span>{{ Math.ceil(progress) }}%</span>
          </v-progress-linear>
        </v-card-text>
      </div>
    </v-card>
    </template>
  </v-hover>

</template>

<style scoped lang="scss">
  .timer-item {
    display: flex;
    min-width: 40px!important;
    max-width: 40px!important;
  }
</style>