<script setup>
import { onMounted, reactive, ref, watch } from "vue";
import useVuelidate from "@vuelidate/core";
import FormGenerator from "@/components/base/form/FormGenerator.vue";
import { SCHEMA } from "@/schema/ostadino/VIDEO_FILTER.schema";
import RepositoryFactory from "@/repository/RepositoryFactory";

const emit = defineEmits(['filter']);

// Reactive Schema, State, and Validation Rules
const { schema, model: state, validations: rules } = reactive(SCHEMA);

// Validation Instance
const v$ = useVuelidate(rules, state);

// Loading State
const loading = ref(false);

// Filters Data
const filters = ref({});

// Repository Instance
const StoreRepository = RepositoryFactory.get("Store");

/**
 * Fetches product filters from the repository and updates the state.
 */
const fetchProductFilters = async () => {
  try {
    loading.value = true;
    const { data: { data } } = await StoreRepository.getProductFilters();
    filters.value = data;
  } catch (error) {
    console.error("Error fetching product filters:", error);
    throw error;
  } finally {
    loading.value = false;
  }
};

/**
 * Initializes schema items with fetched filter data.
 */
const initializeSchema = () => {
  schema[0].items = filters.value.grades;
  schema[1].items = filters.value.lessons;
  schema[2].teacher_name = filters.value.teacher_name
};

/**
 * Removes a specific filter from the state.
 * @param {string} key - The key of the filter.
 * @param {number} id - The ID of the item to remove.
 */
const removeFilter = (key, id) => {
  const index = state[key]?.findIndex((item) => item.id === id);
  if (index > -1) {
    state[key].splice(index, 1);
    emit('filter', state);
  }
};

/**
 * Clears all filters in the state.
 */
const clearAllFilters = () => {
  Object.keys(state).forEach((key) => {
    state[key] = null;
  });
  emit('filter',state)
};

// Lifecycle Hook: On Mounted
onMounted(async () => {
  await fetchProductFilters();
  initializeSchema();
});


</script>

<template>
  <v-row>
    <v-col cols="12" lg="12">
      <FormGenerator :schema="schema" :v$="v$" :state="state" v-model="state">
        <template #inline-action>
          <v-col cols="12" lg="2">
            <v-btn @click="emit('filter',state)" color="primary" size="x-large" rounded="lg" block>
              جستجو کن
            </v-btn>
          </v-col>
        </template>
      </FormGenerator>

      <div class="d-flex flex-row flex-grow-1 justify-space-between w-100 mt-6">
        <!-- Display Selected Filters -->
        <div class="d-flex flex-grow-1 flex-wrap flex-row ga-1">
          <div v-for="(filter, key) in state" :key="'filter-' + key" class="d-flex ga-1">
            <template v-if="key !== 'teacher_name'">
              <v-chip
                  v-for="item in filter"
                  :key="'filter-' + key + item.id"
                  variant="text"
                  border
                  rounded="lg"
                  closable
                  @click:close.stop.prevent="removeFilter(key, item.id)"
              >
                <template #close>
                  <v-icon color="secondary">$mdiClose</v-icon>
                </template>
                {{ item.name }}
              </v-chip>
            </template>
          </div>
        </div>

        <!-- Clear All Filters Button -->
        <div>
          <v-btn @click="clearAllFilters" class="border" rounded="lg">
            حذف همه فیلتر‌ها
          </v-btn>
        </div>
      </div>
    </v-col>
  </v-row>
</template>

<style scoped lang="scss">
</style>
