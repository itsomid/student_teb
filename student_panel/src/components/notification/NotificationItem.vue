<script setup>
  import {useDateFormatter} from "@/composable/useDate";
  import { useUrl } from "@/composable/useUrl";
  const { defaultImageUrlBuilder,imageUrlBuilder } = useUrl();
  const props = defineProps({
    item : Object
  })
</script>

<template>
  <!-- Hover component to handle hover states -->
  <v-hover>
    <template v-slot:default="{ isHovering, props }">
      <!-- Card displaying the notification item -->
      <v-card v-bind="props" :elevation="isHovering ? 8 : 1" rounded class="rounded-xl mb-6" color="card">
        <!-- Card title section -->
        <v-card-title class="px-6">
          <!-- Icon representing the notification type -->
          <v-icon size="small" class="font-weight-normal ml-3">$mdiChatOutline</v-icon>
          <!-- Title of the notification -->
          {{ item.title }}
        </v-card-title>
        <!-- Divider between title and content -->
        <v-divider />
        <!-- Card content section -->
        <v-card-text class="pa-4">
          <!-- Container for notification content -->
          <div class="d-flex flex-row align-center">
            <!-- Avatar section -->
            <div v-if="$vuetify.display.lgAndUp" class="px-3 py-0">
              <!-- Displaying product image or default avatar -->
              <v-avatar class="elevation-3" :rounded="item.product_img ? 'xl' : 'circle'" size="70">
                <v-img v-if="item.product_img" :src="imageUrlBuilder(item.product_img, 'PRODUCT')" />
                <v-img v-else aspect-ratio="1" :src="defaultImageUrlBuilder('assets/images/default/avatars/avatar-default.png')" />
              </v-avatar>
            </div>
            <!-- Notification message -->
            <div>
              <p v-html="item.message" class="mt-2"></p>
            </div>
          </div>
        </v-card-text>
        <!-- Card actions section -->
        <v-card-actions class="d-flex flex-row-reverse px-6">
          <!-- Displaying formatted creation date of the notification -->
          {{ useDateFormatter(item.createdAt, "SHORT_TIME") }}
        </v-card-actions>
      </v-card>
    </template>
  </v-hover>
</template>

<style scoped lang="scss">

</style>