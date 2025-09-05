<script setup>
import {ref} from "vue";
  import {useUrl} from "@/composable/useUrl";

  const props = defineProps({
    image: {
      type: String,
      required: false,
    },
    path: {
      type: String,
      required: true,
    },
    alt: {
      type: String,
      required: true,
    },
    aspectRatio: {
      type: [String,Number],
      default: 1,
    },
    skeletonWidth : {
      type: [String,Number]
    },
    skeletonHeight: {
      type: [String,Number]
    },

    defaultImage: {
      type: String,
      required: true,
    }
  })

  const { imageUrlBuilder, defaultImageUrlBuilder } = useUrl();
  const isImageLoaded = ref(false);


const onLoad = ()=> {
    isImageLoaded.value = true;
  }

</script>

<template>
  <div>
    <v-img
        loading="lazy"
        :aspect-ratio="aspectRatio || null"
        :src="imageUrlBuilder(image, path)"
        :lazy-src="defaultImageUrlBuilder(defaultImage)"
        :alt="alt || 'image'"
        @load="onLoad"
        cover
        v-bind="$attrs"
    >
      <template v-slot:placeholder>
        <v-responsive  class="d-flex align-center justify-center fill-height">
          <v-progress-circular
              color="grey-lighten-4"
              class="mx-auto d-block"
              indeterminate
          ></v-progress-circular>
        </v-responsive>
      </template>
    </v-img>
  </div>
</template>

<style scoped lang="scss">

</style>