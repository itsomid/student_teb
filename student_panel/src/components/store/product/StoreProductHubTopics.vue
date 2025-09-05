<script setup>
import {computed, defineAsyncComponent} from "vue";
import ClError from "@/components/app/ClError.vue";
import {PRODUCT_TYPE} from "@/constants/product";

/**
 * @typedef {Object} Props
 * @property {string} classes - classes of this course
 * @property {boolean} loading - Boolean indicating if the component is in a loading state.
 * @property {string} productStatus - Status of the product.
 * @property {string} productType - Type of the product.
 */
const props = defineProps(['classes','package', 'loading', 'productStatus','productType'])

// Asynchronous component definitions
const StoreProductHubProductTopics = defineAsyncComponent({
  loader: () => import("./StoreProductHubProductTopics.vue"),
  delay: 0,
  errorComponent: ClError,
  timeout: 3000,
});
const StoreProductHubPackageTopics = defineAsyncComponent({
  loader: () => import("./StoreProductHubPackageTopics.vue"),
  delay: 0,
  errorComponent: ClError,
  timeout: 3000,
});

// Computed properties to determine the type of product
const isCourse = computed(()=> props.productType === PRODUCT_TYPE.LIVE_COURSE);
const isPackage = computed(()=> props.productType === PRODUCT_TYPE.PRODUCT_PACKAGE
    || props.productType === PRODUCT_TYPE.PRODUCT_CUSTOM_PACKAGE
    || props.productType === PRODUCT_TYPE.PRODUCT_PLANZ_PACKAGE );
</script>

<template>
  <div>
    <!-- Conditionally render StoreProductHubProductTopics if the product is a course -->
    <StoreProductHubProductTopics
        v-if="isCourse"
      :loading="loading"
      :classes="classes"
      :product-status="productStatus"
    ></StoreProductHubProductTopics>

    <!-- Conditionally render StoreProductHubPackageTopics if the product is a package -->
    <StoreProductHubPackageTopics
        v-else-if="isPackage"
        :package="package"
        :product-status="productStatus"
    ></StoreProductHubPackageTopics>
  </div>
</template>

<style  lang="scss">

</style>