<script setup>
import { useProductData } from "@/composable/package/useProductData";
import { useSectionSelection } from "@/composable/package/useSectionSelection";

import StorePackageCard from "@/components/store/package/StorePackageCard.vue";
import StorePackageStepperSection from "@/components/store/package/StorePackageStepperSection.vue";
import ClLoadingOverlay from "@/components/base/ClLoadingOverlay.vue";
import { useNavigator } from "@/composable/useNavigator";
import {useUrl} from "@/composable/useUrl";
import {PRODUCT_STATUS, PRODUCT_TYPE} from "@/constants/product";
import {computed} from "vue";
import { useGoogleTagManager } from "@/composable/useGtm";
import StorePackageBottomAction from "@/components/store/package/StorePackageBottomAction.vue";

const { productId,product, sections, loading, initialSelectedItems } = useProductData();
const { selectedCourses, sectionSelected, select, currentStep } = useSectionSelection(product,initialSelectedItems);
const { trackAddToCartEvent } = useGoogleTagManager();

const {imageUrlBuilder, defaultImageUrlBuilder} = useUrl();
const { navigateToCart } = useNavigator();

const image = (teacher_img) => {
  return teacher_img
      ? imageUrlBuilder(teacher_img, 'PROFILE')
      : defaultImageUrlBuilder('assets/images/default/avatars/avatar-default.png');
};

const changeProductStatus = async () => {
  trackAddToCartEvent({
    name:product.value.product_name,
    id: productId.value,
    original_price: product.value.price,
    off_price: product.value.off_price,
    product_type_id: PRODUCT_TYPE.PRODUCT_CUSTOM_PACKAGE,
    quantity: 1,
  });
  await navigateToCart();
};

const isInCart = computed(() => product.value.in_cart);

</script>

<template>
  <div>
    <!-- Display a loading overlay if loading is true -->
    <ClLoadingOverlay
        v-if="loading"
        :model-value="loading"
        v-model="loading"
        :contained="true"
        scale="1"
        opacity="0.1"
    />

    <!-- Main content when not loading -->
    <div v-else class="position-relative">
      <!-- Main row layout -->
      <v-row class="align-stretch">

        <!-- Main content column, spans different sizes on different screen widths -->
        <v-col
            cols="12"
            md="12"
            lg="8"
            xl="9"
            class="order-2 order-lg-1 order-md-1 order-xl-1 px-0 px-md-3 px-lg-3 p-xl-3"
        >
          <v-row no-gutters>
            <!-- Stepper component for multi-step navigation -->
            <v-stepper-vertical v-model="currentStep" :editable="sections.length === Object.keys(selectedCourses).length" class="rounded-xl" color="primary">
              <template v-slot:default="{ step }">

                <!-- Loop through sections and create a stepper item for each -->
                <template v-for="(section, index) in sections" :key="section.id">
                  <StorePackageStepperSection
                      :section="section"
                      :index="index"
                      :selected-courses="selectedCourses"
                      :section-selected="sectionSelected"
                      :image="image"
                      :select="select"
                      :product_id="productId"
                      :is-in-cart="isInCart"
                      :is-last="index === sections.length - 1"
                      :sections-length="sections.length"
                      @addedToCart="changeProductStatus"
                  />
                </template>

                <!-- Hidden stepper item used to ensure stepper structure -->
                <v-stepper-vertical-item
                    v-show="false"
                    :complete="step > 1"
                    subtitle="Personal details"
                    title="Step one"
                    :value="1"
                >
                  <template v-slot:next="{ next }">
                    <v-btn color="primary" @click="next">Next</v-btn>
                  </template>
                  <template v-slot:prev="{ prev }">
                    <v-btn variant="plain" @click="prev">Previous</v-btn>
                  </template>
                </v-stepper-vertical-item>
              </template>
            </v-stepper-vertical>
          </v-row>
        </v-col>

        <!-- Side content column, shown only on large screens -->
        <v-col
            cols="12"
            md="6"
            lg="4"
            xl="3"
            class="position-sticky order-1 order-lg-2 order-md-2 order-xl-2"
        >
          <StorePackageCard :data="product" :selected="selectedCourses"  @addedToCart="changeProductStatus"/>
        </v-col>
      </v-row>

      <StorePackageBottomAction   v-if="$vuetify.display.smAndDown && product" :data="product" :selected="selectedCourses"  @addedToCart="changeProductStatus" />
    </div>
  </div>
</template>

<style>
.v-stepper-vertical-item:nth-last-child(2):before {
  display: none;
}
.v-stepper-vertical-item:not(:nth-last-child(2)):before {
  z-index: 3;
  right: 35px !important;
}
.v-stepper-vertical-item__avatar {
  z-index: 10;
}
</style>