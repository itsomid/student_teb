<script setup>
import {useDateFormatter} from "@/composable/useDate";
const date = new Date().toUTCString();
</script>

<template>
  <div class="d-flex flex-column justify-center align-center pa-6" style="min-width: 200px">
    <span class="text-secondary text-h6 font-weight-bold">{{ useDateFormatter(date, 'MONTH') }}</span>
    <span class="mt-6 mb-3 text-h3 font-weight-bold">{{ useDateFormatter(date, 'DAY_SHORT') }}</span>
    <span class="text-secondary text-h5 font-weight-bold">{{ useDateFormatter(date, 'DAY') }}</span>
  </div>
</template>

<style scoped lang="scss">

</style>