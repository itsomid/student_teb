<script setup>
  import { onMounted, reactive, ref,  } from "vue";
  import RepositoryFactory from "@/repository/RepositoryFactory";
  import OstadinoVideoFilterMobileItem from "@/components/ostadino/OstadinoVideoFilterMobileItem.vue";

  const FILTER_OPTIONS = {
    grades : 'پایه تحصیلی',
    lessons: 'درس',

  }

  const emits = defineEmits('filter');

  const state = reactive({
    grades: null,
    lessons: null,
    teacher_name: null
  })

  // Props and Emits
  defineProps({
    modelValue: {
      type: Object,
      required: true,
    },
  });


  const show = ref(false)

  // Filters Data
  const filters = ref({});


  // Loading State
  const loading = ref(false);
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
   * Removes a specific filter from the state.
   * @param {string} key - The key of the filter.
   * @param {number} id - The ID of the item to remove.
   */
  const removeFilter = (key, id) => {
    const index = state[key]?.findIndex((item) => item.id === id);
    if (index > -1) {
      state[key].splice(index, 1);
      emits('filter',state);
    }
  };


  /**
   * Clears all filters in the state.
   */
  const clearAllFilters = () => {
    Object.keys(state).forEach((key) => {
      state[key] = null;
    });
    emits('filter',state);
    show.value = false;
  };

  const filter = ()=>{
    emits('filter', state);
    show.value = false;
  }

  // Lifecycle Hook: On Mounted
  onMounted(async () => {
    await fetchProductFilters();
  });

</script>

<template>
  <v-bottom-sheet v-model="show" class="rounded-0" max-height="95vh" height="95vh" scrollable >
    <template v-slot:activator="{ props }">
      <v-list-item v-bind="props" border rounded="lg">
        <v-list-item-title class="text-right">فیلترها</v-list-item-title>
        <template #append>
          <v-icon color="secondary" icon="cli:Filter" type="bold"></v-icon>
        </template>
      </v-list-item>

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
        <div v-if="Object.values(state).some((item) => item)">
          <v-btn @click="clearAllFilters" class="border" rounded="lg">
            حذف همه فیلتر‌ها
          </v-btn>
        </div>
      </div>
    </template>

    <v-card
        height="100%"
        rounded="0"
    >
      <v-card-title>
        <v-btn variant="text" block @click="show = false">
          <v-icon size="30" color="secondary" icon="cli:Minus" />
        </v-btn>
      </v-card-title>
      <div class="bg-background d-flex flex-column justify-center align-center w-100 pa-3">
        <!-- Display Selected Filters -->
        <div class="d-flex  flex-wrap flex-row ga-1">
          <div v-for="(filter, key) in state" :key="'filter-' + key" class="d-flex flex-row flex-wrap ga-1">
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
        <div class="w-100 mt-4">
          <v-btn @click="clearAllFilters" block class="border" rounded="lg">
            حذف همه فیلتر‌ها
          </v-btn>
        </div>
      </div>
      <v-card-text class="flex-grow-0 pb-0">
        <v-text-field variant="outlined" placeholder="استادت رو جستجو کن" v-model="state.teacher_name" prepend-inner-icon="$mdiMagnify" rounded="lg"/>
      </v-card-text>
      <v-card-text v-if="Object.keys(filters).length">
         <template v-for="(value,key) in filters">
           <template v-if="Object.keys(FILTER_OPTIONS).includes(key)">
             <OstadinoVideoFilterMobileItem v-model="state[key]" :title="FILTER_OPTIONS[key]" :items="value"/>
           </template>
         </template>
      </v-card-text>
      <v-card-actions>
        <v-btn variant="flat" rounded="lg" block color="primary" @click.prevent="filter" >
          پیدا کن
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-bottom-sheet>
</template>

<style scoped lang="scss">

</style>