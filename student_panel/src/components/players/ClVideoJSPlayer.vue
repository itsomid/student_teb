<template>
  <div class="video-container" :class="rounded">
    <video
        ref="videoPlayer"
        class="video-js vjs-default-skin overflow-hidden"
        :class="rounded"
        controls
        preload="auto"
        width="640"
        height="360"
    ></video>
  </div>
</template>

<script>
import 'video.js/dist/video-js.min.css';
import videojs from 'video.js';
import 'videojs-seek-buttons/dist/videojs-seek-buttons.css';
import 'videojs-hls-quality-selector/dist/videojs-hls-quality-selector.css';
import 'videojs-hls-quality-selector';
import videojsSeekButtons from 'videojs-seek-buttons';
import 'videojs-hotkeys';
import "videojs-contrib-quality-levels";
import 'videojs-hls-quality-selector';
import qualitySelector from '@eban5/videojs-hls-quality-selector';
import qualityLevels from 'videojs-contrib-quality-levels';

videojs.registerPlugin('hlsQualitySelector', qualitySelector);

if (!videojs.getPlugin('qualityLevels')) {
  videojs.registerPlugin('qualityLevels', qualityLevels);
}

// Register plugins once
if (!videojs.getPlugin('seekButtons')) {
  videojs.registerPlugin('seekButtons', videojsSeekButtons);
}

export default {
  props: {
    vodLink: {
      type: String,
      required: true,
    },
    rounded: {
      type: String,
      default: 'rounded-lg'
    }
  },
  data() {
    return {
      options: {
        html5: {
          hls: {
            overrideNative: true,
            limitRenditionByPlayerDimensions: true,
            useDevicePixelRatio: true,
          },
          nativeAudioTracks: false,
          nativeVideoTracks: false,
          useBandwidthFromLocalStorage: true,
        },
        controlBar: {
          volumePanel: true,
          qualitySelector: true,
          pictureInPictureToggle: false,
        },
        fluid: true,
        language: 'en',
        playbackRates: [1, 1.25, 1.5, 2, 3],
        responsive: true,
      },
    };
  },
  mounted() {
    this.player = videojs(this.$refs.videoPlayer, this.options, () => {
      // Set the video source
      this.player.src({
        type: 'application/x-mpegURL',
        src: this.vodLink,  // Use the prop value passed in
      });

      // Initialize plugins
      this.player.seekButtons({
        forward: 10,
        back: 10,
      });

      this.player.hotkeys({
        volumeStep: 0.1,
        seekStep: 5,
        enableFull: false,
        enableMute: true,
        enableVolumeScroll: true,
      });

      this.player.qualityLevels();
      this.player.hlsQualitySelector({
        displayCurrentQuality: true,
      });
    });
  },
  beforeUnmount() {
    if (this.player) {
      this.player.dispose();
    }
  },
};
</script>

<style scoped>
.video-container {
  max-width: 100%;
  margin: 0 auto;
}
</style>
