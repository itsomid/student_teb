<script setup>
import {useNumberFormatter} from "../../composable/useNumberFormatter";
import {useUrl} from "../../composable/useUrl";

import { DEFAULT_IMAGE_PATH } from "@/config/filePath.config";
import {useThemeManager} from "@/composable/useThemeManager";
const props = defineProps({
  item: {
    type: Object,
    required: true
  },
  isNonInstallmentProduct: {
    type: Boolean,
    required: true,
    default: false,
  }
});

const { numberFormatter } = useNumberFormatter();
const { imageUrlBuilder, defaultImageUrlBuilder } = useUrl();
const { isDark } = useThemeManager();
</script>

<template>
  <v-card rounded="xl" border flat class="d-flex flex-row align-center pa-4">
    <!-- Product image/avatar -->
    <v-avatar
        tile
        rounded="xl"
        class="ml-3"
        size="80"
        :image="item.product_img ? imageUrlBuilder(item.product_img, 'PRODUCT') : defaultImageUrlBuilder(isDark ? DEFAULT_IMAGE_PATH.PRODUCTS_DARK : DEFAULT_IMAGE_PATH.PRODUCTS_LIGHT)"
    />
    <div>
      <div>{{ item.product_name }}</div>
      <div class="mt-3">
        <span>قیمت دوره:</span>
        <span class="">
          <strong>{{ numberFormatter(item.amount) }}</strong><small class="mx-1">ریال</small>
        </span>
      </div>
    </div>
  </v-card>
</template>

<style scoped lang="scss">

</style>