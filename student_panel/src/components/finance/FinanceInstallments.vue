<script setup>
import {computed, onMounted} from "vue";
import {useFinance} from "@/composable/finance/useFinance";
import {FINANCE_TYPE} from "@/constants/payment.const";
import {isDateSameOrBefore, useDateFormatter} from "@/composable/useDate";
import {useNumberFormatter} from "@/composable/useNumberFormatter";
import FinanceEmpty from "@/components/finance/FinanceEmpty.vue";

const { numberFormatter } = useNumberFormatter();
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

onMounted(()=> {
  getFinance(FINANCE_TYPE.INSTALLMENTS);
})

const installments = computed(()=> Array.isArray(finance.value) ? finance.value : [])
</script>

<template>
  <div>
    <v-data-table
        :loading="loading"
        :headers="HEADERS"
        :items="installments"
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
      <template #item.expired_at="{item}">
        {{ useDateFormatter(item.expired_at, "LONG") }}
      </template>
      <template #item.is_user_indebted_for_installment="{item}">
        <v-chip v-if="item.is_user_indebted_for_installment" color="warning" size="small" rounded="xl">
          پرداخت نشده
        </v-chip>
        <v-chip v-else-if="isDateSameOrBefore(item.expired_at)" rounded="xl">
          اعتبار موجود
        </v-chip>
        <v-chip v-else color="success" size="small" rounded="xl">
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
  </div>
</template>

<style scoped lang="scss">

</style>