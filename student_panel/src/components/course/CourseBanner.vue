<script setup>
  import ClImage from "@/components/base/ClImage.vue";

  const props = defineProps({
    data : Object,
    loading: Boolean,
  })

  import { useUrl } from "@/composable/useUrl";
  import {computed} from "vue";
  import {useThemeManager} from "@/composable/useThemeManager";
  const { defaultImageUrlBuilder,imageUrlBuilder } = useUrl();
  const  daysOfWeek = {
    0: '',
    1: 'شنبه',
    2: 'یک‌شنبه',
    3: 'دوشنبه',
    4: 'سه‌شنبه',
    5: 'چهارشنبه',
    6: 'پنج‌شنبه',
    7: 'جمعه',
  }

  const { isDark } = useThemeManager();
  const cardBackground = computed(() => isDark.value ? 'banner-bg-dark' : 'banner-bg-light'); // Calculating scrollbar theme based on current theme

</script>

<template>
  <v-row class="mb-4"  no-gutters>
    <v-col  v-if="loading" cols="12" class="banner-bg">
      <v-card  rounded class="rounded-xl" variant="elevated">
        <v-card-text class="pa-0 px-4 pt-4">
          <v-row>
            <v-col cols="12" sm="4" lg="3" xl="3">
              <v-img aspect-ratio="1" width="100%"  :src="defaultImageUrlBuilder('assets/images/default/professors/professor-default.png')"/>
            </v-col>
            <v-col cols="12" sm="8" lg="9" xl="9" >
              <v-skeleton-loader type="card" width="100%" height="100%" />
            </v-col>
          </v-row>
        </v-card-text>
      </v-card>
    </v-col>
    <v-col v-else-if="data.name" cols="12">
      <v-hover>
        <template v-slot:default="{ isHovering,props }">
          <v-card rounded class="rounded-xl px-8 pt-8" :class="cardBackground" v-bind="props" :elevation="isHovering ? 8 : 0" >
          <div class="d-flex flex-row pt-3 border-b border-b-lg " >
            <div v-if="$vuetify.display.lgAndUp" class="prof-sec px-3 py-0">
              <v-img v-if="data.teacher_img" width="250" max-width="250"             class="rounded-xl"  :src="imageUrlBuilder(data.teacher_img, 'PROFILE')" />
              <v-img v-else width="250" max-width="250"   :src="defaultImageUrlBuilder('assets/images/default/professors/professor-default.png')" :alt="data.name" />
            </div>
            <div class="d-flex align-center justify-center pa-4">
              <div class="py-6 d-flex flex-column flex-sm-row justify-space-between">
                <div class="mx-8">
                  <v-row>
                    <h1 class="text-h6 text-lg-h5 font-weight-bold">{{ data.name }}</h1>
                    <v-col cols="12" class="d-flex flex-row align-center  mt-3">
                        <i class="icon-CL_calendar text-h6 ml-3"></i>
                      <div class="text-body-1 text-lg-h6 =">
                      <span class="">
                          {{ daysOfWeek[data.holding_days] }}
                          <span v-if="+data.options.holding_days2">{{' - '+daysOfWeek[data.options.holding_days2] }}</span>
                          <span v-if="+data.options.holding_days3">{{' - '+daysOfWeek[data.options.holding_days3]}}</span>
                      </span>
                      </div>
                    </v-col>
                    <v-col  cols="12" class="d-flex flex-row  align-center  pt-0">
                        <i class="icon-CL_clock text-h6 ml-3"></i>
                      <div class="text-body-1 text-lg-h6">
                      <span >
                        {{ data.holding_hours[0] }} تا {{ data.holding_hours[1] }}
                        <span v-if="+data.options.holding_days2">- {{data.options.holding_hours2[0]}} تا {{data.options.holding_hours2[1]}}</span>
                        <span v-if="+data.options.holding_days3"> - {{data.options.holding_hours3[0]}} تا {{data.options.holding_hours3[1]}}</span>
                      </span>
                      </div>
                    </v-col>
                  </v-row>
                </div>
                <div class="d-flex flex-column mt-6 mt-sm-0 justify-center align-center" style="gap:24px">
                  <v-btn width="225" color="black" size="x-large" rounded>
                    نمایش آزمون ها
                  </v-btn>
                  <v-btn width="225" color="primary" size="x-large" rounded  :to="{name:'course.activity', params:{course_id: data.course_id}}">
                    نمایش وضعیت تحصیلی
                  </v-btn>
                </div>
              </div >
            </div>
          </div>
      </v-card>
        </template>
      </v-hover>
    </v-col>
  </v-row>
</template>

<style scoped lang="scss">

</style>