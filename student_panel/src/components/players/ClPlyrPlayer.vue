<script setup>
import Plyr from 'plyr'
import Hls from 'hls.js'
import 'plyr/dist/plyr.css'
import {onMounted, ref} from "vue";

  const props = defineProps({
    vodLink: {
      type: String
    },
  })
const options = {
  controls: ['play-large', 'rewind', 'play', 'fast-forward', 'progress', 'current-time', 'duration', 'mute', 'volume', 'settings', 'quality', 'fullscreen'],
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

  if (Hls.isSupported()) {
    const hls = new Hls();
    hls.loadSource(mainVideoLink.value);
    hls.on(Hls.Events.ERROR, function (event, data) {

      console.log('error', data.error)
      // this.playerError = data
    })
    hls.on(Hls.Events.MANIFEST_LOADED, function () {
      //
      // const fastForwardBtn = document.querySelector(".plyr__controls__item[data-plyr='fast-forward']");
      // const rewindBtn = document.querySelector(".plyr__controls__item[data-plyr='rewind']");
      // fastForwardBtn.querySelector('svg').remove();
      // rewindBtn.querySelector('svg').remove();
      //
      // const imageFastForward = document.createElement('img');
      // const imageRewind = document.createElement('img');
      // imageFastForward.src = require('@/assets/images/icons/forward-10.svg'); // Replace with your own image URL
      // imageRewind.src = require('@/assets/images/icons/rewind-10.svg'); // Replace with your own image URL
      //
      // fastForwardBtn.appendChild(imageFastForward);
      // rewindBtn.appendChild(imageRewind);
    });
    hls.on(Hls.Events.MANIFEST_PARSED, function (_event, _data) {
      // console.log('levels', hls.levels);
      const availableQualities = hls.levels.map((l) => l.height)
      availableQualities.unshift(0)
      // console.log('availableQualities', availableQualities);

      defaultOptions.quality = {
        default: 0, //Default - AUTO
        options: availableQualities,
        forced: true,
        onChange: (newQuality) => {
          if (newQuality === 0) {
            window.hls.currentLevel = -1; //Enable AUTO quality if option.value = 0
          } else {
            window.hls.levels.forEach((level, levelIndex) => {
              if (level.height === newQuality) {
                console.log("Found quality match with " + newQuality);
                window.hls.currentLevel = levelIndex;
              }
            });
          }
        }
      }

      defaultOptions.i18n = {
        qualityLabel: {
          0: 'Auto',
        },
        quality: 'کیفیت',
        speed: 'سرعت'
      }
      hls.on(Hls.Events.LEVEL_SWITCHED, function (event, data) {

        var span = document.querySelector(".plyr__menu__container [data-plyr='quality'][value='0'] span")
        if (hls.autoLevelEnabled) {
          span.innerHTML = `AUTO (${hls.levels[data.level].height}p)`
        } else {
          span.innerHTML = `AUTO`
        }
      })

      var mainPlayer = new Plyr(video, defaultOptions);

      // mainPlayer.poster = 'https://cdn.vuetifyjs.com/images/parallax/material.jpg';

    });

    hls.attachMedia(video);
    window.hls = hls;
    // this.tempPlayer = window.tempPlayer
    // console.log('tmp',window.hls)
  } else {
    video.src = mainVideoLink.value;
    video.playsInline = true
    var mainPlayer = new Plyr(video, defaultOptions);
  }

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