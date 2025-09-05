<script setup>
  import {useNumberFormatter} from "../../composable/useNumberFormatter";

  const props = defineProps(['receipt']);
  const { numberFormatter } = useNumberFormatter();
  const getTransactionProductPrice = (transaction) => {
    return +transaction.amount === 0 && (+transaction.product_type_id === 15 || +transaction.product_type_id === 17) ?
        numberFormatter(transaction.product_price) :
        numberFormatter(transaction.amount)
  }
</script>

<template>
  <v-card flat border rounded="xl" class="pa-4">
    <div v-for="item in receipt.transactions" class="d-flex flex-row justify-space-between align-center mt-2">
      <span class="text-caption">
        {{ item.product_name}}
      </span>
      <span class="font-weight-bold">
         {{getTransactionProductPrice(item)}} <small class="text-caption">ریال</small>
      </span>
    </div>
<!--    <div class="d-flex flex-row justify-space-between align-center mt-2">-->
<!--      <span class="text-caption">-->
<!--        سود شما از تخفیف-->
<!--      </span>-->
<!--      <span class="font-weight-bold">-->
<!--        <small class="text-caption">ریال</small>-->
<!--      </span>-->
<!--    </div>-->

<!--    <div class="d-flex flex-row justify-space-between align-center mt-2">-->
<!--      <span class="text-caption">-->
<!--        ارزش افزوده هر قسط-->
<!--      </span>-->
<!--      <span class="font-weight-bold">-->
<!--        <small class="text-caption">ریال</small>-->
<!--      </span>-->
<!--    </div>-->

    <div class="d-flex flex-row justify-space-between align-center mt-2">
      <span class="text-caption">
        مبلغ نهایی
      </span>
      <span class="font-weight-bold">
        {{ numberFormatter(receipt.sum_purchased) }} <small class="text-caption">ریال</small>
      </span>
    </div>
  </v-card>
</template>

<style scoped lang="scss">

</style>