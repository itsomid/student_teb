<script setup>
import {computed, onMounted, ref} from "vue";
import {useRoute, useRouter} from "vue-router";

/**
 * Options for configuring the search input component.
 * @typedef {Object} SearchOptions
 * @property {string} variant - The variant of the input component.
 * @property {string} bgColor - The background color of the input component.
 * @property {string} color - The text color of the input component.
 * @property {string} rounded - The border radius of the input component.
 * @property {string} label - The label text of the input component.
 * @property {string} name - The name attribute of the input component.
 * @property {string} placeholder - The placeholder text of the input component.
 * @property {boolean} clearable - Whether the input should be clearable.
 * @property {boolean} hideDetails - Whether to hide input details.
 * @property {string} suffix - The suffix for the input.
 * @property {string} prependInnerIcon - The icon to prepend inside the input.
 */
const options = {
  variant:"solo",
  bgColor:"card",
  color: "primary",
  rounded:"xl",
  label:"جستجوی دوره",
  name:"search",
  placeholder:"دوره مورد نظر را جستجو کن",
  clearable:false,
  hideDetails: true,
  suffix:"input.suffix",
  prependInnerIcon:"$mdiMagnify",
}

const router = useRouter();
const route = useRoute();

/**
 * The searchTextQuery representing the search term in the route query.
 * @type {import('vue').ComputedRef<string>}
 */
const searchTextQuery  = computed(()=> route.query.search);

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
 * Function to update the query parameters with the new search keyword.
 * @param {string} search - The new search keyword.
 * @returns {void}
 */
const pushWithQuery = (search) => {
  const query = Object.assign({},route.query);
  search ? query['search'] = search : delete query['search'];
  router.push({query: {...query }}).then((res)=> {

  })
}

/**
 * Function to perform debounced search.
 * @function
 * @returns {void}
 */
function searchDebounced () {
  loading.value = true;
  clearTimeout(_searchTimerId.value)
  _searchTimerId.value = setTimeout(() => {
    pushWithQuery(search.value)
    loading.value = false
  }, 500) /* 500ms throttle */
}


/**
 * Lifecycle hook called after the component is mounted.
 * Initializes the search term with the key from route query.
 * @returns {void}
 */
onMounted(()=> {
  search.value = searchTextQuery.value
})
</script>

<template>
  <v-text-field
      v-model="search"
      @input="searchDebounced"
      :variant="options.variant"
      :bg-color="options.bgColor"
      :color="options.color"
      :rounded="options.rounded"
      :label="options.label"
      :name="options.name"
      :placeholder="options.placeholder"
      :clearable="options.clearable"
      :hide-details="options.hideDetails"
      :prepend-inner-icon="options.prependInnerIcon"
      :disabled="false"
  >
    <template #append-inner>
      <v-progress-circular v-if="loading" indeterminate color="primary"></v-progress-circular>
    </template>
  </v-text-field>
</template>

<style scoped lang="scss">

</style>