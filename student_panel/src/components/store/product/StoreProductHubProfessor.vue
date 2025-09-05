<script setup>
import {computed, defineAsyncComponent} from "vue";
import ClError from "@/components/app/ClError.vue";
import {PRODUCT_TYPE} from "@/constants/product";

const props = defineProps(['data','productType'])

// Asynchronous component definitions
const StoreHubProductProfessor = defineAsyncComponent({
  loader: () => import("./StoreHubProductProfessor.vue"),
  delay: 0,
  errorComponent: ClError,
  timeout: 3000,
});
const StoreHubPackageProfessors = defineAsyncComponent({
  loader: () => import("./StoreHubPackageProfessors.vue"),
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
    <StoreHubProductProfessor
        v-if="isCourse"
        :professor="data"
    />
    <StoreHubPackageProfessors
        v-else-if="isPackage"
        :professors="data"
    />
  </div>
</template>

<style scoped lang="scss">

</style>