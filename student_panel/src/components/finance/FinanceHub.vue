<script setup>
import {computed, defineAsyncComponent, ref, watch} from "vue";
import ClLoading from "@/components/base/ClLoading.vue";
import ClError from "@/components/app/ClError.vue";
import {useStore} from "vuex";

const props = defineProps({
  data: {
    type: Object,
    required: false,
  },
});

const FinanceInstallments = defineAsyncComponent({
  loader: () => import("./FinanceInstallments.vue"),
  loadingComponent: ClLoading,
  delay: 0,
  errorComponent: ClError,
  timeout: 3000,
});

const FinanceReceipts = defineAsyncComponent({
  loader: () => import("./FinanceReceipts.vue"),
  loadingComponent: ClLoading,
  delay: 0,
  errorComponent: ClError,
  timeout: 3000,
});

const FinancePayments = defineAsyncComponent({
  loader: () => import("./FinancePayments.vue"),
  loadingComponent: ClLoading,
  delay: 0,
  errorComponent: ClError,
  timeout: 3000,
});


const items = [
  {
    id: 1,
    title: "رسیدهای‌ خرید",
    component: FinanceReceipts,
    name: "FinanceReceipts",
  },
  {
    id: 2,
    title: "واریزی و پرداختی",
    component: FinancePayments,
    name: "FinancePayments",
  },
  {
    id: 3,
    title: "اقساط",
    component: FinanceInstallments,
    name: "FinanceInstallments",
  },
];

const tabs = ref(1);

</script>

<template>
  <v-tabs
      v-model="tabs"
      :height="$vuetify.display.mdAndUp ? 60 : ''"
      color="primary"
      class="text-secondary"
      align-tabs="center"
      fixed-tabs

      mandatory
      :grow="$vuetify.display.smAndDown"
  >
    <v-tab
        density="compact"
        v-for="item in items"
        variant="text"
        :value="item.id"
        class="flex-shrink-1"


        :class="{'px-0' : $vuetify.display.smAndDown}"
    >
      {{ item.title }}
    </v-tab>
  </v-tabs>
  <v-divider />
  <v-window disabled v-model="tabs" class="h-100 mt-4 px-3">
    <v-window-item
        v-for="(item, index) in items"
        :key="item.id"
        :value="item.id"
        style="height: calc(100% - 60px)"
    >
     <v-container>
       <component :key="'finance-hub-' + index" :is="item.component"  />
     </v-container>
    </v-window-item>
  </v-window>
</template>

<style scoped lang="scss">

</style>