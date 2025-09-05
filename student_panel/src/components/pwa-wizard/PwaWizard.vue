<script setup>

import PwaWizardAndroid from "@/components/pwa-wizard/PwaWizardAndroid.vue";
import PwaWizardIOS from "@/components/pwa-wizard/PwaWizardIOS.vue";
import {useOS} from "@/composable/useOs";
import LocalStorageService from "@/services/LocalStorage.service";
import {useStore} from "vuex";

const store = useStore();
const dialog = defineModel({default: true});
const { os } = useOS();

const closeDialog = ()=>{
  LocalStorageService.set('user-pwa-wizard-rejection-date', new Date().getTime());
  store.dispatch('pwaWizard/closeDialog');
  dialog.value = false;
}
</script>

<template>
  <v-dialog
      v-model="dialog"
      transition="dialog-bottom-transition"
      fullscreen
  >
    <v-card color="#FAFAFC" class="pb-16 bring-to-front">
      <PwaWizardAndroid v-if="os.toLowerCase() === 'android'" />
      <PwaWizardIOS  v-else/>

      <v-card-actions class="position-fixed w-100" style="bottom: 0">
          <v-btn size="large" variant="elevated" color="primary" block rounded="lg" @click="closeDialog">
            متوجه شدم
          </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<style scoped lang="scss">
  .bring-to-front {
    z-index: 9999999;
  }
</style>