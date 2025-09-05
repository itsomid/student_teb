<script setup>
  import ClAparatVideoPlayer from "@/components/players/ClAparatVideoPlayer.vue";
  import ClPlyrPlayer from "@/components/players/ClPlyrPlayer.vue";
  import ClVideoJSPlayer from "@/components/players/ClVideoJSPlayer.vue";

  const props = defineProps(['mdVideoData', 'player'])
</script>

<template>
  <div>
    <ClAparatVideoPlayer :aparat-token="mdVideoData.aparat_token" v-if="mdVideoData.md_video_type ==='aparat'" />
    <ClVideoJSPlayer :vodLink="mdVideoData.record_video_hls_path"  v-if="mdVideoData.md_video_type === 'vod' && player === 'videojs'"></ClVideoJSPlayer>
    <ClPlyrPlayer :vodLink="mdVideoData.record_video_hls_path" v-if="mdVideoData.md_video_type === 'vod' && player === 'plyr'"/>
  </div>
</template>

<style scoped lang="scss">

</style>