<script setup>
import {useDateFormatter} from "@/composable/useDate";
import { useUrl } from "@/composable/useUrl";
const { defaultImageUrlBuilder,imageUrlBuilder } = useUrl();
const props = defineProps({
  item : Object
})
</script>

<template>
  <v-list-item
      base-color="primary"
      variant="tonal"
      rounded="xl"
      class="mt-2 px-4"
      role="listitem"
      aria-label="notification-btn"
  >
    <v-list-item-media>
            <!-- Displaying product image or default avatar -->
            <v-avatar class="elevation-3 my-2 align-self-start self" :rounded="item.product_img ? 'lg' : 'circle'" size="40">
              <v-img v-if="item.product_img" :src="imageUrlBuilder(item.product_img, 'PRODUCT')" :alt="item.product_img"/>
              <v-img v-else aspect-ratio="1" :src="defaultImageUrlBuilder('assets/images/default/avatars/avatar-default.png')" alt="avatar" />
            </v-avatar>
      <!-- Title of the notification -->
      <span class="mx-3 font-weight-bold">{{ item.title }}</span>
    </v-list-item-media>
<!--    <template v-slot:prepend>-->
<!--      &lt;!&ndash; Displaying product image or default avatar &ndash;&gt;-->
<!--      <v-avatar class="elevation-3 align-self-start self" :rounded="item.product_img ? 'lg' : 'circle'" size="40">-->
<!--        <v-img v-if="item.product_img" :src="imageUrlBuilder(item.product_img, 'PRODUCT')" />-->
<!--        <v-img v-else aspect-ratio="1" :src="defaultImageUrlBuilder('assets/images/default/avatars/avatar-default.png')" />-->
<!--      </v-avatar>-->
<!--    </template>-->



    <!-- Notification message -->
    <div v-html="item.message" class="text-caption"></div>
    <v-list-item-subtitle class="d-flex flex-row-reverse text-caption font-weight-bold">
      <v-chip rounded="xl" class="ss02 mt-2" size="small">
        {{ useDateFormatter(createdAt)}}
      </v-chip>
    </v-list-item-subtitle>
  </v-list-item>
</template>

<style scoped lang="scss">

</style>