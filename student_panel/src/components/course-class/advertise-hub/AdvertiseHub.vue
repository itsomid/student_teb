<script setup>
import AdvertiseHubCourseSpecificBanners
  from "@/components/course-class/advertise-hub/AdvertiseHubCourseSpecificBanners.vue";
import AdvertiseHubPromoBanners from "@/components/course-class/advertise-hub/AdvertiseHubPromoBanners.vue";

const props = defineProps({
  productId: [String,Number],
  loading: Boolean,
})


</script>

<template>
  <div class="d-flex flex-column" style="gap: 10px">
    <AdvertiseHubCourseSpecificBanners :productId="productId"/>
    <v-divider color="primary" thickness="3" class="my-6 rounded" />
    <AdvertiseHubPromoBanners/>
  </div>
</template>

<style scoped lang="scss">

</style>