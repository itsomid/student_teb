<script setup>
import {useUrl} from "@/composable/useUrl";
import {DEFAULT_IMAGE_PATH} from "@/config/filePath.config";
import {useRoute, useRouter} from "vue-router";

const { defaultImageUrlBuilder } = useUrl();

const router  = useRouter();
const route = useRoute();
const removeFilters = ()=> {
  router.push({name: router.name})
}
</script>

<template>
  <v-card color="transparent" elevation="0" class="text-center mt-16">
    <v-img width="90" max-width="90" class="mx-auto" :src="defaultImageUrlBuilder(DEFAULT_IMAGE_PATH.EMPTY.STORE)" />
    <v-card-title class="font-weight-bold mt-8 pt-0">
      دوره‌ای با این مشخصات وجود نداره!
    </v-card-title>
    <v-card-subtitle class="mt-4 text-wrap">
      با حذف و تغییر یک یا تعدادی از فیلترها، می‌تونی نتایج بهتری رو ببینی.
    </v-card-subtitle>
    <v-card-actions class="d-flex justify-center align-center mt-4">
      <v-btn @click="removeFilters" variant="elevated" elevation="0" border rounded="lg">
        حذف فیلترها
      </v-btn>
    </v-card-actions>
  </v-card>
</template>

<style scoped lang="scss">

</style>