<script setup>
import {ref} from "vue";

/**
 * The search term model.
 * @type {import('vue').Ref<string>}
 */
const search = defineModel();

/**
 * Ref for tracking the loading state.
 * @type {import('vue').Ref<boolean>}
 */
const loading = ref(false);

/**
 * Ref for storing the timer ID used for debouncing.
 * @type {import('vue').Ref<number>}
 */
const _searchTimerId = ref(0);

/**
 * Function to perform debounced search.
 * @function
 * @returns {void}
 */
function searchDebounced () {
  loading.value = true;
  clearTimeout(_searchTimerId.value)
  _searchTimerId.value = setTimeout(() => {
    loading.value = false
  }, 500) /* 500ms throttle */
}
</script>

<template>
  <v-text-field
      v-model="search"
      @input="searchDebounced"
      variant="solo"
      placeholder="جستجوی دوره"
      hide-details
      rounded
      prepend-inner-icon="$mdiMagnify"
  >
    <template #append-inner>
      <v-progress-circular v-if="loading" indeterminate color="primary"></v-progress-circular>
    </template>
  </v-text-field>
</template>

<style scoped lang="scss">

</style>