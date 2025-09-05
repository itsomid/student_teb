<script setup>
import {useAlert} from "@/composable/useAlert";
import {useRoute, useRouter} from "vue-router";
import {onMounted, ref} from "vue";
import RepositoryFactory from "@/repository/RepositoryFactory";
import {useDateFormatter} from "@/composable/useDate";
const { error } = useAlert();

/**
 * Vue router instance.
 * @type {import('vue-router').Router}
 */
const router  = useRouter();

/**
 * Vue route instance.
 * @type {import('vue-router').RouteLocationNormalized}
 */
const route   = useRoute();

/**
 * Ref for storing the current course questions and answers.
 * @type {import('vue').Ref<Object>}
 */
const classes = ref({});

/**
 * Ref for tracking the loading state.
 * @type {import('vue').Ref<boolean>}
 */
const loading = ref(false);

/**
 * class repository instance.
 * @type {import('@/repository/Repository').default}
 */
const ClassRepository = RepositoryFactory.get("Class");

/**
 * Function to fetch user course question and answers class from the repository.
 * @async
 * @function
 * @returns {Promise<void>}
 */
const getQuestionAnswerClasses = async () =>{
  try {
    loading.value = true;
    await router.isReady();
    const { data: { data } } = await ClassRepository.getQuestionAnswerClasses(route.params.course_id);
    classes.value = data;
  }catch (e) {
    error(e.error?.message);
  }finally {
    loading.value = false;
  }
};

/**
 * Lifecycle hook that runs after the component has been mounted.
 * Fetches user courses.
 */
onMounted(()=>{
  getQuestionAnswerClasses();
})

const changeClass = (class_id)=> {
  router.replace({params: { course_id: route.params.course_id, class_id: class_id }})
}
</script>

<template>
 <v-card :loading="loading" flat rounded="xl" border>
   <v-list nav v-if="classes.length" rounded="xl" color="primary">
     <v-list-subheader>
       جلسات دیگر این دوره
     </v-list-subheader>
     <v-list-item
         v-for="item in classes"
         link
         :active="item.class_id === +route.params.class_id"
         :title="item.name"
         :subtitle="useDateFormatter(classes.holding_date, 'LONG')"
         rounded="xl"
         @click="changeClass(item.class_id)"
         :prepend-icon="item.purchased_status ? '$mdiLockOutline' : '$mdiLockOpenVariantOutline'"
         class="mx-1 px-3 pa-3 my-1"
     >
       {{ item.id }}
     </v-list-item>
   </v-list>
 </v-card>
</template>

<style scoped lang="scss">

</style>