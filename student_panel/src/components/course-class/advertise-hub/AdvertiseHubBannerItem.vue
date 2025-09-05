<script setup>
import {useUrl} from "@/composable/useUrl";

const props = defineProps({
  item : [Object],
  loading: Boolean,
  closeable: {
    type: Boolean,
    default: true,
  },
})

const emits = defineEmits(['remove']);

const { imageUrlBuilder,defaultImageUrlBuilder } = useUrl();

const removeItem = ()=> {
  emits('remove', props.item.title);
}
</script>

<template>
  <v-hover>
    <template v-slot:default="{ isHovering,props }">
      <v-card
          v-bind="props"
          :elevation="isHovering ? 8 : 3"
          rounded="xl"
          :href="item.ext_url"
          target="_blank"
      >
        <v-img
            rounded="xl"
            loading="lazy"
            aspect-ratio="6.125"
            :src="imageUrlBuilder(item.img_filename, 'ANNOUNCEMENT')"
            :lazy-src="defaultImageUrlBuilder('assets/images/default/classes/banner-default.jpg')"
            :alt="item.title"
                style="cursor: pointer; width: 100%;border-radius: 10px;">
          <template v-slot:placeholder>
            <v-responsive :aspect-ratio="4 / 3" class="d-flex align-center justify-center fill-height">
              <v-progress-circular
                  color="grey-lighten-4"
                  class="mx-auto d-block"
                  indeterminate
              ></v-progress-circular>
            </v-responsive>
          </template>
          <v-fab
              v-if="closeable"
              @click.prevent="removeItem"
              icon="$mdiClose"
              size="x-small"
              class="ma-2"
              variant="elevated"
          ></v-fab>
        </v-img>
      </v-card>
    </template>
  </v-hover>
</template>

<style scoped lang="scss">

</style>