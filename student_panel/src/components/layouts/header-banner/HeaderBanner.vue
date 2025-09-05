<script setup>
import Tnt1403 from "@/components/header-banners/Tnt1403.vue";
</script>

<template>
  <v-app-bar
      elevation="0"
      scroll-behavior="hide"
      :scroll-threshold="$vuetify.display.lgAndUp ? 100 : 120"
      :height="$vuetify.display.lgAndUp ? 100 : 120">
    <v-carousel :height="$vuetify.display.lgAndUp ? 100 : 120" hide-delimiters cycle :show-arrows="$vuetify.display.lgAndUp" class="header-banner-slider">
      <template v-slot:prev="{ props }">
        <v-icon size="large" class="slider-prev mr-10" color="white"  @click="props.onClick">$mdiChevronRightCircle</v-icon>
<!--        <i class="icon-angle-right slider-prev"  @click="props.onClick"></i>-->
      </template>
      <template v-slot:next="{ props }">
        <v-icon  size="large" color="white" class="slider-next ml-10" @click="props.onClick">$mdiChevronLeftCircle</v-icon>
<!--        <i class="icon-angle-left slider-next"  @click="props.onClick"></i>-->
      </template>
      <v-carousel-item>
        <Tnt1403></Tnt1403>
      </v-carousel-item>
    </v-carousel>
  </v-app-bar>

</template>

<style scoped lang="scss">

</style>