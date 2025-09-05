<script setup>
import DialogContent from '@/components/base/DialogContent.vue'
import { ref } from 'vue'
let dialog = ref(false)
</script>
<template>
  <v-dialog v-model="dialog" persistent width="1024">
    <template v-slot:activator="{ props }">
      <v-btn @click="dialog" btn color="primary" v-bind="props"> Open Dialog </v-btn>
    </template>
    <DialogContent>
      <template v-slot:title>
        <span>title</span>
      </template>
      <template v-slot:body> <v-container>dialog content </v-container> </template>
      <template v-slot:action>
        <v-spacer></v-spacer>
        <v-btn @click="dialog = false" color="info">بستن </v-btn>
        <v-btn color="info"> ذخیره </v-btn>
      </template>
    </DialogContent>
  </v-dialog>
</template>
<style scoped></style>
