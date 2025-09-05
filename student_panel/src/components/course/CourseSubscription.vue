<script setup>
import { useDateFormatter, isDateSameOrBefore } from "@/composable/useDate";
const props = defineProps(["endDate"]);
const endSubscriptionDate = import.meta.env.VITE_APP_END_SUBSCRIPTION_DATE
</script>

<template>
  <v-row class="mb-4" v-if="endDate">
    <v-col cols="12">
      <v-row>
        <v-col cols="12">
          <v-alert
              v-if="!isDateSameOrBefore(props.endDate, endSubscriptionDate)"
              type="success"
          >
            شما تا پایان سال تحصیلی اشتراک این دوره را تهیه کرده اید و به آن دسترسی دارید.
          </v-alert>
          <v-alert
              v-else
              type="success"
          >
            شما تا تاریخ
            {{ useDateFormatter(props.endDate, "LONG") }}
            اشتراک این دوره را تهیه کرده اید و به آن دسترسی دارید.
          </v-alert>

        </v-col>
      </v-row>
    </v-col>
  </v-row>
</template>

<style scoped lang="scss">

</style>