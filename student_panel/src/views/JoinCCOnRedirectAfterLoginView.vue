<script setup>
import {computed, onMounted, ref} from "vue";
import {useRoute} from "vue-router";
import RepositoryFactory from "@/repository/RepositoryFactory";
import {useAlert} from "@/composable/useAlert";
import {useNavigator} from "@/composable/useNavigator";

  const loading = ref(false);
  const route = useRoute();
  const { navigateToStore, navigateTo404 } = useNavigator();

  const classId = computed(()=> route.params.class_id);


  const { success, error, info } = useAlert();
  const ClassRepository = RepositoryFactory.get('Class');

  const classData = ref();
  const joinCCO = async (classId)=>{
    try {
      loading.value = true;
      const { data: { data } } = await ClassRepository.getUserCourseClass(classId);
      classData.value = data;
      await ClassRepository.setUserClassPresent(classId, {
        watch_online: 1
      });
      success('حضور شما در جلسه ثبت شد');

    }catch (e) {
      if(e.error.status === 403) {
        info('دوره انتخابی خریداری نشده ابتدا دوره مورد نظر را خریداری کنید');
        navigateToStore();
      }
      else if(e.error.status === 404) navigateTo404();
      else if(e.error.status === 429) error('حضور شما قبلا در جلسه ثبت شده است');
    }finally {
      loading.value = false;
      success('در حال انتقال به صفحه مشاهده جلسه');
      window.location.href = classData.value.cc_url
    }
  }

  onMounted(()=>{
    joinCCO(classId.value);
  })
</script>

<template>
  <div>
    <ClLoadingOverlay v-if="loading" :model-value="loading" v-model="loading" :contained="true" scale="1" opacity="0.1" />
  </div>
</template>

<style scoped lang="scss">

</style>