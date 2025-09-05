<script setup>
import {useNumberFormatter} from "@/composable/useNumberFormatter";


const props = defineProps(['sumPrice', 'vat', 'vatPercentage', 'final_price' ,'userCredit','isInstallment']);
const { numberFormatter } = useNumberFormatter();

</script>

<template>
  <div class="d-flex flex-column text-body-1">
    <v-slide-x-reverse-transition mode="out-in" leave-absolute hide-on-leave group>
    <div key="sumPrice" class="d-flex flex-row justify-space-between align-center mt-4">
      <span class="text-secondary">مجموع:
      </span>
      <strong>{{ numberFormatter(sumPrice) }} <span class="text-caption">ریال</span> </strong>
    </div>
    <div key="vat" class="d-flex flex-row justify-space-between align-center mt-4">
      <span class="text-secondary">حق پخش: <span class="text-caption">({{ vatPercentage }} ٪مبلغ کل)</span></span>
      <strong>{{ numberFormatter(vat) }} <span class="text-caption">ریال</span></strong>
    </div>

    <div key="final_price" class="d-flex flex-row justify-space-between align-center mt-4">
      <span class="text-secondary">مبلغ نهایی:</span>
      <strong>{{ numberFormatter(final_price) }} <span class="text-caption">ریال</span></strong>
    </div>
    <div key="userCredit" class="d-flex flex-row justify-space-between align-center mt-4">
      <span class="text-secondary"> اعتبار شما</span>
      <strong>{{ numberFormatter(userCredit) }} <span class="text-caption">ریال</span></strong>
    </div>
    </v-slide-x-reverse-transition>
  </div>
</template>

<style scoped lang="scss">

</style>