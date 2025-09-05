<script setup>
const props = defineProps({
  blockDetail: Object,
})
import {useDateFormatter} from "@/composable/useDate";

</script>

<template>
  <div class="d-flex flex-column">
    <span class="text-center text-body-2 font-weight-bold">
      شما تا {{ useDateFormatter(blockDetail.expired_at) }} از این جلسه بلاک خواهید بود
    </span>
    <v-chip rounded="xl" color="error" class="text-center mt-3 ">
      دلیل بلاک شدن:
      <strong>{{
        blockDetail.description
      }}</strong>
    </v-chip>
  </div>
</template>

<style scoped lang="scss">

</style>