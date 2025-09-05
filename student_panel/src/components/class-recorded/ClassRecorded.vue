<script setup>
import {computed, onMounted, onUnmounted, reactive, ref} from "vue";
import RepositoryFactory from "@/repository/RepositoryFactory";
import { useAlert } from "@/composable/useAlert";
import { useRoute, useRouter } from "vue-router";
import ClLoading from "@/components/base/ClLoading.vue";
import ClMDVideoPlayer from "@/components/players/ClMDVideoPlayer.vue";
import ClHdVideoPlayer from "@/components/players/ClHdVideoPlayer.vue";

const timeToSetPresent = 30 * 60 * 1000;
const { error } = useAlert();

const router  = useRouter();
const route   = useRoute();

const recordedClass = ref({});
const classId = computed(()=> route.params.class_id);
const videoQuality = computed(()=> route.params.video_quality);
const loading = ref(false);
const ClassRepository = RepositoryFactory.get("Class");
const player = ref('videojs');
const presenterId = ref(null);

const changePlayer = (playerName)=>{
  player.value = playerName
}
const getUserCourseRecordedClass = async () =>{
  try {
    loading.value = true;
    await router.isReady();
    const { data: { data } } = await ClassRepository.getRecordedClass(classId.value);
    recordedClass.value = data;
  }catch (e) {
    error(e.error?.message);
  }finally {
    loading.value = false;
  }
};

const setUserClassPresent =  ()=> {
  return setTimeout(async()=>{
    try {
      await ClassRepository.setUserClassPresent(classId.value,{
        watch_online: 0
      });
    }catch (e) {
      console.log(e)
    }
  },timeToSetPresent)
}
onMounted(()=>{
  getUserCourseRecordedClass();
  presenterId.value = setUserClassPresent();
})

onUnmounted(()=>{
  if(presenterId.value) clearTimeout(presenterId.value);
})

const isAparat = computed(()=> {
  return (videoQuality.value === 'md' && recordedClass.value?.md_video_type === 'aparat') || (videoQuality.value === 'hd' && recordedClass.value?.hd_video_type === 'aparat')
})
</script>

<template>
  <div>
    <ClLoading v-if="loading" />
    <v-row v-else>
      <v-col cols="12">
        <v-card rounded="lg" flat border class="pa-4">
          <v-card-title>
            {{ recordedClass.course_name }}
          </v-card-title>
          <v-card-subtitle class="mb-4">
            {{ recordedClass.name }}
          </v-card-subtitle>
          <ClMDVideoPlayer :mdVideoData="recordedClass" :player="player" v-if="videoQuality === 'md'"></ClMDVideoPlayer>
          <ClHdVideoPlayer :hdVideoData="recordedClass" :player="player" v-if="videoQuality === 'hd'"></ClHdVideoPlayer>
          <v-card-actions v-if="!isAparat" class="mt-4">
            <v-btn
                large
                :color="player === 'videojs' ? 'success' : ''"
                @click="changePlayer('videojs')"
                :dark="player === 'videojs'"
            >
              <i class="icon-CL_Play text-25"></i>
              پلیر اول
            </v-btn>
            <v-btn
                large
                @click="changePlayer('plyr')"
                :color="player === 'plyr' ? 'success' : ''"
                :dark="player === 'plyr'"
            >
              <i class="icon-CL_Play text-25"></i>
              پلیر دوم
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
  </div>
</template>

<style scoped lang="scss">

</style>