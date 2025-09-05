<script setup>
const emits = defineEmits(['next','prev']);
const props = defineProps({
  length: {
    type: [String, Number],
    default: 0,
  },
  availableStep: {
    type: [String, Number],
    default: 0,
  },
})
const model = defineModel();

  const next = ()=>{
    emits('next');
  }
  const prev = ()=>{
    emits('prev')
  };
</script>

<template>
  <div class="stepper mx-auto d-flex flex-column">
    <div class="stepper position-relative ">
      <slot />
    </div>
    <div class="d-flex flex-row justify-space-between align-center w-100">
      <v-btn v-if="!$slots.prev" @click.prevent.stop="prev" variant="text" :disabled="model < 2" rounded="lg">
        <v-icon>$mdiChevronRight</v-icon>
        مرحله قبل
      </v-btn>
      <template v-else>
        <slot name="prev" />
      </template>
      <v-btn v-if="!$slots.next" @click.prevent.stop="next" variant="text" :disabled="model === length || model === availableStep" rounded="lg">
        مرحله بعد
        <v-icon>$mdiChevronLeft</v-icon>
      </v-btn>
      <template  v-else>
        <slot name="next" />
      </template>
    </div>
  </div>
</template>

<style scoped lang="scss">
.stepper {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin: 20px;
  width: 800px;
  max-width: 90%;
}
</style>