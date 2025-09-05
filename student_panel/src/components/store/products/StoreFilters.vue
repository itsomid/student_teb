<script setup>
import {onBeforeMount, onMounted, reactive, ref, watch} from "vue";
import {SCHEMA} from "@/schema/store/STORE_FILTER.schema";
import useVuelidate from "@vuelidate/core";
import FormGenerator from "@/components/base/form/FormGenerator.vue";
import {useRoute, useRouter} from "vue-router";
import {useUtils} from "@/composable/useUtils";
import RepositoryFactory from "@/repository/RepositoryFactory";
import {useStore} from "vuex";


// Reactive state, schema, and validation rules
const { schema, model: state, validations: rules } = reactive(SCHEMA);

// Vuelidate instance
const v$ = useVuelidate(rules, state);

// Loading state and error message
const loading = ref(false);

const store = useStore();

// Vue router
const route = useRoute();
const router = useRouter();

// Utility functions
const { updateRouteWithQueryParams, valueParser } = useUtils();


/**
 * Ref for storing the products.
 * @type {import('vue').Ref<Object>}
 */
const filters = ref({});


/**
 * Store repository instance.
 * @type {import('@/repository/Repository').default}
 */
const StoreRepository = RepositoryFactory.get("Store");

/**
 * Function to fetch store products filters from the repository.
 * @async
 * @function
 * @returns {Promise<void>}
 */
const getProductsFilters = async () =>{
  try {
    loading.value = true;
    const { data: { data } } = await StoreRepository.getProductFilters();
    await store.dispatch('shop/updateFilters',data);
    filters.value = data;
    return filters
  }catch (e) {
    return Promise.reject(e)
  }finally {
    loading.value = false;
  }
};

const grade = store.getters['userStore/grade'];
const filedOfStudy = store.getters['userStore/fieldOfStudy'];
const initialize = ()=> {
  schema[0].items = filters.value.grades
  schema[1].items = filters.value.fields
  schema[2].items = filters.value.lessons
  schema[3].items = filters.value.professor
  schema[4].items = filters.value.category

  const hasFilter = Object.keys(route.query).length !== 0;
  if(!hasFilter) setInitialFilterBasedOnUserState();

  // Initialize state from route query parameters
  initializeStateFromRouteQueryParams(state,route.query)
}

const initializeStateFromRouteQueryParams = (state,query) => {
  Object.keys(state).forEach(key => {
    if (query.hasOwnProperty(key)) {
      state[key] = valueParser(query[key]);
    }
  });
}

const setInitialFilterBasedOnUserState = ()=>{
  const foundGrade = grade === 'gadim' ? filters.value.grades.find((item)=> item.key == 12) : filters.value.grades.find((item)=> item.key == grade);
  const foundField = filters.value.fields.find((item)=> item.key == filedOfStudy);
  const query = {
    grade: foundGrade?.id,
    fields: foundField?.id,
    search: '1404'
  }

  router.push({query: {
      ...query,
      ...route.query
    }})
}
watch(state,(newValue)=> {
  updateRouteWithQueryParams({ ...newValue })
}, { deep:true});

watch(() => route.query,(newValue)=> {
  initializeStateFromRouteQueryParams(state,newValue);
});


onMounted(async ()=>{
  await getProductsFilters()
  initialize();
});
onBeforeMount(()=>{

})

</script>

<template>
  <v-row>
    <v-col cols="12" lg="1" class="d-flex flex-column justify-center align-center">
      <span class="text-body-2 text-secondary ">فیلتر‌ها</span>
    </v-col>
    <v-col cols="12" lg="11">
      <FormGenerator  :schema="schema" :v$="v$" :state="state" v-model="state"/>
    </v-col>
  </v-row>
</template>

<style scoped lang="scss">

</style>