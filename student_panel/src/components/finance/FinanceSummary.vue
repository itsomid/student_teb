<script setup>
import { useUrl } from "../../composable/useUrl";
import { onMounted } from "vue";
import { useFinance } from "../../composable/finance/useFinance";
import {useNumberFormatter} from "@/composable/useNumberFormatter";

const { defaultImageUrlBuilder } = useUrl();
const {  financeBrief, loading, getFinanceBrief } = useFinance();
const { numberFormatter } = useNumberFormatter();
onMounted(() => {
  getFinanceBrief();
});
</script>

<template>
  <v-sheet color="transparent" min-height="200" class="py-16">
    <v-card border :loading="loading" width="100%" max-width="900" min-height="120" rounded="xl" variant="tonal" color="" class="pa-7 d-flex flex-wrap justify-space-between align-center mx-auto" style="gap: 8px">
      <div class="d-flex  align-center" :style="{width : $vuetify.display.lgAndUp ? '60px' : '100%'}">
        <v-img max-width="60" width="60" :src="defaultImageUrlBuilder('assets/images/finance/wallet.png')"/>
      </div>
      <div class="d-flex flex-row flex-md-row flex-lg-column flex-xl-column justify-space-between mx-3 text-primary" :style="{width : $vuetify.display.lgAndUp ? '130px' : '100%'}">
        <span class="font-weight-bold">اعتبار:</span>
        <span >
          {{ numberFormatter(financeBrief.credit)}} ریال
        </span>
      </div>
      <v-divider v-if="$vuetify.display.mdAndDown" />
      <div class="d-flex flex-row flex-md-row flex-lg-column flex-xl-column justify-space-between" :style="{width : $vuetify.display.lgAndUp ? '130px' : '100%'}">
        <span class="font-weight-bold">واریزی‌ها:</span>
        <span class="font-weight-normal">
          {{ numberFormatter(financeBrief.total_credit_amount) }} ریال
        </span>
      </div>
      <v-divider v-if="$vuetify.display.mdAndDown" />
      <div class="d-flex flex-row flex-sm-column flex-md-row flex-lg-column flex-xl-column justify-space-between" :style="{width : $vuetify.display.lgAndUp ? '130px' : '100%'}">
        <span class="font-weight-bold">پرداختی‌ها:</span>
        <span>
          {{ numberFormatter(financeBrief.total_buy_amount) }} ریال
        </span>
      </div>
      <v-divider v-if="$vuetify.display.mdAndDown" />
      <div class="d-flex flex-row flex-md-row flex-lg-column flex-xl-column justify-space-between" :style="{width : $vuetify.display.lgAndUp ? '130px' : '100%'}">
        <span class="font-weight-bold">بدهی‌ها:</span>
        <span>
          {{ numberFormatter(financeBrief.total_debt) }} ریال
        </span>
      </div>
      <v-divider v-if="$vuetify.display.mdAndDown" />
      <div class="d-flex flex-grow-1 justify-end mt-6 mt-lg-0">
        <v-btn disabled rounded="lg" size="x-large" append-icon="$mdiPlus" flat color="primary">
          شارژ حساب
        </v-btn>
      </div>
    </v-card>
  </v-sheet>
</template>

<style scoped lang="scss">
  //.brief-item {
  //  min-width: 130px;
  //}
</style>