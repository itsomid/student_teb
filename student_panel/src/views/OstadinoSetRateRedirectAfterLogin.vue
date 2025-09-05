<script setup>
import {computed, onMounted, ref} from "vue";
import {useAlert} from "@/composable/useAlert";
import RepositoryFactory from "@/repository/RepositoryFactory";
import {useRoute} from "vue-router";
import {useNavigator} from "@/composable/useNavigator";
import ClLoadingOverlay from "@/components/base/ClLoadingOverlay.vue";

  const OstadinoRepository = RepositoryFactory.get('Ostadino');
  const { navigateToOstadino } = useNavigator();
  const { success, error } = useAlert();
  const route = useRoute();
  const videoId = computed(()=> route.query.video_id);
  const rate = computed(()=> route.query.rate);
  const loading = ref(false);
const rateTeacher = async (video_id,rate)=> {
  try {
    loading.value = true;
    await OstadinoRepository.rating({
      video_id: video_id,
      rate: rate
    });
    success('نظر شما با موفقیت ثبت شد.');
    setTimeout(()=>{
      navigateToOstadino();
    },2000)
  }catch (e) {
    error(e?.error?.message || 'ثبت نظر با مشکل مواجه شده است.لطفا مجددا تلاش کنید.')
    navigateToOstadino();
  }finally {
    loading.value = false;
  }
}
  onMounted(()=>{
    rateTeacher(videoId.value,rate.value);
  })
</script>

<template>
  <div>
    <ClLoadingOverlay v-if="loading" :model-value="loading" v-model="loading" :contained="true" scale="1" opacity="0.1" />
  </div>
</template>

<style scoped lang="scss">

</style>