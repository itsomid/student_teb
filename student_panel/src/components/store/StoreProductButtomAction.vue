<script setup>
import {PRODUCT_TYPE} from "@/constants/product";
import StoreProductCourseBtn from "@/components/store/StoreProductCourseBtn.vue";
import StoreProductCustomPackageBtn from "@/components/store/StoreProductCustomPackageBtn.vue";
import {defineEmits} from "vue";
import StoreProductPlanZPackageBtn from "@/components/store/StoreProductPlanZPackageBtn.vue";
const emits = defineEmits(['addedToCart']);
const props = defineProps({
  product_id: {
    type: [String,Number],
    required: true
  },
  course_id: {
    type: [String,Number],
  },
  product_type: {
    type: [Number,String],
    required: true,
    validator: (value) => {
      return Object.values(PRODUCT_TYPE).includes(value);
    }
  },
  status: {
    type: String,
    required: true
  },
})

const updateProductStatus = (value) => {
  emits('addedToCart',value)
}
</script>

<template>
  <v-app-bar height="60" app class="pa-0" location="bottom">
    <!-- Render StoreProductCourseBtn for live courses -->
    <StoreProductCourseBtn
        v-if="product_type === PRODUCT_TYPE.LIVE_COURSE"
        :product_id="product_id"
        :course_id="course_id"
        :status="status"
        :bottom="true"
        @addedToCart="updateProductStatus"
    />

    <!-- Render StoreProductCustomPackageBtn for custom packages -->
    <StoreProductCustomPackageBtn
        v-if="product_type === PRODUCT_TYPE.PRODUCT_CUSTOM_PACKAGE"
        :product_id="product_id"
        :status="status"
        :bottom="true"
        @addedToCart="updateProductStatus"
    />

    <!-- Render StoreProductPlanZPackageBtn for custom packages -->
    <StoreProductPlanZPackageBtn
        v-if="product_type === PRODUCT_TYPE.PRODUCT_PLANZ_PACKAGE"
        :product_id="product_id"
        :status="status"
        :bottom="true"
        @addedToCart="updateProductStatus"
    />
  </v-app-bar>
</template>

<style scoped lang="scss">

</style>