<script setup>
import {onMounted} from "vue";
import {useFinance} from "@/composable/finance/useFinance";
import {FINANCE_TYPE} from "@/constants/payment.const";
import {useDateFormatter} from "@/composable/useDate";
import {useNumberFormatter} from "@/composable/useNumberFormatter";
import FinanceEmpty from "@/components/finance/FinanceEmpty.vue";

const {  finance, loading, getFinance } = useFinance();
const HEADERS = [
  {
    title: "مبلغ",
    key: "amount",
    sortable: false,
    align: 'start',
  },
  {
    title: "تاریخ",
    key: "created_at",
    sortable: false,
    align: 'start',
  },
  {
    title: "نحوه واریز",
    key: "is_kart_be_kart",
    sortable: false,
    align: 'start',
  },
]
const { numberFormatter } = useNumberFormatter();
onMounted(()=> {
  getFinance(FINANCE_TYPE.PAYMENTS);
})
</script>

<template>
  <div>
    <v-data-table
        :loading="loading"
        :headers="HEADERS"
        :items="finance.transaction_type_one"
        hover=""
        hide-default-footer
        :items-per-page="-1"
        class="rounded-xl pa-4"

    >
      <template #top>
        <h2 class="font-weight-bold text-subtitle-1 rounded-xl  pb-4 " >واریزی‌ها</h2>
        <v-divider color="primary" />
      </template>
      <template #no-data>
        <FinanceEmpty />
      </template>
      <template #item.amount="{item}">
        {{ numberFormatter(item.amount) }} ریال
      </template>
      <template #item.created_at="{item}">
        {{ useDateFormatter(item.created_at, "LONG") }}
      </template>
      <template #item.is_kart_be_kart="{item}">
        <v-chip rounded="xl" color="primary" v-if="item.is_virtual" class="p-2 m-1">اعتبار هدیه</v-chip>
        <v-chip rounded="xl" color="error" v-else-if="item.amount<0"
                class="p-2 m-1">بازگشت وجه</v-chip>
        <div v-else>
          <v-chip rounded="xl" color="success" v-if="item.gateway_transaction_id" class="p-2 m-1">پرداخت از طریق درگاه بانکی</v-chip>
          <v-chip rounded="xl" color="success" v-else-if="item.is_kart_be_kart" class="p-2 m-1">کارت به کارت</v-chip>
        </div>
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
        :items="finance.transaction_type_zero"
        hover=""
        hide-default-footer
        :items-per-page="-1"
        class="pa-4 rounded-xl mt-10"
    >
      <template #top>
        <h2 class="font-weight-bold text-subtitle-1 rounded-xl pb-4" >پرداختی‌ها</h2>
        <v-divider color="primary" />
      </template>
      <template #no-data>
        <FinanceEmpty />
      </template>
      <template #item.amount="{item}">
        {{ numberFormatter(item.amount) }} ریال
      </template>
      <template #item.created_at="{item}">
        {{ useDateFormatter(item.created_at, "LONG") }}
      </template>
      <template #item.is_kart_be_kart="{item}">
        <v-chip rounded="xl" color="primary" v-if="item.is_virtual" class="p-2 m-1">اعتبار هدیه</v-chip>
        <v-chip rounded="xl" color="error" v-else-if="item.amount<0"
                class="p-2 m-1">بازگشت وجه</v-chip>
        <div v-else>
          <v-chip rounded="xl" color="success" v-if="item.gateway_transaction_id" class="p-2 m-1">پرداخت از طریق درگاه بانکی</v-chip>
          <v-chip rounded="xl" color="success" v-else-if="item.is_kart_be_kart" class="p-2 m-1">کارت به کارت</v-chip>
        </div>
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
  </div>
</template>

<style scoped lang="scss">

</style>