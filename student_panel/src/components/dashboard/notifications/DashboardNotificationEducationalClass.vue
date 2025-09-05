<script setup>
  import {useDateFormatter} from "../../../composable/useDate";
  import {useUrl} from "@/composable/useUrl";

  const props = defineProps(['item']);
  const { imageUrlBuilder } = useUrl();
</script>

<template>
  <div>
    <v-list-item lines="three">
      <v-list-item-media>
        <v-img max-width="56" rounded="lg" aspect-ratio="1" cover :src="imageUrlBuilder(item.action_data.img_filename, 'PRODUCT')" />
      </v-list-item-media>
      <v-list-item-title class="d-flex flex-row align-center justify-space-between mt-2">
        {{ item.title }}
        <v-icon v-if="item.unread" size="10" color="primary">$mdiCircle</v-icon>
      </v-list-item-title>
      <v-list-item-subtitle class="mt-2 text-truncate-none line-height-2">
        {{ item.message}}
      </v-list-item-subtitle>
      <v-list-item-subtitle class="mt-2 text-wrap">
        {{  useDateFormatter(item.createdAt,'START_WEEK_HOUR') }}
      </v-list-item-subtitle>
    </v-list-item>
    <v-divider />
  </div>
</template>

<style scoped lang="scss">

</style>