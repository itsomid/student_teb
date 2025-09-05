<script setup>
const props = defineProps({
  status: Number,
})
</script>

<template>
  <v-chip color="error" class="px-3" rounded="xl">
    برای نمایش جلسه،
    <span v-if="status === 102" class="font-weight-bold mx-1">ارسال تکلیف</span>
    <span v-if="status === 103" class="font-weight-bold mx-1">ارسال کارنامه</span>
    <span v-if="status === 104" class="font-weight-bold mx-1">شرکت در آزمون کلاسی</span>
    اجباری میباشد
  </v-chip>
</template>

<style scoped lang="scss">

</style>