<script setup>
import {useSocketService} from "@/composable/useSocket";
import {computed, ref, watch} from "vue";
import {useStore} from "vuex";
import {useAlert} from "@/composable/useAlert";
import ChatActionVoiceRecorder from "@/components/chat/ChatActionVoiceRecorder.vue";
import ChatActionFileUpload from "@/components/chat/ChatActionFileUpload.vue";
const { serverSendMessageEmitter } = useSocketService();

const props = defineProps(['socket', 'profileUserData']);
const emits = defineEmits(['update-message'])
const text = defineModel({
  default: ""
})

const { error } = useAlert();

const store = useStore();

// Retrieve user data from the store using computed property
const user = computed(() => store.getters['userStore/userData']);

const destinationMessage = computed(()=> user.value.id === props.profileUserData.admin_id ? props.profileUserData.student_id : props.profileUserData.admin_id );

const loading = ref(false);

const updateChatLog = (data) => emits('update-message', data);

const sendTextMessage = (message, file , mediaType )=> {
  loading.value = true;
  serverSendMessageEmitter(
      props.socket,
      {
        to: destinationMessage.value,
        file: file,
        message: message,
        media_type: mediaType,
      },
      (response) => {
        loading.value = false;
        if(response.status.toLowerCase() === 'ok') updateChatLog(response.data);
        else error(response.message)
      }
  );
  text.value = "";
}

</script>

<template>
  <v-card-actions class="border-t  d-flex flex-row align-center justify-center">
    <v-form class="d-flex flex-row w-100 justify-center align-center">
      <v-text-field  v-model="text" class=" elevation-0" :hide-details="true" placeholder="پیام خود را وارد کنید." variant="outlined" rounded >
        <template #append-inner>
          <ChatActionVoiceRecorder
              v-if="destinationMessage"
              @update-voice-message="updateChatLog"
              :destinationMessage="destinationMessage"
              :socket="socket" />
          <ChatActionFileUpload
              v-if="destinationMessage"
              @update-file-message="updateChatLog"
              :destinationMessage="destinationMessage"
              :socket="socket"  />
        </template>
        <template #prepend-inner>
          <v-btn
              :disabled="!destinationMessage"
              size="x-small"
              type="submit" @submit.prevent="sendTextMessage(text.trim())"
              icon="$mdiSend"
              @click.prevent="sendTextMessage(text.trim())"
              :loading="loading">
          </v-btn>
        </template>
      </v-text-field>
  </v-form>
  </v-card-actions>
</template>

<style scoped lang="scss">

</style>