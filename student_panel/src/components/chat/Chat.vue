<script setup>
import { computed } from "vue";
import { useTheme, useGoTo } from "vuetify";

import ChatHeader from "@/components/chat/ChatHeader.vue";
import ChatActions from "@/components/chat/ChatActions.vue";
import ChatMessage from "@/components/chat/ChatMessage.vue";
import {useStore} from "vuex";

const props = defineProps(['chat', 'socket', 'profileUserData']);
const emits = defineEmits(['update-chat-log', 'back-to-contact']);

// Theme and scrollbar configuration
const theme = useTheme();
const scrollbarTheme = computed(() => theme.global.current.value.dark ? 'dark' : 'light');

// Scroll options for smooth scrolling behavior
const goTo = useGoTo();
const scrollOptions = {
  container: '#chat-log-container',
  duration: 600,
  easing: 'easeInOutCubic',
  offset: 0,
};

// Function to scroll to the last message in the chat log
function scrollToLastMessage() {
  goTo('#last-message', scrollOptions);
  document.querySelector('#last-message').scrollTo({ top: 0, behavior: 'smooth' });
}

// Emits event to update the chat log and scrolls to the last message
const updateChatLog = (event) => {
  emits('update-chat-log', event);
  scrollToLastMessage();
};

// Expose the scroll function to the parent component
defineExpose({ scrollToLastMessage });

const store = useStore();
const user = computed(() => store.getters['userStore/userData']);

const destinationMessage = computed(()=> user.value.id === props.profileUserData.admin_id ? props.profileUserData.student_id : props.profileUserData.admin_id );

</script>

<template>
  <v-card height="100%" flat border :rounded="$vuetify.display.mdAndDown ? 0 : 'xl'" class="d-flex flex-column">
    <!-- Header for the chat component with a back button -->
    <ChatHeader v-if="destinationMessage" @back-to-contact="emits('back-to-contact')" :item="profileUserData"/>

    <!-- Chat log container with dynamic theme-based scrollbar -->
    <v-card-text id="chat-log-container" class="chat-background  overflow-auto" :class="scrollbarTheme">
      <!-- Display each chat message -->
      <template v-if="destinationMessage">
        <ChatMessage v-for="message in chat" :key="message.id" :message="message"/>
      </template>
      <div v-else class="h-100 d-flex justify-center align-center">
        <v-card variant="flat" flat rounded="xl" border class="pa-8 text-center">
          <v-icon size="80">$mdiChatOutline</v-icon>
          <v-card-subtitle class="mt-4">
            یکی از چت سمت راست را انتخاب کنید.
          </v-card-subtitle>
        </v-card>
      </div>
      <!-- Placeholder element to scroll to the last message -->
      <div class="mt-16" id="last-message"></div>
    </v-card-text>

    <!-- Actions section for sending messages or performing other chat-related actions -->
    <ChatActions v-if="destinationMessage" :socket="socket" :profile-user-data="profileUserData" @update-message="updateChatLog"/>
  </v-card>
</template>

<style scoped lang="scss">
/* Add your scoped styles here */

</style>
