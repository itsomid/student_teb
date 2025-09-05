<script setup>
  import { onMounted, onBeforeUnmount } from 'vue';
  import {useVoiceRecorder} from "@/composable/useVoiceRecorder";
  const props = defineProps(['socket','destinationMessage']);

  const emits = defineEmits(['update-voice-message'])
  const { isRecording,startRecording, stopRecording, formattedTime } = useVoiceRecorder(props.socket, props.destinationMessage,{emits});
  const actionHandler = (isRecording) => {
    isRecording ? stopRecording() : startRecording();
  }

  onMounted(() => {

  });

  onBeforeUnmount(() => {
    stopRecording(); // Ensure recording
  });
</script>

<template>
  <div>
    <v-badge v-model="isRecording" :dot="!isRecording" size="x-small" offset-y="6" offset-x="10" location="top right" color="error">
      <template #badge>
        <div v-if="isRecording">
          {{ formattedTime }}
        </div>
      </template>
      <v-btn @click="actionHandler(isRecording)" :icon="isRecording ? '$mdiStop' : '$mdiMicrophone'" color="secondary"/>
    </v-badge>
  </div>

</template>

<style scoped lang="scss">

</style>