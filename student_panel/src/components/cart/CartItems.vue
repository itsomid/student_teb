<script setup>
  import CartItem from "@/components/cart/CartItem.vue";
  import {useStore} from "vuex";
  import {computed} from "vue";

  const props = defineProps(['items']);
  const store = useStore();
  const nonInstallmentProducts = computed(()=> store.getters['cartStore/nonInstallmentProducts']);

  const isNonInstallmentProduct = (itemName)=> {
    return !!nonInstallmentProducts.value.find((name)=> name === itemName);
  }
</script>

<template>
  <v-slide-y-transition group>
    <div v-for="item in items" :key="'product-in-cart-' + item.product_id">
      <CartItem :item="item" :is-non-installment-product="isNonInstallmentProduct(item.product_name)" />
    </div>
  </v-slide-y-transition>
</template>

<style scoped lang="scss">

</style>