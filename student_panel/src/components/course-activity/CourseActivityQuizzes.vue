<script setup>
const props = defineProps(['quiz']);
const HEADERS = [
  {
    title: "جلسه",
    key: "name",
    sortable: false,
    align: 'start',
  },
  {
    title: "نمره",
    key: "score",
    sortable: false,
    align: 'start',
  },
]
</script>

<template>
  <v-card rounded class="rounded-xl" flat border >
    <v-data-table
        :items="quiz.chart"
        :headers="HEADERS"
        hover=""
        hide-default-footer
        :items-per-page="-1"
    >
      <template #top>
        <h2 class="font-weight-bold text-subtitle-1 rounded-xl rounded-b border-b pa-4 " >نمرات آزمون کلاسی</h2>
      </template>
      <template v-slot:bottom></template>
      <template #no-data>
        برای شما آزمونی وجود ندارد.
      </template>
      <template #item.score="{item}">
        <span v-if="item.score">{{item.score}} %</span>
        <span v-if="!item.score && item.quiz_done">پاسخنامه هنوز تصحیح نشده است</span>
        <span v-if="!item.score && !item.quiz_done">عدم شرکت در آزمون</span>
      </template>
    </v-data-table>
  </v-card>
</template>

<style scoped lang="scss">

</style>