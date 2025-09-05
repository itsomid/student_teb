<script setup>
import ClAparatVideoPlayer from "@/components/players/ClAparatVideoPlayer.vue";
import ClPlyrPlayer from "@/components/players/ClPlyrPlayer.vue";
import ClVideoJSPlayer from "@/components/players/ClVideoJSPlayer.vue";

const props = defineProps(['hdVideoData', 'player'])
</script>

<template>
  <div>
    <ClAparatVideoPlayer :aparat-token="hdVideoData.aparat_token" v-if="hdVideoData.hd_video_type ==='aparat'" />
    <ClVideoJSPlayer     :vodLink="hdVideoData.record_video_HD_hls_path"  v-if="hdVideoData.hd_video_type === 'vod' && player === 'videojs'"></ClVideoJSPlayer>
    <ClPlyrPlayer :vodLink="hdVideoData.record_video_HD_hls_path" v-if="hdVideoData.hd_video_type === 'vod' && player === 'plyr'"/>
  </div>
</template>

<style scoped lang="scss">

</style>