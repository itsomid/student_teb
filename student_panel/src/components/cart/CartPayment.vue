<script setup>
import {computed, onMounted, ref} from "vue";
import {PAYMENT_TYPE} from "@/constants/payment.const";
import {useStore} from "vuex";
import ClLoading from "@/components/base/ClLoading.vue";
import CartPaymentInvoice from "@/components/cart/CartPaymentInvoice.vue";
import CartPaymentInvoiceInstallment from "@/components/cart/CartPaymentInvoiceInstallment.vue";
import CartDiscount from "@/components/cart/CartDiscount.vue";
import {useNumberFormatter} from "../../composable/useNumberFormatter";
import RepositoryFactory from "@/repository/RepositoryFactory";
import {useAlert} from "@/composable/useAlert";
import CartRepository from "@/repository/CartRepository";
import {usePaymentAddress} from "@/composable/usePaymentAddress";

  const { PAYMENT_GATEWAY } = usePaymentAddress();
  const props = defineProps({
    invoice: {
      type: Object
    },
    installments: {
      type: Object
    }
  })

 const { error,warning }          = useAlert();
 const store              = useStore();
 const PaymentRepository  = RepositoryFactory.get("Payment");
 const loading            = ref(false);
 const tab                = ref(PAYMENT_TYPE.ONLINE);
 const payment            = ref(null);

  const isActive = (type)=> {
    return tab.value === type;
  }

  const userCredit = computed(()=> store.getters['userStore/credit']);
  const { numberFormatter } = useNumberFormatter();

const changePaymentMethod = async (type) => {
  try {
    loading.value = true;
    const { data: { data } } = await PaymentRepository.changePaymentMethod({is_installment: type});
    await store.dispatch('cartStore/updateCart', data);
    store.commit('cartStore/SET_NON_INSTALLMENT_PRODUCTS', []);
    tab.value = type;
  }catch(e) {
    store.commit('cartStore/SET_NON_INSTALLMENT_PRODUCTS', e.error.validationErrors.products)
    error('دوره (ها)ی مشخص شده رو نمی‌تونی قسطی بخری.')
  }finally {
    loading.value = false;
  }
}

const goToPayment = async ()=> {
  loading.value = true;
  try{
    const { data: { data } } = await CartRepository.getUserCart();
    await store.dispatch('cartStore/updateCart',data);
    if(data.price_changed) {
      warning('قیمت یک یا چند مورد از اقلام موجود در سبد خرید شما تغییر کرده است.')
      return
    }
   if(props.invoice.conditions[0]) {
     await CartRepository.checkDiscount({coupon: props.invoice.conditions[0]});
     const { data: { data } } = await CartRepository.getUserCart();
     await store.dispatch('cartStore/updateCart',data);
     payment.value.submit();
   }else payment.value.submit();
  }catch (e) {
    if (e.error.status === 409 || e.error.status === 406) {
      error(e.error.validationErrors.message + ' از سبد خرید خود حذف کنید.');
    } else {
      error('کد تخفیف معتبر نمیباشد. از سبد خرید خود حذف کنید.');
    }
  }finally {
    loading.value = false;
  }
};

onMounted(()=>{
  if(props.installments) changePaymentMethod(PAYMENT_TYPE.INSTALLMENTS);
})
</script>

<template>
  <div>
    <ClLoading v-if="!invoice"></ClLoading>

    <v-card  v-else rounded="xl" border flat>
      <v-card-title>
        <div class="rounded-lg d-flex justify-center my-2 mx pa-1 border">
          <v-btn
              size="large"
              @click.prevent="changePaymentMethod(PAYMENT_TYPE.ONLINE)"
              class="flex-grow-1"
              rounded="lg"
              color="secondary"
              :variant="isActive(PAYMENT_TYPE.ONLINE) ? 'tonal' : 'plain'"
              flat
          >
            <v-icon :color="isActive(PAYMENT_TYPE.ONLINE) ? 'primary' : ''" class="ml-1">$mdiCash</v-icon>
            نقدی
          </v-btn>
          <v-btn
              size="large"
              @click.prevent="changePaymentMethod(PAYMENT_TYPE.INSTALLMENTS)"
              class="flex-grow-1"
              rounded="lg"
              color="secondary"
              :variant="isActive(PAYMENT_TYPE.INSTALLMENTS) ? 'tonal' : 'text'"
              flat
          >
            <v-icon :color="isActive(PAYMENT_TYPE.INSTALLMENTS) ? 'primary' : ''" class="ml-1">
              $mdiListBoxOutline
            </v-icon>
            قسطی
          </v-btn>
        </div>
      </v-card-title>
      <v-card-text>
        <strong>صورت حساب</strong>
        <CartPaymentInvoice
            :sum-price="invoice.sum_price"
            :vat="invoice.vat"
            :vat-percentage="invoice.vat_percentage"
            :is-installment="isActive(PAYMENT_TYPE.INSTALLMENTS)"
            :final_price="invoice.final_price"
            :user-credit="userCredit"
        />
        <v-expand-transition  mode="in-out" leave-absolute hide-on-leave  >
          <CartPaymentInvoiceInstallment v-if="isActive(PAYMENT_TYPE.INSTALLMENTS)" :installments="installments"/>
        </v-expand-transition>
      </v-card-text>
      <v-card-text>
        <CartDiscount />
        <v-alert  variant="tonal" rounded="lg" color="success">
          <div class="d-flex flex-row justify-space-between align-center font-weight-bold">
            <span>مبلغ قابل پرداخت:</span>
            <span> {{ numberFormatter(invoice.payable_for_bank)}} ریال</span>
          </div>
        </v-alert>
      </v-card-text>
      <v-card-actions class="px-4 pb-4">
        <form class="w-100" :action="PAYMENT_GATEWAY" method="post" ref="payment">
          <v-btn rounded="lg" size="x-large" block variant="tonal" flat color="primary" @click="goToPayment">
            <v-icon class="ml-1">$mdiCreditCardCheckOutline</v-icon>
            ثبت سفارش و پرداخت
          </v-btn>
        </form>
      </v-card-actions>
    </v-card>
  </div>
</template>

<style scoped lang="scss">

</style>