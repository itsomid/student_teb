<script setup>
const props = defineProps({
  classDesc : [String,Object],
  loading: Boolean,
})
</script>

<template>
  <v-card elevation="0" class="pa-4">
    <v-card-title class="text-body-2 font-weight-bold">
      توضیحات دوره
    </v-card-title>
    <v-skeleton-loader v-if="loading" min-width="200" type="card" ></v-skeleton-loader>
    <v-card-text >
      <p v-html="classDesc"></p>
    </v-card-text>
  </v-card>
</template>

<style scoped lang="scss">

</style>