<script setup>
import {computed, ref} from "vue";
import {ENTRANCE_EXAM_DATE, LAST_ENTRANCE_EXAM_DATE} from "@/constants/app.const";
import {useCountDownDate} from "@/composable/useCountDown";
const expireTimes = ref([{
  start: LAST_ENTRANCE_EXAM_DATE,
  end: ENTRANCE_EXAM_DATE
}]);

const {days, hours, minutes, seconds, progress} = useCountDownDate(expireTimes.value);

const color = computed(() => {
  if (0 < progress.value && progress.value <= 40) return 'error';
  else if (40 < progress.value && progress.value < 70) return 'warning'
  else return 'success'
})
</script>

<template>
  <div class="d-flex flex-column justify-center align-center text-right">
    <span class="text-caption font-weight-bold text-secondary">زمان باقی مانده تا کنکور ۱۴۰۴</span>
    <div id="time" class="d-flex flex-row justify-space-between text-center mt-2">
      <div class="d-flex flex-column justify-center align-center text-center">
        <span class="text-h6 timer-item d-flex flex-column justify-center align-center"
              :class="`text-${color}`">
          {{ seconds }}
        </span>
      </div>

      <span class="text-h6">:</span>

      <div class="d-flex flex-column">
        <span class="text-h6 timer-item d-flex flex-column justify-center align-center"
              :class="`text-${color}`">
          {{ minutes }}
        </span>
      </div>

      <span class="text-h6">:</span>

      <div class="d-flex flex-column">
        <span class="text-h6 timer-item d-flex flex-column justify-center align-center"
              :class="`text-${color}`">
          {{ hours }}
        </span>
      </div>

      <span class="text-h6">:</span>

      <div class="d-flex flex-column">
        <span class="text-h6 timer-item d-flex flex-column justify-center align-center"
              :class="`text-${color}`">
          {{ days }}
        </span>
      </div>

    </div>
    <div>
      <v-progress-linear
          style="width: 250px"
          height="15" rounded class="mt-6 d-flex flex-row-reverse justify-center align-center mx-auto" :model-value="progress" :color="color">
        <template #default>
     <span class="text-caption">
        {{ Math.ceil(progress) }}%
     </span>
        </template>
      </v-progress-linear>
    </div>
  </div>
</template>

<style scoped lang="scss">
.timer-item {
  display: flex;
  min-width: 40px!important;
  max-width: 40px!important;
}
</style>