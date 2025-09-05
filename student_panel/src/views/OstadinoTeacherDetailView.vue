<script setup>
import TopBlueSection from '@/components/ostadino/teacher-detail/TopBlueSection.vue'
import ProfessorResume from '@/components/ostadino/teacher-detail/ProfessorResume.vue'
import OstadinoVideoList from '@/components/ostadino/teacher-detail/OstadinoVideoList.vue'
import { onMounted, ref } from 'vue'
import RepositoryFactory from '@/repository/RepositoryFactory'
import { useAlert } from '@/composable/useAlert'
import { useRoute, useRouter } from 'vue-router'
const loading= ref(false)
const professor = ref('')
const { error } = useAlert();
const videoUrl =ref('')
const modal = ref(false)
const OstadinoRepository = RepositoryFactory.get('Ostadino');
const route = useRoute()
const router = useRouter()
const getProfessorDetail = async (level = null, id) => {
  try {
    loading.value = true;
    const { data } = await OstadinoRepository.getVideoById(level, id);
    professor.value = data;
    videoUrl.value = professor.value.videos[professor.value.videos.length - 1].video_url;
  } catch (e) {
    if (e.error.status === 404) {
      modal.value = false
      error('استاد مورد نظر یافت نشد')
    }
  } finally {
    loading.value = false;
  }
}
onMounted(() => {
  setTimeout(()=>{
    getProfessorDetail(null, route.params.professorId)
  },10)
})

</script>

<template>
  <v-card elevation="0" rounded="xl" class="d-flex flex-column" v-if="professor">
    <TopBlueSection :lessons="professor.lessons" :profName="professor.name"  :profDetail="professor.details"></TopBlueSection>
    <div class="my-16">
      <v-row class="d-flex justify-space-evenly" justify="center">
        <ProfessorResume :v-if="professor.details?.show_resume" :profName="professor.name" :resume="professor.details?.resume"></ProfessorResume>
        <OstadinoVideoList :items="professor.videos"></OstadinoVideoList>
      </v-row>
    </div>
  </v-card>
</template>

<style scoped lang="scss">

</style>
