<script setup>
import {onBeforeMount, onMounted, ref} from "vue";
import VueApexCharts from "vue3-apexcharts";
const props = defineProps(['quiz'])
const chartOptions = ref( {
  chart: {
    id: 'ScoreChart',
    type: 'area',
    toolbar: {
      show: false // Set this to false to hide the toolbar
    },
  },
  stroke: {
    curve: 'smooth'
  },
  xaxis: {
    categories: []
  },
  colors:['#FFAF20'],
})

const series = ref([{
  name: 'نمره',
  data: []
}]);

onMounted(()=>{
  let x=[];
  let y=[];
  if(props.quiz.chart)
  props.quiz.chart.forEach((element)=> {
    let score = element.score === null ? 0 : element.score
    x.push(element.name.substring(0,9))
    y.push(score)
  });

  chartOptions.value.xaxis.categories = x;
  series.value[0].data = y;

})
</script>

<template>
  <v-card flat border rounded="xl">
    <v-card-title>
      نمودار نمرات آزمون کلاسی
    </v-card-title>
    <v-card-text>
      <VueApexCharts class="w-100" type="area" :options="chartOptions" :series="series" ></VueApexCharts>
    </v-card-text>
  </v-card>
</template>

<style scoped lang="scss">

</style>