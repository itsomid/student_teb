<script setup>
const props = defineProps(['title', 'subtitle']);
const emits = defineEmits(['confirm']);
const dialog = defineModel({default:false});

const confirm = ()=> {
  emits('confirm');
  dialog.value = false;
}
</script>

<template>
  <v-dialog
      v-model="dialog"
      width="400"
      max-width="100%"
  >
    <v-card
        rounded="xl"
        flat
        border
        :title="title"
        :subtitle="subtitle"
        max-width="100%"
        v-bind="$attrs"
    >
      <slot />
      <v-card-actions>
        <v-btn variant="tonal" rounded="xl" flat color="primary" @click="confirm" class="px-3">بله مطمئن هستم</v-btn>
        <v-btn variant="text" rounded="xl" flat color="error" @click="dialog = false">فعلا نه!</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<style scoped lang="scss">

</style>