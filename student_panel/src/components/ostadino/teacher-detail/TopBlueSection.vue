<script setup>
const props = defineProps({
  profDetail: {
    type: Object,
    default: null
  },
  profName:{
    type: String,
    required: true
  },
  lessons:{
    type: Array,
    required: true
  }
})
</script>

<template>
  <div class="w-100 d-flex align-center justify-center" style="background-color: #036AF5; overflow-x: hidden;">
    <v-row no-gutters class="w-100" :class="$vuetify.display.mobile ? 'py-10' : 'pa-10'">
      <v-col cols="12" class="d-flex flex-column align-center text-white mt-10">
        <h4 class="font-weight-bold text-h5">
          {{ profName }}
        </h4>
        <h5 class="font-weight-light mt-2 text-h6" v-for="(lesson, index) in lessons" :key="'lesson_index'+index">
         دبیر: {{ lesson }}
        </h5>
      </v-col>
      <v-col cols="12" class="d-flex justify-center text-white align-center pa-0 flex-wrap"
             :class="[$vuetify.display.mobile ? 'mt-8 mb-4' : '']">
        <v-col cols="5" md="2" class="d-flex flex-column align-center justify-center">
          <div>امتیاز دانش آموز</div>
          <h3 v-if="profDetail.student_rate"  class="text-h4 mt-6 ">{{ profDetail.student_rate.toFixed(2) }}</h3>
        </v-col>
        <div class="border"></div>

        <v-col cols="5" md="2" class="d-flex flex-column align-center justify-center" v-if="profDetail.expert_score">
          <div>امتیاز کارشناس</div>
          <h3 class="text-h4 mt-6">
            {{profDetail.expert_score}}
          </h3>
        </v-col>
        <div class="border" v-if="!$vuetify.display.mobile"></div>

        <v-col cols="5" md="2" class="d-flex flex-column align-center justify-center">
          <div>تعداد نظرات</div>
          <h3 v-if="profDetail.total_count_rate"  class="text-h4 mt-6">{{profDetail.total_count_rate}}</h3>
        </v-col>
        <div class="border"></div>

        <v-col cols="5" md="2" class="d-flex flex-column align-center justify-center">
          <div>امتیاز کل</div>
          <h3 v-if="profDetail.total_rate"  class="text-h4 mt-6">{{ profDetail.total_rate }}</h3>
        </v-col>
      </v-col>
    </v-row>
  </div>

</template>

<style scoped lang="scss">
.border {
  height: 48px;
  background: #FFFFFF;
  width: 1px;
  opacity: 0.8;
}
</style>
