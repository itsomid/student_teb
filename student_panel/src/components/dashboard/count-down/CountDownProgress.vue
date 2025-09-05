<script setup>
import {useCountDownDate} from "@/composable/useCountDown";
import {computed, ref} from "vue";
import {ENTRANCE_EXAM_DATE, LAST_ENTRANCE_EXAM_DATE} from "@/constants/app.const";
const expireTimes = ref([{
  start: LAST_ENTRANCE_EXAM_DATE,
  end: ENTRANCE_EXAM_DATE
}]);
const {progress} = useCountDownDate(expireTimes.value);
const color = computed(() => {
  if (0 < progress.value && progress.value <= 40) return 'success';
  else if (40 < progress.value && progress.value < 90) return 'warning'
  else return 'error'
})
</script>

<template>
  <div class="d-flex flex-column justify-center ">
    <div>
      <v-chip rounded="xl" size="small"  :color="color">
        % {{  Math.ceil(progress) }}
      </v-chip>
    </div>
    <v-progress-linear
        height="15" rounded class="mt-6 d-flex flex-row-reverse" :model-value="progress" :color="color">
    </v-progress-linear>
  </div>
</template>

<style scoped lang="scss">

</style>