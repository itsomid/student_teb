<script setup>

import {PRODUCT_STATUS} from "@/constants/product";
import {ClassNumberDictionary} from "@/constants/classNumberDictionary";
import {useDateFormatter} from "@/composable/useDate";
import { useDisplay } from 'vuetify'
import {useUrl} from "@/composable/useUrl";

const props = defineProps(['classes', 'loading', 'productStatus'])

const { smAndDown } = useDisplay()
const { defaultImageUrlBuilder } = useUrl();
const classHeaders = [
  {
    title: "عنوان جلسه",
    key: "name",
    sortable: false,
    align: 'start',
  },
  {
    title: "تاریخ برگزاری",
    key: "holding_date",
    sortable: false,
    align: 'start',
  },
  {
    title: "مشاهده",
    key: "actions",
    sortable: false,
    align: 'start',
  },
]
</script>

<template>
  <div>
    <v-data-table v-if="$vuetify.display.mdAndUp"
                  :items="classes"
                  :headers="classHeaders"
                  hover=""
                  hide-default-footer
                  :items-per-page="-1"
                  :loading="loading"
    >
      <template v-slot:bottom></template>
      <template v-slot:headers></template>
      <template #no-data>
        <div class="d-flex flex-column justify-center align-center pa-4">
          <v-img max-width="64" width="64" :src="defaultImageUrlBuilder('assets/images/empty/empty-state-content.png')"/>
          <p class="font-weight-bold">محتوایی برای نمایش نیست</p>
        </div>
      </template>
      <template #item.name="{item, index}">
        <span class="font-weight-bold text-wrap"> {{ ClassNumberDictionary[index] }} </span> - {{ item.name }}
      </template>
      <template #item.holding_date="{item}">
        <v-chip prepend-icon="$mdiClockOutline" label rounded="lg" class="d-flex flex-grow-1 justify-center" variant="tonal">
          {{ useDateFormatter(item.holding_date, "LONG") }}
        </v-chip>
      </template>
      <template #item.actions="{item}">
        <v-btn rounded variant="outlined" :disabled="productStatus !== PRODUCT_STATUS.PURCHASED && !item.is_free" color="primary" :to="{ name: 'show-class', params: { id: item.class_id } }"
               class="rounded-lg">
          ورود به جلسه
          <v-icon>$mdiPlayOutline</v-icon>
        </v-btn>
      </template>
    </v-data-table>
    <div v-else>
      <template v-for="(item,index) in classes">
        <div class="d-flex flex-column text-secondary pa-4">
          <div class="d-flex flex-row justify-space-between align-center mt-2">
            <span class="flex-shrink-1 ml-3 font-weight-bold">{{ ClassNumberDictionary[index] }}</span>
            <span class="">
              <v-chip size="small" prepend-icon="$mdiClockOutline" label rounded="lg" class="d-flex flex-grow-1 justify-center" variant="tonal">
                {{ useDateFormatter(item.holding_date, "LONG") }}
              </v-chip>
            </span>
          </div>
          <div class="mt-3 font">
            {{ item.name}}
          </div>
          <div class="mt-3">
            <v-btn block rounded variant="outlined" :disabled="productStatus !== PRODUCT_STATUS.PURCHASED" color="primary" :to="{ name: 'show-class', params: { id: item.class_id } }"
                   class="rounded-lg">
              ورود به جلسه
              <v-icon>$mdiPlayOutline</v-icon>
            </v-btn>
          </div>
        </div>
        <v-divider color="secondary-darken-5" class="mt-4" />
      </template>
    </div>
  </div>
</template>

<style scoped lang="scss">

</style>
