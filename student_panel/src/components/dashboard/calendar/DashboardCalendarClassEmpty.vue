<script setup>
import {useUrl} from "@/composable/useUrl";
import {DEFAULT_IMAGE_PATH} from "@/config/filePath.config";

const { defaultImageUrlBuilder } = useUrl();
</script>

<template>
  <v-card elevation="0" class="text-center">
    <v-img width="90" max-width="90" class="mx-auto" :src="defaultImageUrlBuilder(DEFAULT_IMAGE_PATH.EMPTY.CLASS)" />
    <v-card-title class="font-weight-bold mt-6 pt-0">
     امروز کلاسی نداری!
    </v-card-title>
    <v-card-subtitle class="text-wrap">
      سعی کن از اوقات فراغتت به خوبی استفاده کنی.
    </v-card-subtitle>
  </v-card>
</template>

<style scoped lang="scss">

</style>