<script setup>
  import { useDateFormatter } from "@/composable/useDate";

  const date = new Date().toUTCString();
</script>

<template>
  <v-hover>
    <template v-slot:default="{ isHovering,props }">
      <v-card v-bind="props" :elevation="isHovering ? 8 : 1" rounded class="rounded-xl" height="100%">
    <v-toolbar height="80" color="primary">
      <v-spacer />
      <span class="text-h5 font-weight-bold">{{ useDateFormatter(date,'MONTH') }}</span>
      <v-spacer />
    </v-toolbar>
    <v-card-text class="text-center d-flex flex-column justify-center align-center"  style="height: calc(100% - 80px)">
        <span class="text-h2 font-weight-bold text-primary">{{ useDateFormatter(date,'DAY_SHORT') }}</span>
        <span class="text-h5 font-weight-bold mt-3">{{ useDateFormatter(date,'DAY') }}</span>
    </v-card-text>
  </v-card>
    </template>
  </v-hover>
</template>

<style scoped lang="scss">

</style>