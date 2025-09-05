<script setup>
import {inject} from "vue";
const newStudent = inject("$newStudentPanel")
console.log(newStudent)
const emits = defineEmits('showOldProduct')

</script>

<template>
  <!-- Shop Year Cards -->
  <v-row class="mb-8" justify="space-evenly" no-gutters>
    <v-col cols="12" md="6" lg="6" class="d-flex justify-center mb-4 mb-md-0">
      <v-card class="pa-8 py-12 d-flex flex-column align-center justify-center rounded-xl mx-2" width="100%"
              style="background: linear-gradient(135deg, #F9A825 0%, #F57C00 100%); color:#fff">
        <v-card-title class="text-center font-weight-bold">
          مشاهده محصولات سال تحصیلی<br>1404-05
        </v-card-title>
        <v-btn class="mt-6 px-8" height="48px" text="مشاهده" append-icon="$mdiChevronLeft" color="white" rounded="xl" :href="newStudent">
        </v-btn>
      </v-card>
    </v-col>
    <v-col cols="12" md="6" lg="6" class="d-flex justify-center">
      <v-card class="pa-8 py-12 d-flex flex-column align-center justify-center rounded-xl  mx-2" width="100%"
              style="background: linear-gradient(135deg, #42A5F5 0%, #1565C0 100%); color:#fff">
        <v-card-title class="text-center font-weight-bold">
          مشاهده محصولات سال تحصیلی<br>1403-04
        </v-card-title>
        <v-btn class="mt-6 px-8" height="48px" text="مشاهده" append-icon="$mdiChevronLeft" @click="emits('showOldProduct', true)" color="white" rounded="xl" >
        </v-btn>
      </v-card>
    </v-col>
  </v-row>
</template>

<style scoped lang="scss">

</style>