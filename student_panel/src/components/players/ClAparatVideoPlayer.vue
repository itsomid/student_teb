<script setup>
  import RepositoryFactory from "@/repository/RepositoryFactory";
  import {onMounted} from "vue";
  import {useRoute} from "vue-router";

  const props = defineProps(['aparatToken']);
  const route = useRoute();
  const ClassRepository = RepositoryFactory.get('Class');
  onMounted(()=> {
    setTimeout(()=> {
      ClassRepository.setUserClassPresent(route.params.class_id)
    },1900000)
  })
</script>

<template>
  <div class="videoWrapper rounded-lg" >
    <iframe v-if="aparatToken" id="iframe" class="rounded-lg"
            :src="'https://www.aparat.com/video/video/embed/videohash/'+aparatToken+'/vt/frame'"
            allowFullScreen="true"  webkitallowfullscreen="true" mozallowfullscreen="true" >
    </iframe>
  </div>
</template>

<style lang="scss" scoped >
.videoWrapper {
  position: relative;
  padding-bottom: 56.25%;
  padding-top: 10px;
  height: 0;
}

.videoWrapper iframe {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
}
</style>