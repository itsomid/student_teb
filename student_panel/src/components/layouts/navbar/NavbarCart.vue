<script setup>

import {computed} from "vue";
import { useStore } from "vuex";
const store = useStore();

const count = computed(()=> store.getters['cartStore/cartItemsCount']);

</script>

<template>
  <VBadge
      :model-value="!!count"
      location="top right"
      offset-x="3"
      offset-y="3"
      color="error"
      :content="count"
      aria-label="cart"
  >
    <VBtn border rounded="lg" size="small"  aria-label="cart-btn" variant="text"  icon="$mdiCartOutline" :to="{name: 'cart'}">
    </VBtn>
  </VBadge>
</template>

<style scoped lang="scss">

</style>