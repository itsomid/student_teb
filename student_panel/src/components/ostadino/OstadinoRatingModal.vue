<script setup>

import ClModal from "@/components/app/ClModal.vue";
import {onMounted, ref, watch} from "vue";
import {useUrl} from "@/composable/useUrl";
import {DEFAULT_IMAGE_PATH} from "@/config/filePath.config";
import RepositoryFactory from "@/repository/RepositoryFactory";
import ClLoading from "@/components/base/ClLoading.vue";
import {useAlert} from "@/composable/useAlert";
import ClVideoJSPlayer from "@/components/players/ClVideoJSPlayer.vue";
import {PersianNumberDictionary} from "@/constants/persianNumber";

const emit = defineEmits(['close']);
const props = defineProps({
  teacher_id: {
    type: Object,
    required: true,
  },
  video_id: {
    type: Object,
    required: true,
  }
})

const modal = defineModel({
  default: false
});

const { imageUrlBuilder, defaultImageUrlBuilder } = useUrl();
const { success, error } = useAlert();
const OstadinoRepository = RepositoryFactory.get('Ostadino');
const loading = ref(true);
const video = ref();
const videoUrl = ref();
const rate = ref(0);

const getVideos = async (level,id)=>{
  try {
    loading.value = true;
    const { data  } = await OstadinoRepository.getVideoById(level,id);
    video.value = data;
    videoUrl.value = video.value.videos[video.value.videos.length - 1].video_url;
  }catch (e) {
    console.log(e)
  }finally {
    loading.value = false;
  }
}

const rateTeacher = async (video_id,rate)=> {
  try {
    loading.value = true;
   await OstadinoRepository.rating({
     video_id: video_id,
     rate: rate
   });
    success('نظر شما با موفقیت ثبت شد.');
    emit('close');
  }catch (e) {
    error(e?.error?.message || 'ثبت نظر با مشکل مواجه شده است.لطفا مجددا تلاش کنید.')
  }finally {
    loading.value = false;
  }
}

watch(()=> props.teacher_id,(value)=>{
  if(value) getVideos(props.step,value)
})
onMounted(()=>{
  console.log(props.teacher_id)
  if(props.teacher_id) getVideos(props.step,props.teacher_id,)
})
</script>

<template>
  <ClModal v-model="modal" width="1055" class="" color="surface-darken-1"  :persistent="true">
    <div>
      <div class="">
        <v-row v-if="video" >
          <v-col cols="12" lg="4" class="px-4 py-6">
            <div v-if="$vuetify.display.mobile">
              <v-list-item
                  :prepend-avatar="!!video.profile_image ? imageUrlBuilder(video.profile_image, 'OSTADINO') : defaultImageUrlBuilder(DEFAULT_IMAGE_PATH.AVATAR)"
                  :title="video.name"
                  :subtitle="video.lessons.join('،')" />
            </div>
            <div v-else class="d-flex flex-column justify-center align-center mt-10">
              <v-avatar
                  size="64"
                  :image="video.profile_image ? imageUrlBuilder(video.profile_image, 'OSTADINO') : defaultImageUrlBuilder(DEFAULT_IMAGE_PATH.AVATAR)"
              ></v-avatar>
              <p class="text-secondary text-caption mt-2">{{ video.name }}</p>
              <router-link :to="{name:'ostadino.detail', params:{professorId:video.teacher_id}}" class="text-primary mb-4" style="font-size: 13px">رزومه استاد</router-link>
              <div class="mx-1" v-for="(lesson, index) in video.lessons">
                {{ lesson }}
                <span v-if="index < video.lessons.length - 1">،</span>
              </div>
            </div>
            <v-list mandatory base-color="secondary" bg-color="surface-darken-1" class="">
                <template v-for="(item, index) in video.videos" :key="'ostadino-video-rating-' + index">
                  <v-list-item @click="videoUrl=item.video_url" append-icon="cli:Play:type:bold" :title="`نمونه تدریس ${PersianNumberDictionary[index + 1]}`">
                  </v-list-item>
                  <v-divider v-if="index < video.videos.length - 1"/>
                </template>
            </v-list>
          </v-col>
          <v-col cols="12" lg="8">
            <ClVideoJSPlayer v-if="videoUrl" :key="videoUrl" :vodLink="videoUrl" rounded="rounded-xl"/>
          </v-col>
        </v-row>
        <ClLoading v-else />
      </div>
      <v-divider class="mt-6"/>
      <div class="my-3 mx-3">
        <v-row>
          <v-col cols="12">
            <v-row class="py-5 text-center">
              <v-col cols="12" lg="4" class="d-flex flex-row justify-center ga-4 align-center pr-5">
                <span class="text-secondary  font-weight-bold">به تدریس این استاد از ۱ تا ۵ چند ستاره میدی؟</span>
              </v-col>
              <v-col cols="12" lg="4" class="d-flex flex-row ga-4 align-center justify-center">
                <v-rating
                    empty-icon="cli:Star1"
                    half-icon="cli:Star1:type:bulk"
                    full-icon="cli:Star1:type:bold"
                    color="secondary"
                    active-color="warning"
                    hover
                    v-model="rate"
                    length="5" >
                </v-rating>
              </v-col>
              <v-col cols="12" lg="4" class="d-flex flex-row ga-4 align-center">
                <div class="w-100 px-5 d-flex flex-row ga-1 justify-space-between">
                  <v-btn
                      :disabled="loading"
                      rounded="lg"
                      size="large"
                      variant="flat"
                      border
                      @click="emit('close')">
                    انصراف
                  </v-btn>
                  <v-btn
                      @click="rateTeacher(props.video_id, rate)"
                      class="flex-grow-1"
                      rounded="lg"
                      :loading="loading"
                      :disabled="loading || rate === 0"
                      size="large"
                      color="primary"
                      variant="flat">
                    ثبت نظر
                  </v-btn>
                </div>
              </v-col>
              <v-col cols="12">
                <p style="color: #AB0314" class="font-weight-bold">
                  مرحله اول مسابقه به پایان رسیده است!
                </p>
              </v-col>
            </v-row>
          </v-col>
        </v-row>
      </div>
    </div>
  </ClModal>
</template>

<style scoped lang="scss">

</style>