<script setup>
import {useUrl} from "@/composable/useUrl";
import {DEFAULT_IMAGE_PATH} from "@/config/filePath.config";


const { defaultImageUrlBuilder } = useUrl();


</script>

<template>
  <v-card color="transparent" elevation="0" class="text-center mt-16">
    <v-img width="90" max-width="90" class="mx-auto" :src="defaultImageUrlBuilder(DEFAULT_IMAGE_PATH.EMPTY.COURSE )" />
    <v-card-title class="font-weight-bold mt-8 pt-0">
      به کلاسینو خوش اومدی ❤️
    </v-card-title>
    <v-card-subtitle class="mt-4 text-wrap">
      کنار دانش آموزهای هم سن خودت درس بخون و پیشرفت کن!
    </v-card-subtitle>
    <v-card-actions class="d-flex justify-center align-center mt-4">
      <v-btn :to="{name: 'store'}" color="primary" variant="elevated" elevation="0" border rounded="lg">
        می‌خوام اولین دوره‌ام رو شرکت کنم
        <v-icon>$mdiChevronLeft</v-icon>
      </v-btn>
    </v-card-actions>
  </v-card>
</template>

<style scoped lang="scss">

</style>