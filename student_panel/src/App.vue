
<script setup>
import {computed, defineAsyncComponent, onMounted, ref, watch} from "vue";
import { useStore } from 'vuex';

import LayoutFactory from "./layouts/LayoutFactory.vue";
import Snackbar from "./components/base/Snackbar.vue";
import {useDevice} from "@/composable/useDevice";
import {usePWAStatus} from "@/composable/usePWAStatus";
import {useRoute} from "vue-router";
// import ClNotificationAlert from "@/components/app/ClNotificationAlert.vue";

const route = useRoute();
const { isMobile } = useDevice();
const { isInstalled, isDaysPassed } = usePWAStatus();

const PwaWizard = defineAsyncComponent(()=>import("./components/pwa-wizard/PwaWizard.vue"))

const store = useStore();

const showAlert = ref(false);
const alert = computed(() => store.getters['alert/data']);

watch(alert, (value) =>{
  showAlert.value = true;
})
onMounted(()=> {
  let loadingElement  = document.getElementById('loading-section')
  if (loadingElement){
    loadingElement.remove()
  }
});

const isPanelRoute = ref(false);
const pwaDialog = computed(()=>store.getters['pwaWizard/dialog']);

watch(route, (value)=>{
  let isInteralRoute = value.path.startsWith('/newpanel');
  if(isInteralRoute) {
    setTimeout(()=>{
      isPanelRoute.value = true;
    }, 10000)
  }
})
</script>
<template>
  <LayoutFactory/>
  <Snackbar />
  <PwaWizard v-if="isMobile && isPanelRoute && !isInstalled && (isDaysPassed || pwaDialog)" />
<!--  <ClNotificationAlert v-model="showAlert" :model-value="showAlert" :type="alert.type"  :timeout="alert.timeout">-->
<!--    {{ alert.text }}-->
<!--  </ClNotificationAlert>-->
</template>
<style lang="scss">
@import "@/styles/main";
</style>
