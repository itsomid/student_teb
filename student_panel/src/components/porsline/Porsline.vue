<script setup>
import ClModal from "@/components/base/ClModal.vue";
import { initPorsline } from "@/services/external/porsline.service";

const modal = defineModel({default:false});
const openModal = ()=>{
  modal.value = true;
  initPorsline();
}
</script>

<template>
  <div>
    <v-btn
        @click="openModal"
        rounded="xl"
        position="fixed"
        location="top left"
        color="info"
        style=" top:85px; left: 10px"
    >
      شرکت در نظرسنجی
    </v-btn>
    <ClModal :full-screen="true" :model-value="modal" v-model="modal"  width="100%" :blur="true" >
        <div id="OKzNFnxy"></div>
    </ClModal>
  </div>
</template>

<style scoped lang="scss">
.modal-notifications {
  max-height: 500px;
}
</style>