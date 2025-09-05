<script setup>
import ClLoadingOverlay from "@/components/base/ClLoadingOverlay.vue";
import {useAlert} from "@/composable/useAlert";
import {computed, onMounted, ref} from "vue";
import {useRoute} from "vue-router";
import RepositoryFactory from "@/repository/RepositoryFactory";
import {useCart} from "@/composable/useCart";

const { error } = useAlert();
const {loading, addToCartOnRedirectAfterLogin } = useCart({})

/**
 * Vue route instance.
 * @type {import('vue-router').RouteLocationNormalized}
 */
const route   = useRoute();

const productId       = computed(()=> route.params.product_id);
const isInstallments  = computed(()=> route.query.installment ? route.query.installment : 0);


const PaymentRepository = RepositoryFactory.get('Payment');

const addToCart = async (isInstallments,productId) => {
  try {
    await PaymentRepository.changePaymentMethod({is_installment: isInstallments});
    await addToCartOnRedirectAfterLogin(productId, route.query)
  }catch (e) {
    error(e.error.message);
  }
}

onMounted(()=>{
  addToCart(isInstallments.value, productId.value);
})
</script>

<template>
  <ClLoadingOverlay
      v-if="loading"
      :model-value="loading"
      v-model="loading"
      :contained="true"
      scale="1"
      opacity="0.1"/>
</template>

<style scoped lang="scss">

</style>