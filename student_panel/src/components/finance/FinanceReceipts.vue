<script setup>
import {onMounted} from "vue";
import {useFinance} from "@/composable/finance/useFinance";
import {FINANCE_TYPE} from "@/constants/payment.const";

const {  finance, loading, getFinance } = useFinance();
import {isDateSameOrBefore, useDateFormatter} from "@/composable/useDate";
import {useNumberFormatter} from "@/composable/useNumberFormatter";
import FinanceEmpty from "@/components/finance/FinanceEmpty.vue";

const { numberFormatter } = useNumberFormatter();
onMounted(()=> {
  getFinance(FINANCE_TYPE.TRANSACTIONS);
})

const HEADERS = [
  {
    title: "مبلغ",
    key: "amount",
    sortable: false,
    align: 'start',
  },
  {
    title: "تاریخ",
    key: "expired_at",
    sortable: false,
    align: 'start',
  },
  {
    title: "نحوه واریز",
    key: "is_user_indebted_for_installment",
    sortable: false,
    align: 'start',
  },
]

const HEADERS_PRODUCTS = [
  {
    title: "خریدها",
    key: "product_name",
    sortable: false,
    align: 'start',
  },
  {
    title: "قیمت",
    key: "amount",
    sortable: false,
    align: 'start',
  },
]
const getTransactionProductPrice = (transaction) => {
  return +transaction.amount === 0 && (+transaction.product_type_id === 15 || +transaction.product_type_id === 17) ?
      numberFormatter(transaction.product_price) :
      numberFormatter(transaction.amount)
}
</script>

<template>
  <div>
   <div v-if="finance.length">
     <v-card  v-for="(receipt,index) in finance" :key="'receipt-' + index" :loading="loading" flat border rounded="xl" class="mt-3">

       <v-card-title class="d-flex justify-space-between text-body-1 pa-4 text-wrap">
         <span>  رسید شماره {{ receipt.receipt ? receipt.receipt.id : '' }}</span>
         <span>
       {{ receipt.receipt ? useDateFormatter(receipt.receipt.created_at, "LONG") : ''}}
    </span>
       </v-card-title>
       <v-data-table
           :loading="loading"
           :headers="HEADERS_PRODUCTS"
           :items="receipt.transactions"
           hover=""
           hide-default-footer
           :items-per-page="-1"
           class="rounded-xl pa-4"

       >
         <template #no-data>
           تاحالا تراکنشی انجام ندادی.
         </template>
         <template #item.amount="{item}">
           {{getTransactionProductPrice(item)}} ریال
         </template>

         <template #bottom="{ items }">
           <div class="d-flex align-center justify-end text-primary font-weight-bold">
             مجموع :
             <v-chip label class="mr-1">
               {{ numberFormatter(items.reduce((a,b) => b.amount + a, 0)) }} ریال
             </v-chip>
           </div>
         </template>
       </v-data-table>

       <v-data-table
           :loading="loading"
           :headers="HEADERS"
           :items="receipt.installments"
           hover=""
           hide-default-footer
           :items-per-page="-1"
           class="rounded-xl pa-4"

       >
         <template #top>
           <h2 class="font-weight-bold text-subtitle-1 rounded-xl  pb-4 " >اقساط</h2>
           <v-divider color="primary" />
         </template>
         <template #no-data>
           تاحالا تراکنشی انجام ندادی.
         </template>
         <template #item.amount="{item}">
           {{ numberFormatter(item.amount) }} ریال
         </template>
         <template #item.expired_at="{item}">
           {{ useDateFormatter(item.expired_at, "LONG") }}
         </template>
         <template #item.is_user_indebted_for_installment="{item}">
           <v-chip rounded="xl" v-if="item.is_user_indebted_for_installment" color="warning" size="small">
             پرداخت نشده
           </v-chip>
           <v-chip rounded="xl" v-else-if="isDateSameOrBefore(item.expired_at)">
             اعتبار موجود
           </v-chip>
           <v-chip rounded="xl" v-else color="success" size="small">
             پرداخت شده
           </v-chip>
         </template>
         <template #bottom="{ items }">
           <div class="d-flex align-center justify-end text-primary font-weight-bold">
             مجموع :
             <v-chip label class="mr-1">
               {{ numberFormatter(items.reduce((a,b) => b.amount + a, 0)) }} ریال
             </v-chip>
           </div>
         </template>
       </v-data-table>
     </v-card>
   </div>
   <FinanceEmpty v-else/>
  </div>
</template>

<style scoped lang="scss">

</style>