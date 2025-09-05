<script setup>
/**
 * Vue component for displaying course information.
 * @component
 * @vue
 */
import { useDateFormatter } from "@/composable/useDate";
import { useUrl } from "@/composable/useUrl";
import ImageLoading from "@/components/base/ImageLoading.vue";
import {DEFAULT_IMAGE_PATH} from "@/config/filePath.config";
import ClImage from "@/components/base/ClImage.vue";

/**
 * Props for the component.
 * @type {import('vue').DefineProps<{ item: { course_id: number, img: string, name: string, holding_days: number, options: { holding_days2: number, holding_days3: number, holding_hours: number[], holding_hours2: number[], holding_hours3: number[] } } }>}
 */
const props = defineProps({
  item: {
    type: Object,
    required: true,
  }
})

/**
 * Days of the week in Persian.
 * @type {Object<string, string>}
 */
const daysOfWeek = {
  0: '',
  1: 'شنبه',
  2: 'یک‌شنبه',
  3: 'دوشنبه',
  4: 'سه‌شنبه',
  5: 'چهارشنبه',
  6: 'پنج‌شنبه',
  7: 'جمعه',
};

/**
 * Image URL builder functions.
 * @type {Object}
 * @property {Function} imageUrlBuilder - Function for building image URLs.
 * @property {Function} defaultImageUrlBuilder - Function for building default image URLs.
 */
const { imageUrlBuilder,defaultImageUrlBuilder } = useUrl();

</script>

<template>
  <v-hover>
    <template v-slot:default="{ isHovering,props }">
      <v-card
          v-bind="props"
          :elevation="isHovering ? 8 : 1"
          height="100%"
          rounded
          class="rounded-xl"
          :to="{name:'course', params:{id: item.course_id}}"
      >
        <ClImage
            path="PRODUCT"
            :default-image="DEFAULT_IMAGE_PATH.PRODUCTS"
            :alt="item.name"
            :image="item.img"
        />
        <v-card-text class="pa-6">
          <h1 class="text-body-1 font-weight-bold"> {{ item.name }} </h1>
        </v-card-text>
        <v-card-text class="d-flex flex-row justify-space-between pa-6">
          <div class="d-flex flex-row">
            <i class="icon-CL_calendar text-primary text-h6"></i>
            <p class="mx-3">
              {{ daysOfWeek[item.holding_days] }}
              <span v-if="+item.options.holding_days2">{{' - '+daysOfWeek[item.options.holding_days2] }}</span>
              <span v-if="+item.options.holding_days3">{{' - '+daysOfWeek[item.options.holding_days3]}}</span>
            </p>
          </div>
          <div class="d-flex flex-row">
            <i class="icon-CL_clock text-primary text-h6"></i>
            <p class="mx-3">
              {{ item.holding_hours[0] }} تا {{ item.holding_hours[1] }}
              <span v-if="+item.options.holding_days2">- {{item.options.holding_hours2[0]}} تا {{item.options.holding_hours2[1]}}</span>
              <span v-if="+item.options.holding_days3"> - {{item.options.holding_hours3[0]}} تا {{item.options.holding_hours3[1]}}</span>
            </p>
          </div>
        </v-card-text>
      </v-card>
    </template>
  </v-hover>
</template>

<style scoped lang="scss">

</style>