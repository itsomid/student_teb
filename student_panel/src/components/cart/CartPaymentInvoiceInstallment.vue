<script setup>
import {useNumberFormatter} from "@/composable/useNumberFormatter";
import {useDateFormatter} from "../../composable/useDate";
import {PERSIAN_NUMBERS} from "../../constants/numbersDictionary";

const props = defineProps(['installments']);
const { numberFormatter } = useNumberFormatter()
</script>

<template>
  <div class="d-flex flex-column text-body-1">
    <div class="d-flex flex-row justify-space-between align-center mt-4" v-for="(item,index) in installments">
      <span class="text-secondary">
        <span v-if="index !== 0">قسط</span>
        {{ PERSIAN_NUMBERS[index]}}:
        <span v-if="index === 0">همین الان</span>
        <span v-else>{{ useDateFormatter(item.date)}}</span>
      </span>
      <strong>{{ numberFormatter(item.amount) }} <span class="text-caption">ریال</span> </strong>
    </div>
  </div>
</template>

<style scoped lang="scss">

</style>