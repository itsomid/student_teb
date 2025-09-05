<script setup>
import {useUrl} from "@/composable/useUrl";

const props = defineProps(['description']);
const {  defaultImageUrlBuilder } = useUrl();
</script>

<template>
  <div>
    <div v-if="description">
      <p>درباره دوره:</p>
      <p v-html="description"></p>
    </div>
    <div v-else class="d-flex flex-column justify-center align-center pa-4">
      <v-img max-width="64" width="64" :src="defaultImageUrlBuilder('assets/images/empty/empty-state-content.png')"/>
      <p class="font-weight-bold">محتوایی برای نمایش نیست</p>
    </div>
  </div>
</template>

