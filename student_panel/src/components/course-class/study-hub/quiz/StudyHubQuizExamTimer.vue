<script setup>
import {useCountDownDate} from "@/composable/useCountDown";
import {ref, watch} from "vue";
const emits = defineEmits(['expired'])
const props = defineProps({
  examLimitTime : {
    default: 3600 //seconds
  }
})
const expireTimes = ref( [{
  start: new Date(Date.now()),
  end: new Date(Date.now() + props.examLimitTime*1000)
}]);

const { minutes,seconds, distance } = useCountDownDate(expireTimes.value);

watch(distance, (value)=> {
  if(value < 0 ){
    emits('expired', 'expired')
  }
  else if(value < 60001 && value > 59000) emits('expired', 'less-than-one-minutes')
})
</script>

<template>
  <span class="text-caption font-weight-bold text-secondary mr-6">زمان باقی مانده:</span>
  <span class="mx-3 text-caption font-weight-bold text-secondary">
           <strong class="text-primary"> {{ minutes }} </strong>
            دقیقه
           <strong class="text-primary"> {{ seconds }} </strong>
            ثانیه
          </span>
</template>

<style scoped lang="scss">

</style>