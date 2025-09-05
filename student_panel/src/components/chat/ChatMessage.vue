<script setup>
import { computed } from "vue";
import { useStore } from "vuex";
import { useTheme } from "vuetify";
import ChatAvatar from "@/components/chat/ChatAvatar.vue";
import ClImage from "@/components/base/ClImage.vue";
import { DEFAULT_IMAGE_PATH } from "@/config/filePath.config";
import { useDateFormatter } from "../../composable/useDate";
import { useUrl } from "@/composable/useUrl";
import { useThemeManager } from "@/composable/useThemeManager";
import { useUtils } from "@/composable/useUtils";

const props = defineProps({
  message: {
    type: Object,
    required: true,
  },
});

const theme = useTheme();
const { isDark } = useThemeManager();
const { fileUrlBuilder } = useUrl();
const { isImageFile } = useUtils();
const store = useStore();

const cardTheme = computed(() =>
    theme.global.current.value.dark ? "bg-dark" : "bg-white"
);

const user = computed(() => store.getters["userStore/userData"]);

const isCurrentUserOwnerMessage = computed(() =>
    props.message.user_id === user.value.id
);

const downloadFile = (filename) => fileUrlBuilder(filename, "CHAT");
</script>

<template>
  <!-- Main container for the message block, layout is flex-direction based on whether the user is the owner -->
  <div
      class="d-flex mb-3"
      :class="isCurrentUserOwnerMessage ? 'flex-row' : 'flex-row-reverse'"
  >
    <!-- Avatar component showing the user's image -->
    <ChatAvatar :image="message.user_data?.img_filename" />

    <!-- Card component for displaying the message content if it's not an audio file -->
    <v-card
        v-if="message.media_type !== 'audio/mpeg'"
        :color="isCurrentUserOwnerMessage ? 'primary' : 'secondary-darken-1'"
        :variant="isDark ? 'flat' : 'tonal'"
        rounded="lg"
        class="mx-3"
        :class="[isCurrentUserOwnerMessage ? 'rounded-ts-shaped' : 'rounded-te-shaped', cardTheme]"
    >
      <!-- Message text content, formatted in bold and with padding -->
      <v-card-text v-html="message.text" class="font-weight-bold pa-3 pb-0"></v-card-text>

      <!-- Subtitle section containing download link, icons, and timestamp -->
      <v-card-subtitle class="d-flex flex-row px-2 mt-1">
        <!-- Download icon and link for file attachments -->
        <a v-if="message.file" :href="downloadFile(message.file)" target="_blank">
          <i class="icon-CL_download text-indigo-darken-4 text-20"></i>
        </a>

        <!-- Status icons indicating whether the message is read or unread -->
        <small v-if="isCurrentUserOwnerMessage" class="ml-3">
          <v-icon v-if="message.unread" color="secondary" size="18">$mdiCheck</v-icon>
          <v-icon v-else size="18" color="primary">$mdiCheckAll</v-icon>
        </small>

        <!-- Spacer for aligning elements to the left or right -->
        <v-spacer />

        <!-- Timestamp of when the message was created -->
        <small
            :class="{'float-left': message.user_id === user.id}"
            class="mb-25 chat-time"
        >
          {{ useDateFormatter(message.created_at) }}
        </small>
      </v-card-subtitle>

      <!-- Image preview for attached files if they are images -->
      <div v-if="message.file && isImageFile(message.file)" class="d-block">
        <ClImage
            path="CHAT"
            :default-image="DEFAULT_IMAGE_PATH.PRODUCTS"
            :alt="message.file"
            :image="message.file"
        />
      </div>
    </v-card>

    <!-- Audio player for playing audio files if the message contains audio -->
    <audio v-else controls preload="none" class="chat-voice-audio-player">
      <source :src="downloadFile(message.file)" type="audio/mpeg" />
    </audio>
  </div>
</template>

<style scoped lang="scss">
/* Add any scoped styles here */
</style>
