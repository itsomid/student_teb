<script setup>
import {useStore} from "vuex";
import { onBeforeRouteUpdate } from 'vue-router'
import Finance from "../components/finance/Finance.vue";

const store = useStore();


onBeforeRouteUpdate(async (to, from,next) => {
  await store.dispatch('userStore/updateProfile');
})


</script>

<template>
  <Finance />
</template>

<style scoped lang="scss">

</style>