<script setup>
import {onMounted, ref} from "vue";

import {useRoute} from "vue-router";

import ClLoadingOverlay from "@/components/base/ClLoadingOverlay.vue";
import { isUserLoggedIn } from "@/services/Auth.service";
import {useUTMMA} from "@/composable/useUTMMA";
import {useGoogleTagManager} from "@/composable/useGtm";
import {useStore} from "vuex";

const route = useRoute();
const store = useStore();
const {trackEvent} = useGoogleTagManager();
const loading = ref(true);

onMounted(()=>{
  if(isUserLoggedIn()) {
    trackEvent('BOOK_FAIR', {
      registered_user: store?.state?.userStore?.user?.mobile || false,
      ...route.query
    });
     window.location.href = `https://classino.com/book-fair?grade=${+store?.state?.userStore?.user?.grade}&field=${+store?.state?.userStore?.user?.field_of_study}`
  }
  else {
 window.location.href = 'https://classino.com/book-fair'
  }
 
})
</script>

<template>
  <div>
    <ClLoadingOverlay v-if="loading" :model-value="loading" v-model="loading" :contained="true" scale="1" opacity="0.1" />
  </div>
</template>

<style scoped lang="scss">

</style>