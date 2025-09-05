<script setup>
import Plyr from 'plyr'
import 'plyr/dist/plyr.css'
import {onMounted, ref} from "vue";

  const props = defineProps({
    vodLink: {
      type: String
    },
  })
const options = {
  controls: ['play-large', 'play', 'progress', 'current-time', 'duration', 'mute', 'volume', 'settings', 'quality', 'fullscreen'],
      settings: ['quality', 'speed'],
      speed: {selected: 1, options: [.75, .9, 1, 1.25, 1.5, 1.75, 2, 3]},
  keyboard: {focused: true, global: true},
  // tooltips: {controls: true, seek: true},
  // quality: { default: 360, options: [360, 480, 720, 1080] }
  // markers: {enabled: true, points: [{time: 12, label: 'string'}]}
  // previewThumbnails: {enabled: true, src: 'https://samplelib.com/lib/preview/png/sample-hut-400x300.png'}
};

const videoPlayer = ref();
const player =  ref({});
const tempPlayer = ref();
const mainVideoLink = ref("");
const playerError = ref({});


onMounted(()=> {
  mainVideoLink.value = props.vodLink;
  // mainVideoLink.value = 'https://demo.unified-streaming.com/k8s/features/stable/video/tears-of-steel/tears-of-steel.ism/.m3u8';
  const video = videoPlayer.value;
  const defaultOptions = options;
    video.src = mainVideoLink.value;
    video.playsInline = true
    var mainPlayer = new Plyr(video, defaultOptions);
})

</script>

<template>
  <div class="video-inner-container rounded-xl overflow-hidden" ref="videoPlayerSection">
    <!--    <video v-if="tempPlayer" ref="videoPlayerBeforeLoading"></video>-->
    <video  ref="videoPlayer"></video>
  </div>
</template>

<style scoped lang="scss">

</style>