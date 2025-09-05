<script setup>

import FinanceSummary from "./FinanceSummary.vue";
import FinanceHub from "@/components/finance/FinanceHub.vue";
import {computed, onMounted} from "vue";
import {useRoute} from "vue-router";
import {useAlert} from "@/composable/useAlert";
import {useNumberFormatter} from "@/composable/useNumberFormatter";
const route = useRoute();
const { error } = useAlert();
const { numberFormatter } = useNumberFormatter();
const status = computed(()=> route.query?.status);
onMounted(()=>{
  if(route.query.status && route.query.status === 'failed') error(route.query?.message);
})
</script>

<template>
  <v-row class="no-gutters">
    <v-col v-if="status && status === 'success' " cols="12">
      <v-alert type="success" variant="tonal" rounded="xl">
        افزایش اعتبار به میزان <strong>{{ numberFormatter(Number(route.query.price)) }}</strong> ریال با موفقیت انجام شد.
      </v-alert>
    </v-col>
    <v-col cols="12">
      <FinanceSummary />
    </v-col>
    <v-col cols="12">
      <FinanceHub />
    </v-col>
  </v-row>
</template>

<style scoped lang="scss">

</style>