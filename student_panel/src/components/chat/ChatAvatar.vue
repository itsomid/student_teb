<script setup>
import { useUrl } from "@/composable/useUrl";
const { defaultImageUrlBuilder,imageUrlBuilder } = useUrl();
const props = defineProps({
  image: String,
  dot: {
    type: Boolean,
    default: true
  },
  location: {
    type: String,
    default: 'bottom right',
  },
  color: {
    type: String,
    default: 'success'
  },
  bordered: {
    type: Boolean,
    default: true,
  },
  showBadge: {
    type: Boolean,
    default: false
  },
})


</script>

<template>
  <VBadge
      :model-value="showBadge"
      :dot="dot"
      :location="location"
      offset-x="3"
      offset-y="3"
      :color="color"
      :bordered="bordered"
  >
    <v-avatar  class="elevation-3">
      <v-img aspect-ratio="1" :src="image ? imageUrlBuilder(image, 'USER_PROFILE') : defaultImageUrlBuilder('assets/images/default/avatars/avatar-default.png')" />
    </v-avatar>
  </VBadge>
</template>

<style scoped lang="scss">

</style>