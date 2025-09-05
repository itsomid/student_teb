<script setup>
  import OstadinoVideoFilters from "@/components/ostadino/OstadinoVideoFilters.vue";
  import {onMounted, reactive, ref, watch} from "vue";
  import OstadinoVideoFilterMobile from "@/components/ostadino/OstadinoVideoFilterMobile.vue";
  import RepositoryFactory from "@/repository/RepositoryFactory";
  import ClPagination from "@/components/app/ClPagination.vue";
  import OstadinoVieoItem from "@/components/ostadino/OstadinoVieoItem.vue";
  import OstadinoRatingModal from "@/components/ostadino/OstadinoRatingModal.vue";

  const props = defineProps({
    step: {
      type:  [String,Number],
      default: 1
    }
  })

  const OstadinoRepository = RepositoryFactory.get('Ostadino');
  const loading = ref(true);
  const videos = ref([]);
  const pagination =reactive({
    last_page: 1,
    current_page: 1,
    per_page: 10,
  })
  const selectedFilters = reactive({
    grades: null,
    fields: null,
    lessons: null,
    teacher_name: null
  });

  const selectedVideo = ref();
  const isShowRatingModal = ref(false);
  const openRatingModal = (item)=>{
    selectedVideo.value = item;
    isShowRatingModal.value = true;
  }

  const closeRatingModal = ()=>{
    selectedVideo.value = null;
    isShowRatingModal.value = false;
  }
  const filterVideos = (filters, page = 1)=>{
    videos.value = [];
    selectedFilters.grades = filters.grades;
    selectedFilters.fields = filters.fields;
    selectedFilters.lessons = filters.lessons;
    selectedFilters.teacher_name = filters.teacher_name;

    let query = Object.fromEntries(
        Object.entries(filters).filter(([key, value]) => value !== null)
    );
    Object.entries(query).map(([key, value]) => {
      if(Array.isArray(value)) query[key] =  value.map((item)=> item.id);
    })
    getVideos(props.step,{
      page: page,
      ...query
    });
  }

  const getVideos = async (level,query = {page:1})=>{
    try {
      loading.value = true;
      const { data : { data,  meta } } = await OstadinoRepository.getVideos(level,query);
      videos.value = data;
      pagination.last_page = meta.last_page;
      pagination.current_page = meta.current_page;
      pagination.per_page = meta.per_page
    }catch (e) {
      console.log(e)
    }finally {
      loading.value = false;
    }
  }
  onMounted(()=>{
    getVideos(props.step);
  })

  watch(()=>props.step, (value)=>{
    getVideos(value);
  })

  watch(()=> pagination.current_page, (value)=> {
    filterVideos(selectedFilters,value);
  })
</script>

<template>
  <div class="text-center">
    <OstadinoVideoFilterMobile v-if="$vuetify.display.mobile" @filter="filterVideos" />
    <OstadinoVideoFilters v-else  @filter="filterVideos" />
    <v-row class="mt-16">
      <v-progress-linear v-if="loading" indeterminate color="primary" rounded="xl" />
      <v-col cols="12" md="6" lg="3" v-for="(video,index) in videos" :key="'ostadino-video-'+ index ">
        <OstadinoVieoItem  :item="video" @open-rating-modal="openRatingModal" />
      </v-col>
    </v-row>
    <div class="mt-16">
      <ClPagination :total-pages="pagination.last_page" v-model="pagination.current_page" size="default" />
    </div>
    <OstadinoRatingModal
        v-if="selectedVideo"
        v-model="isShowRatingModal"
        :teacher_id="selectedVideo.teacher_id"
        :video_id="selectedVideo.video_id"
        @close="closeRatingModal"
    />
  </div>
</template>

<style scoped lang="scss">

</style>