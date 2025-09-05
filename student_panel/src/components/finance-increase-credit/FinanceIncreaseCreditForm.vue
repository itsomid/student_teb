<script setup>
import {computed, onMounted, ref} from "vue";
import {useStore} from "vuex";
import {useUtils} from "@/composable/useUtils";
import {useAlert} from "../../composable/useAlert";
import {useRoute} from "vue-router";
import {usePaymentAddress} from "@/composable/usePaymentAddress";

const { error } = useAlert();
const { PAYMENT_GATEWAY_CREDIT } = usePaymentAddress();

const errorMessage = ref();
const {extractNumbersOrReturnZero} = useUtils();
const store = useStore();
const route = useRoute();
const amount = ref('');
const userCredit = computed(()=> store.getters['userStore/credit']);
const user = computed(() => store.getters['userStore/userData']);

function numberConvertor(number) {
  number = Math.abs(number)
  return Intl.NumberFormat('en').format(number)
}
function inputAmountConvertor(number) {
  errorMessage.value = /^[0-9]*$/.test(number.replaceAll(',', '')) || 'مبلغ باید به عدد وارد شود'
  if(errorMessage.value.length) error(errorMessage.value);
  number = extractNumbersOrReturnZero(number);
  number = number.replaceAll(',', '');
  number = number.replace(/[^0-9,]/g, '');
  if (number >= 0) {
    amount.value = new Intl.NumberFormat('en').format(number);
  }
}
function changeToDefaultNumber() {
  amount.value = amount.value.replace(/[^0-9,]/g, '')
  amount.value = amount.value.replaceAll(',', '')
}

onMounted(()=>{
  amount.value = route.params.amount ?  String(route.params.amount) : ''
  console.log(user.value)
  if (amount.value){
    inputAmountConvertor(amount.value)
  }
})

</script>

<template>
  <div>
    <div class="row">
      <div class="col-md-12" v-if="userCredit < 0">
        <div class="alert alert-card alert-danger" role="alert">
          <v-alert color="error" rounded="xl" variant="tonal" class="text-wrap mt-6">
            حساب کاربری شما دارای اعتبار منفی شده است (به تاریخ سررسید قسط ها توجه کنید - برای بررسی قسط ها به امور مالی مراجعه کنید)، لطفا قبل از ادامه کار مبلغ {{ numberConvertor(userCredit) }} ریال به اعتبار خود بیافزایید
          </v-alert>
        </div>
      </div>
      <div class="col-md-12">
        <v-card class="pa-4 mt-4 d-flex flex-column align-center" rounded="lg" flat border>
          <v-card-title>
            <span class="text-20 text-wrap">میزان اعتبار مورد نظر (به ریال وارد شود):</span>
          </v-card-title>
          <v-alert width="584" max-width="100%" icon="$warning" rounded="lg" style="background: #FFF8B5; color: #CC4E00; border:1px solid #FFFDD1" variant="flat" :class="[$vuetify.display.mdAndDown? 'text-caption':'text-capitalize']" class=" mx-auto mt-4 mb-6 font-weight-bold pa-4 text-right">
           <span class="font-weight-medium ">
             کاربر عزیز!
             <br>
              شما با حساب کاربری به نام
              <strong>{{user.name}}</strong>

             و شماره همراه
              <strong>{{user.mobile}}</strong>
               در حال افزایش اعتبار خود هستید.
           </span>
          </v-alert>
          <div class="d-flex align-items-center">
            <form :action="PAYMENT_GATEWAY_CREDIT" method="post" class="form-group" @submit="changeToDefaultNumber()">
              <div class="d-flex flex-wrap flex-row justify-center" style="gap: 8px">
                <v-text-field
                    v-model="amount"
                    min-width="250"
                    variant="outlined"
                    color="primary"
                    rounded="lg"
                    class=""
                    type="text"
                    name="amount"
                    @keyup="inputAmountConvertor(amount)"
                />
                <v-btn :disabled="amount == 0 || amount.length === 0" size="x-large" color="primary" type="submit" rounded="lg"  > پرداخت از طریق درگاه</v-btn>
              </div>
            </form>
          </div>
        </v-card>
      </div>
    </div>
  </div>
</template>

<style scoped lang="scss">

</style>