<script setup>
import ClLoading from "@/components/base/ClLoading.vue";
import {onMounted, reactive, ref, watch} from "vue";
const { success } = useAlert();
import StoreSearch from "@/components/store/products/StoreSearch.vue";
import StoreFilters from "@/components/store/products/StoreFilters.vue";
import StoreProductItem from "@/components/store/products/StoreProductItem.vue";
import {useProductFilters} from "@/composable/products/useProductFilters";
import StoreEmpty from "@/components/store/products/StoreEmpty.vue";
import StoreFilterMobile from "@/components/store/products/StoreFilterMobile.vue";
import ClPagination from "@/components/app/ClPagination.vue";
import {useRoute, useRouter} from "vue-router";
import StudentPanelSwitcher from "@/components/store/StudentPanelSwitcher.vue";
import {useAlert} from "@/composable/useAlert";
const route = useRoute();
const { filteredProducts, searchQuery,applyFilters, pagination, loading } = useProductFilters();
const isShowOldProduct = ref(false)

const changeProductStatus = (productId) => {
  const product = filteredProducts.value.find((p) => p.id === productId);
  if (product) {
    product.store_status = 'in_cart';
  }
};
const changeIsShowOldProduct = () => {
  isShowOldProduct.value = true
  success(' لیست محصولات با موفقیت بروزرسانی شد')
}

onMounted(()=>{
  applyFilters(1, route.query)
});
</script>

<template>
  <div>
    <div>
      <StudentPanelSwitcher @showOldProduct="changeIsShowOldProduct" />
      <!-- Search and filters -->
      <v-row v-if="isShowOldProduct">
        <v-col cols="12" lg="2">
          <StoreSearch v-model="searchQuery" />
        </v-col>
        <v-col cols="12" lg="10">
          <StoreFilters />
<!--          <StoreFilters v-if="$vuetify.display.lgAndUp"/>-->
<!--          <StoreFilterMobile v-else/>-->
        </v-col>
      </v-row>

      <!-- Loading indicator -->
      <ClLoading v-if="loading && !isShowOldProduct" />

      <div v-else-if="!loading && isShowOldProduct">
        <!-- Products -->
        <v-row class="d-flex flex-row align-stretch" v-if="filteredProducts.length !== 0">
          <v-col
              cols="12"
              xl="3"
              lg="3"
              md="4"
              sm="6"
              v-for="item in filteredProducts"
              :key="'product-item-' + item.id"
          >
            <StoreProductItem :item="item" @addedToCart="changeProductStatus" />
          </v-col>
          <v-col cols="12">
            <div class="mt-16">
              <ClPagination :total-pages="pagination.last_page" v-model="pagination.current_page" size="default" />
            </div>
          </v-col>
        </v-row>

        <StoreEmpty v-else />
      </div>
    </div>
  </div>
</template>


<style scoped lang="scss">

</style>
