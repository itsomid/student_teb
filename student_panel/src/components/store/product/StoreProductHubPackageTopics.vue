<script setup>

import { useDisplay } from 'vuetify'
import {useUrl} from "@/composable/useUrl";
import {useStore} from "vuex";

const props = defineProps(['package', 'productStatus'])

const { smAndDown } = useDisplay()

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

const { imageUrlBuilder,defaultImageUrlBuilder } = useUrl();

const store = useStore();

const selectProfessor = (professor)=> {
  store.dispatch("shop/updateProfessor", professor);
}

</script>

<template>
  <div>

    <div v-if="package">
      <v-expansion-panels rounded="xl" >
        <v-expansion-panel
            v-for="item in package.data.sections"
            :key="'course-' + item.id"
        >
          <v-expansion-panel-title>
            <template v-slot:default="{ expanded }">
            <span class="font-weight-bold">
              {{ item.name }}
            </span>
              <v-spacer />
              <span v-if="!expanded" class="text-caption">
              مشاهده بیشتر
            </span>
            </template>
          </v-expansion-panel-title>
          <v-expansion-panel-text>
            <div v-for="course in  item.courses" :key="'section-course' + course.product_id" class="d-flex flex-row justify-space-between align-center">
              <v-avatar
                  @click="selectProfessor(course.teacher_id)"
                  class="flex-shrink-1 cursor-pointer"
                  color="white"
                  :image="course.teacher_img ? imageUrlBuilder(course.teacher_img, 'PROFILE') : defaultImageUrlBuilder('assets/images/default/avatars/avatar-default.png')">
              </v-avatar>
              <div  class="d-flex flex-column pa-4 flex-grow-1">
                <div class="d-flex flex-row justify-space-between">
                  <span class="font-weight-bold text-subtitle-2">{{ course.teacher_name }}</span>
                  <span class="text-caption">
                 از {{ course.start_date}}
              </span>
                </div>
                <div class="d-flex flex-row justify-space-between">
              <span class="text-caption">
                ساعت
                {{ course.holding_hours.join(" تا ")}}
              </span>
                  <span class="text-caption">
                {{ daysOfWeek[Number(course.holding_days)]}}
              </span>
                </div>
              </div>
            </div>
          </v-expansion-panel-text>
        </v-expansion-panel>
      </v-expansion-panels>
      <div v-if="!package.data.sections.length" class="d-flex flex-column justify-center align-center pa-4">
        <v-img max-width="64" width="64" :src="defaultImageUrlBuilder('assets/images/empty/empty-state-content.png')"/>
        <p class="font-weight-bold">محتوایی برای نمایش نیست</p>
      </div>
    </div>

  </div>
</template>

<style scoped lang="scss">
</style>