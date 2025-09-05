<script setup>
import { useDateFormatter } from "@/composable/useDate";
import {inject} from "vue";


/**
 * Props received by the component.
 * @typedef {Object} QuizzesProps
 * @property {Array} quizzes - List of quizzes.
 * @property {boolean} loading - Flag indicating whether data is loading.
 */

const props = defineProps(['quizzes', 'loading', 'isFortik'])
const $fourtikBaseUrl = inject('$fourtik');
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
    title: "وضعیت",
    key: "state",
    sortable: false,
    align: 'start',
  },
  {
    title: "عنوان آزمون",
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
            برای شما آزمونی وجود ندارد
          </template>

          <!-- Slot for custom rendering of 'state' column. -->
          <template #item.state>
            <i class="icon-CL_lock-keyhole-open text-25"></i>
          </template>

          <!-- Slot for custom rendering of 'holding_date' column. -->
          <template #item.holding_date="{ item }">
            <div v-if="item.holding_date_from">{{ useDateFormatter(item.holding_date_from, "LONG") }} تا {{ useDateFormatter(item.holding_date_to, "LONG") }}</div>
          </template>

          <!-- Slot for custom rendering of 'actions' column. -->
          <template #item.actions="{ item }">
            <div v-if="!isFortik">
              <div v-if="!item.has_answer_sheet">
                <router-link v-if="item.is_active" :to="{ name: 'quiz', params: { quiz_id: item.quiz_id } }" class="btn btn-panel btn-main m-1 my-3">
                  نمایش آزمون کلاسی
                </router-link>
                <a v-else class="btn btn-panel btn-main m-1 my-3" disabled="disabled">نمایش آزمون کلاسی</a>
              </div>
              <div v-else>
                <router-link :to="{ name: 'answer-sheet', params: { quiz_id: item.quiz_id } }" class="btn btn-panel btn-main m-1 my-3">
                  نمایش پاسخنامه
                </router-link>
              </div>
            </div>
            <v-btn v-else color="info" class="my-1" :href="$fourtikBaseUrl" target="_blank">
              ورود/نتایج آزمون
            </v-btn>
          </template>
        </v-data-table>
      </v-card>
    </template>
  </v-hover>
</template>

<style scoped lang="scss">

</style>