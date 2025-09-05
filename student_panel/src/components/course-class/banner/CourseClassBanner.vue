<script setup>
import {useDateFormatter} from "../../../composable/useDate";

const props = defineProps({
  data : Object,
  loading: Boolean,
})
import { useStore } from "vuex";
import { useUrl } from "@/composable/useUrl";
import {computed} from "vue";
import CourseClassBannerStatus from "@/components/course-class/banner/CourseClassBannerStatus.vue";
import {useThemeManager} from "@/composable/useThemeManager";

const store = useStore();

const { defaultImageUrlBuilder,imageUrlBuilder } = useUrl();

const { isDark } = useThemeManager();
const cardBackground = computed(() => isDark.value ? 'banner-bg-dark' : 'banner-bg-light'); // Calculating scrollbar theme based on current theme

const isBlockLiveClass = computed(()=> {
  try{
    let userInfo = store.getters['userStore/userData'];
    return userInfo ? +userInfo.block === 5 : false
  }catch(err) {
    return false
  }
})
</script>

<template>
  <v-row class="mb-4"  no-gutters>
    <v-col  v-if="loading" cols="12">
      <v-card rounded class="rounded-xl">
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
            <div class="d-flex flex-column flex-md-row justify-space-between pt-3 border-b border-b-lg " >
              <div class="d-flex flex-row">
                <div v-if="$vuetify.display.lgAndUp" class="prof-sec px-3 py-0">
                  <v-img rounded="xl" v-if="data.course_data && data.course_data.data && data.course_data.data.teacher_img" width="250" max-width="250"  :src="imageUrlBuilder(data.course_data.data.teacher_img, 'PROFILE')" />
                  <v-img rounded="xl" v-else width="250" max-width="250"  :src="defaultImageUrlBuilder('assets/images/default/professors/professor-default.png')" :alt="data.name" />
                </div>
                <div class="d-flex flex-column justify-space-between mx-8">
                  <h1 class="text-h6 text-lg-h5 font-weight-bold">{{ data.course_data.data.name }}</h1>
                  <div class="mb-12">
                    <v-col cols="12" class="d-flex flex-row align-center  mt-3">
                      <v-icon size="large" class="ml-3">$mdiAccountSchoolOutline</v-icon>
                      <div class="text-body-1 font-weight-bold">
                      <span class="">
                          {{data.name}}
                      </span>
                      </div>
                    </v-col>
                    <v-col  cols="12" class="d-flex flex-row  align-center  pt-0">
                      <v-icon size="large"  class="ml-3">$mdiClockOutline</v-icon>
                      <div class="text-body-1 font-weight-bold">
                          <span >
                          {{useDateFormatter(data.holding_date, "LONG")}}
                          </span>
                      </div>
                    </v-col>
                  </div>
                </div>
              </div>
              <div class="d-flex flex-column mt-6 mt-sm-0 justify-center align-center">
                <CourseClassBannerStatus
                    :data="data"
                    :loading="loading"
                    :block-detail="data.block_detail"
                    :block-live-class="isBlockLiveClass"/>
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