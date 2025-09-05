<script setup>
  import {useDateFormatter,isDateSameOrBefore} from "../../composable/useDate";
  import {PERSIAN_NUMBERS} from "../../constants/numbersDictionary";
  import {useNumberFormatter} from "../../composable/useNumberFormatter";
  const { numberFormatter } = useNumberFormatter();
  const props = defineProps(['installments']);
  const installmentsHeader = [
    {
      title: "اقساط",
      key: "id",
      sortable: false,
      align: 'start',
    },
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
      title: "وضعیت",
      key: "is_user_indebted_for_installment",
      sortable: false,
      align: 'start',
    },
  ]
</script>

<template>
 <v-card flat border rounded="xl">
   <v-data-table v-if="$vuetify.display.mdAndUp"
                 :items="installments"
                 :headers="installmentsHeader"
                 hover=""
                 hide-default-footer
                 :items-per-page="-1"
   >
     <template v-slot:bottom></template>
     <template #no-data>
       برای این دوره جلسه‌ای وجود ندارد
     </template>
     <template #item.id="{item, index}">
       <span v-if="index !== 0">قسط</span> <span class="text-wrap"> {{ PERSIAN_NUMBERS[index] }} </span>
     </template>
     <template #item.name="{item, index}">
       <span class="font-weight-bold text-wrap"> {{ PERSIAN_NUMBERS[index] }} </span> {{ item.name }}
     </template>
     <template #item.amount="{item}">
       {{ numberFormatter(item.amount) }} <small class="text-caption text-wrap"> ریال </small>
     </template>
     <template #item.expired_at="{item}">
       {{ useDateFormatter(item.holding_date) }}
     </template>
     <template #item.is_user_indebted_for_installment="{item}">
        <v-chip  v-if="item.is_user_indebted_for_installment" rounded="xl" color="warning" size="small">
          پرداخت نشده
        </v-chip>
       <v-chip v-else-if="isDateSameOrBefore(item.expired_at)" rounded="xl">
         اعتبار موجود
       </v-chip>
       <v-chip v-else color="success" size="small" rounded="xl">
         پرداخت شده
       </v-chip>
     </template>
   </v-data-table>
 </v-card>
</template>

<style scoped lang="scss">

</style>