<script setup>
  import {ref} from "vue";
  import ClSupportReportBugModal from "@/components/layouts/support/ClSupportReportBugModal.vue";

  const active = ref(false);
</script>

<template>
  <v-list  nav color="error">
    <v-list-item active   color="error" @click="active= true">
      گزارش خطا
    </v-list-item>
  </v-list>
  <ClSupportReportBugModal v-model="active"/>
</template>

<style scoped lang="scss">

</style>