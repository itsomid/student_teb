<script setup>
import { useUrl } from '@/composable/useUrl';
import { DEFAULT_IMAGE_PATH } from '@/config/filePath.config';

const props = defineProps({
  course: Object,
  isDark: Boolean
});

const { imageUrlBuilder, defaultImageUrlBuilder } = useUrl();
</script>

<template>
  <v-list-item lines="three" class="px-0">
    <v-list-item-media>
      <v-img
          max-width="56"
          rounded="lg"
          aspect-ratio="1"
          cover
          :src="course.course_data.data.image ? imageUrlBuilder(course.course_data.data.image, 'PRODUCT') : defaultImageUrlBuilder(isDark ? DEFAULT_IMAGE_PATH.PRODUCTS_DARK : DEFAULT_IMAGE_PATH.PRODUCTS_LIGHT)"
      />
    </v-list-item-media>
    <v-list-item-title class="d-flex flex-row align-center justify-space-between mt-2 text-wrap">
      {{ course.course_name }}
    </v-list-item-title>
    <v-list-item-subtitle class="mt-2 text-truncate-none line-height-2">
      {{ course.course_data.data.teacher_name }}
    </v-list-item-subtitle>
  </v-list-item>
</template>

<style scoped lang="scss">

</style>