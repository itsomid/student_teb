<script setup>
const props = defineProps({
  resume:{
    type: String,
    required: true
  },
  profName:{
    type: String,
    required: true
  },
})
</script>

<template>
  <v-col cols="12" md="4" class="align-center"  :class="$vuetify.display.mdAndDown?'px-8':''">
    <h4 class="text-h5">رزومه استاد <strong>{{profName}}</strong></h4>
    <div class="mt-10" :class="$vuetify.display.mdAndDown?'px-4':''" v-html="resume"></div>
  </v-col>
</template>

<style scoped lang="scss">

</style>
