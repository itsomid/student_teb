<script setup>
import { useDateFormatter } from "@/composable/useDate";

const emits = defineEmits(['update-valle'])
/**
 * Props received by the component.
 * @typedef {Object} QuizzesProps
 * @property {Array} quizzes - List of quizzes.
 * @property {boolean} loading - Flag indicating whether data is loading.
 */

const props = defineProps(['quizzes', 'loading'])

/**
 * Define props for the component.
 * @type {QuizzesProps}
 */

/**
 * Header configuration for the "Status" column.
 * @type {Object}
 * @property {string} title - Column title.
 * @property {string} key - Column key.
 * @property {boolean} sortable - Whether the column is sortable.
 * @property {string} align - Alignment of column content.
 */
const quizeHeaders = [
  {
    title: "عنوان آزمون",
    key: "examName",
    sortable: false,
    align: 'start',
  },
  {
    title: "تاریخ برگزاری",
    key: "examDate",
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
  <!-- Wrapper for hover effect -->
  <v-hover>
    <template v-slot:default="{ isHovering, props }">
      <!-- Card component with hover effect -->
      <v-card rounded class="rounded-xl" v-bind="props" :elevation="isHovering ? 8 : 3">
        <!-- Data table component -->
        <v-data-table
            class="rounded-xl"
            :items="quizzes"
            :headers="quizeHeaders"
            :loading="loading"
            hover=""
            :calculate-widths="false"
            :items-per-page="-1"
            item-class="pa-3"
        >
          <!-- Slot to add content above the table. -->
          <template #top>
            <h2 class="font-weight-bold text-subtitle-1 rounded-xl rounded-b-0 pa-4 border-b">آزمون‌ها</h2>
          </template>

          <!-- Slot for custom rendering of a data table footer. -->
          <template v-slot:bottom></template>

          <!-- Slot for displaying message when there's no data. -->
          <template #no-data>
            <div class="d-flex flex-column pa-4 justify-center align-center">
              <strong class="text-error">
                در حال به روزرسانی لیست آزمون‌ها... <br />تا چند دقیقه دیگه آزمون‌هات نمایش داده می‌شه
              </strong>

              <v-btn @click="emits('update-valle')" rounded="lg" color="primary" flat class="mt-3" max-width="120" :disabled="loading" :loading="loading">
                تلاش مجدد
              </v-btn>
            </div>
          </template>

          <!-- Slot for custom rendering of 'holding_date' column. -->
          <template #item.examDate="{ item }">
            <div v-if="item.examDate">{{ useDateFormatter(item.examDate, "LONG") }}</div>
          </template>

          <!-- Slot for custom rendering of 'actions' column. -->
          <template #item.actions="{ item }">
            <v-btn variant="text" color="primary" :href="item.valeLink" target="_blank">
                <span v-if="!item.joined && !item.processed">ورود به آزمون</span>
                <span v-else-if="item.processed">مشاهده نتیجه</span>
                <span v-else>شما آزمون داده اید</span>
            </v-btn>
          </template>
        </v-data-table>
      </v-card>
    </template>
  </v-hover>
</template>

<style scoped lang="scss">

</style>