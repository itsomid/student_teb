<script setup>
import {useUrl} from "@/composable/useUrl";
import {DEFAULT_IMAGE_PATH} from "@/config/filePath.config";

const { defaultImageUrlBuilder } = useUrl();
</script>

<template>
  <v-card elevation="0" class="text-center mt-16">
    <v-img width="90" max-width="90" class="mx-auto" :src="defaultImageUrlBuilder(DEFAULT_IMAGE_PATH.EMPTY.NOTIFICATION)" />
    <v-card-subtitle class="mt-6 pt-0 text-wrap">
      اعلانی برای نمایش وجود نداره.
    </v-card-subtitle>
  </v-card>
</template>

<style scoped lang="scss">

</style>