<script setup>
import {computed, onMounted, ref} from "vue";
import {useRoute} from "vue-router";
import RepositoryFactory from "@/repository/RepositoryFactory";
import {useAlert} from "@/composable/useAlert";
import PaymentSuccess from "./PaymentSuccess.vue";

import PaymentInvoice from "./PaymentInvoice.vue";
import PaymentInstallments from "./PaymentInstallments.vue";
import PaymentFailed from "./PaymentFailed.vue";
import PaymentFailedItem from "./PaymentFailedItem.vue";
import LocalStorageService from "@/services/LocalStorage.service";

const route = useRoute();
const receiptId = computed(()=> route.query.receipt);
const status = computed(()=> route.query.status);
// Alert functionality
const { error } = useAlert();

const loading = ref(false);
const PaymentRepository = RepositoryFactory.get('Payment');


const receipt = ref(null);
const errorCode = ref(null);
const getReceipt = async () =>{
  try {
    loading.value = true;
    const { data: { data } } = await PaymentRepository.getPaymentReceipt(route.query.receipt);
    receipt.value = data;
  }catch (e) {
    errorCode.value = e.error.status;
    error('دریافت اطلاعات از سرور با مشکل مواجه شده است.لطفا دوباره تلاش کنید.');
  }finally {
    loading.value = false;
  }
};

onMounted(()=> {
  if(status.value === 'success') LocalStorageService.remove('cart_update_at');
  if(route.query.receipt)getReceipt();
})
</script>

<template>
  <v-row >
    <v-col v-if="status==='success' && receipt" cols="12" lg="4">
      <PaymentInvoice :receipt="receipt" />
    </v-col>
    <v-col v-if="status==='success' && receipt"  cols="12" lg="4">
      <PaymentInstallments :installments="receipt.installments" />
    </v-col>
<!--    <v-col v-else-if="status==='failed'" cols="12" lg="8">-->
<!--      <PaymentFailedItem v-for="item in receipt.transactions" :key="'item-' + item.id" :item="item" class="mt-2" />-->
<!--    </v-col>-->
    <v-col cols="12" lg="4" class="mx-auto">
      <PaymentSuccess v-if="status === 'success' && receipt" />
      <PaymentFailed v-else-if="status === 'failed'" :error="errorCode" />
    </v-col>
  </v-row>
</template>

<style scoped lang="scss">

</style>