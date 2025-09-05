<script setup>
import RepositoryFactory from "@/repository/RepositoryFactory";
import {onMounted, ref} from "vue";
import {useRoute} from "vue-router";
const HEADERS = [
  {
    title: "جلسه",
    key: "class_name",
    sortable: false,
    align: 'start',
  },
  {
    title: "حضور در جلسه زنده",
    key: "status_online",
    sortable: false,
    align: 'start',
  },
  {
    title: "تماشای آفلاین",
    key: "status_offline",
    sortable: false,
    align: 'start',
  },
]

const route = useRoute();
/**
 * Ref for tracking the loading state.
 * @type {import('vue').Ref<boolean>}
 */
const loading = ref(false);

const classes = ref()


/**
 * User repository instance.
 * @type {import('@/repository/Repository').default}
 */
const CourseRepository = RepositoryFactory.get("Course");

/**
 * Function to fetch user courses from the repository.
 * @async
 * @function
 * @returns {Promise<void>}
 */
const getUserAbsenceSituation = async () =>{
  try {
    loading.value = true;
    const { data: { data } } = await CourseRepository.getUserAbsenceSituation(route.params.course_id);
    classes.value = data;
  }catch (e) {
    console.log(e);
  }finally {
    loading.value = false;
  }
};

onMounted(()=> {
  getUserAbsenceSituation();
})

</script>

<template>
  <v-card rounded class="rounded-xl" border flat >
    <v-data-table
        :items="classes"
        :headers="HEADERS"
        hover=""
        :loading="loading"
        hide-default-footer
        :items-per-page="-1"
    >
      <template #top>
        <h2 class="font-weight-bold text-subtitle-1 rounded-xl rounded-b border-b pa-4 " >وضعیت حضور و غیاب</h2>
      </template>
      <template v-slot:bottom></template>
      <template #no-data>
        جلسه ای وجود ندارد
      </template>
      <template #item.status_online="{item}">
        <v-icon v-if="item.status_online" color="success">$mdiCheck</v-icon>
        <v-icon v-else color="error">$mdiClose</v-icon>
      </template>
      <template #item.status_offline="{item}">
        <v-icon v-if="item.status_offline" color="success">$mdiCheck</v-icon>
        <v-icon v-else color="error">$mdiClose</v-icon>
      </template>
    </v-data-table>
  </v-card>
</template>

<style scoped lang="scss">

</style>