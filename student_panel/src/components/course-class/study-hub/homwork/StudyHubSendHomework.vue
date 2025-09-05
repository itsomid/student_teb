<script setup>
import StudyHubSendHomeworkHints from "@/components/course-class/study-hub/homwork/StudyHubSendHomeworkHints.vue";
import StudyHubSendHomeworkUploader from "@/components/course-class/study-hub/homwork/StudyHubSendHomeworkUploader.vue";
import RepositoryFactory from "../../../../repository/RepositoryFactory";
import {useRoute} from "vue-router";
import {computed, onMounted, ref} from "vue";

const route = useRoute()
const class_id = computed(()=> (route.params.class_id));
const ClassRepo = RepositoryFactory.get('Class')

const isElementary = ref(false);
const checkUserGrade = async ()=> {
  try {
    const { data } = await ClassRepo.getUserCourseGrade(class_id.value);
    isElementary.value = data.grade === 'elementary_school'
  }catch (e) {
    console.log('ERROR: check user Grade',e)
  }
}

onMounted(async ()=>{
  await checkUserGrade();
})
</script>

<template>
  <div>
    <!-- Banner for notifications -->
    <v-banner  bg-color="background" border="0" sticky>
      <template #text>
        <!-- Heading for notifications -->
        <h1 class="text-h6 font-weight-bold">ارسال تکالیف</h1>
      </template>
    </v-banner>
    <v-card rounded="xl" width="100%" class="d-flex flex-column justify-center align-center mt-6">
      <v-card-text class="pa-6">
          <h2  class="text-center text-h6 font-weight-bold px-6 mt-6">
            عکس از تکالیف خود بگیرید و عکس‌ها را در این قسمت ارسال کنید.
          </h2>
        <StudyHubSendHomeworkHints :isElementarySchool="isElementary" class="mt-6"/>
        <v-divider inset class="mx-auto" />
        <v-col cols="12" md="6" class="mx-auto">
          <StudyHubSendHomeworkUploader :isElementarySchool="isElementary" />
        </v-col>
      </v-card-text>
    </v-card>
  </div>
</template>

<style scoped lang="scss">

</style>