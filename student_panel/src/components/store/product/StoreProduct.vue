<script setup>
import {onMounted} from "vue";
import ClLoadingOverlay from "@/components/base/ClLoadingOverlay.vue";
import StoreProductCard from "@/components/store/product/StoreProductCard.vue";
import StoreProductHub from "@/components/store/product/StoreProductHub.vue";
import StoreProductBottomAction from "@/components/store/StoreProductButtomAction.vue";
import {useNavigator} from "@/composable/useNavigator";
import {useProduct} from "@/composable/product/useProduct";
import {useUrl} from "@/composable/useUrl";
import ClPlyrPlayerWithoutHls from "@/components/players/ClPlyrPlayerWithoutHls.vue";
import { useGoogleTagManager } from "@/composable/useGtm";


// Product management
const { product, loading, getProduct, productId } = useProduct();
const { trackAddToCartEvent } = useGoogleTagManager();
const { navigateToCart } = useNavigator();
const { introduceVideoUrlBuilder } = useUrl();
const changeProductStatus = () => {
  trackAddToCartEvent(product.value)
  product.value.status = 'in_cart';
};

onMounted(async () => {
  await getProduct(productId.value);
});
</script>

<template>
  <div>
    <!-- Loading indicator -->
    <ClLoadingOverlay v-if="loading" :model-value="loading" v-model="loading" :contained="true" scale="1" opacity="0.1" />
    <div v-else-if="product" class="position-relative">
      <v-row class="align-stretch">
          <v-col cols="12" md="6" lg="8" xl="9" class="order-2 order-lg-1 order-md-1 order-xl-1 px-0 px-md-3 px-lg-3 p-xl-3">
            <v-row no-gutters>
              <v-col cols="12" v-if="$vuetify.display.mdAndUp && product.video_source">
                <ClPlyrPlayerWithoutHls :vod-link="introduceVideoUrlBuilder(product.video_source)" />
              </v-col>
              <v-col cols="12" class="px-0 px-md-3 px-lg-3 p-xl-3 mt-4">
                <StoreProductHub :data="product"/>
              </v-col>
            </v-row>
          </v-col>
          <v-col cols="12" md="6" lg="4" xl="3" class="position-relative order-1 order-lg-2 order-md-2 order-xl-2">
            <StoreProductCard :data="product" @addedToCart="changeProductStatus"/>
          </v-col>
      </v-row>
    </div>

    <StoreProductBottomAction
        v-if="$vuetify.display.smAndDown && product"
        :product_id="product.id"
        :course_id="product.course_id"
        :status="product.status"
        :product_type="product.product_type_id"
        @addedToCart="changeProductStatus"
    />
  </div>
</template>

