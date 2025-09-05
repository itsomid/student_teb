<script setup>
import {useUrl} from "@/composable/useUrl";
import {DEFAULT_IMAGE_PATH} from "@/config/filePath.config";

const { defaultImageUrlBuilder } = useUrl();
</script>

<template>
  <v-card color="transparent" elevation="0" class="text-center mt-16">
    <v-img width="90" max-width="90" class="mx-auto" :src="defaultImageUrlBuilder(DEFAULT_IMAGE_PATH.EMPTY.FINANCE)" />
    <v-card-title class="mt-6 pt-0 text-wrap">
      اطلاعاتی برای نمایش وجود نداره.
    </v-card-title>
  </v-card>
</template>

<style scoped lang="scss">

</style>