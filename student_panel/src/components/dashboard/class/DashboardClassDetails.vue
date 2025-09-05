<script setup>
import { useDateFormatter } from '@/composable/useDate';

const props = defineProps({
  course: Object
});
</script>

<template>
  <div class="d-flex flex-column">
    <div class="d-flex flex-row justify-space-between mt-3">
      <span class="text-secondary">وضعیت</span>
      <span class="">مشاهده نشده</span>
    </div>
    <div class="d-flex flex-row justify-space-between mt-3">
      <span class="text-secondary">تاریخ برگزاری</span>
      <span class="">{{ useDateFormatter(course.holding_date) }}</span>
    </div>
    <div class="d-flex flex-row justify-space-between mt-3">
      <span class="text-secondary">زمان برگزاری</span>
      <span class="">{{ useDateFormatter(course.holding_date, 'HOUR') }}</span>
    </div>
  </div>
</template>

<style scoped lang="scss">

</style>