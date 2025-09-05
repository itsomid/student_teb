<script setup>
import { ref, computed, onMounted, watch } from "vue";
import { useRoute, useRouter } from "vue-router";
import { useStore } from "vuex";
import { useDisplay } from "vuetify";

import Chat from "@/components/chat/Chat.vue";
import ChatContact from "@/components/chat/ChatContact.vue";
import { useAlert } from "@/composable/useAlert";
import { useSocketService } from "@/composable/useSocket";
import { useUrl } from "@/composable/useUrl";
import RepositoryFactory from "@/repository/RepositoryFactory";

// Composables and utility functions
const { success, error } = useAlert();
const { defaultImageUrlBuilder, imageUrlBuilder } = useUrl();
const { connectSocket, requestToJoinChatServer, conversationHistoryListener, serverHistorySocketEmitter, receiveHistoryListener, serverRefreshChatBoxSocketEmitter, receiveMessageSocketListener, emitToGetServerHistoryListener } = useSocketService();
const { mdAndDown } = useDisplay();

// Vuex store and routing utilities
const store = useStore();
const route = useRoute();
const router = useRouter();

// Constants
const CHAT_STATUS = {
  READY_TO_CHAT: 'ok',
  USER_NOT_EXIST: 'error-user-not-exist',
  ERROR: 'error'
};

// Repositories
const ChatRepository = RepositoryFactory.get("Chat");

// Reactive state variables
const loading = ref(true);
const isValidToChat = ref(false);
const contact = ref([]);
const chatLog = ref([]);
const activeChat = ref('');
const profileUserData = ref({});
const mqShallShowLeftSidebar = ref(true);
const chatInputMessage = ref('');
const showChatOnMobile = ref(false);
const socketInstance = ref();
const chat = ref(null);

const pageNumber = ref(1);
const lastPage = ref(0);
const scrollIsPend = ref(false);
const searchQuery = ref('');

// Computed properties
const getUnreadMessageCount = computed(() => store.getters['chatStore/userChatUnreadMessage']);
const scrollbarTheme = computed(() => useDisplay().mdAndDown ? 'light' : 'dark');

// Initialize chat service and socket connection
function chatServiceInitializer() {
  const token = { access_token: localStorage.getItem('accessToken') };

  requestToJoinChatServer(token, (response) => {
    loading.value = true;

    switch (response.status) {
      case CHAT_STATUS.READY_TO_CHAT:
        success('ارتباط با سیستم چت برقرار است.');
        isValidToChat.value = true;
        break;
      case CHAT_STATUS.USER_NOT_EXIST:
        // Handle user not existing case
        break;
      case CHAT_STATUS.ERROR:
        error(`${response.message} مجددا تلاش کنید `);
        break;
    }

    loading.value = false;
  });
}

// Function to scroll to the last message in chat
function scrollToLastMessage() {
  setTimeout(() => {
    chat.value.scrollToLastMessage();
  }, 200);
}

// Listeners for socket events
const registerChatReceiveMessageListener = () => {
  receiveMessageSocketListener((response) => {
    if (response.chat_box_id === activeChat.value) {
      scrollToLastMessage();
      chatLog.value.push(response);
    }
  });
};

const registerReceiveHistoryListener = () => {
  receiveHistoryListener((allChatsFromActiveChat) => {
    chatLog.value = allChatsFromActiveChat;
    if (getUnreadMessageCount.value > 0) {
      // serverRefreshChatBoxSocketEmitter('', () => {
      //   store.dispatch("chatStore/getUserUnreadMessage");
      // });
    }
  });
};

const registerConversationHistoryListener = () => {
  conversationHistoryListener((response) => {
    if(Array.isArray(response)) contact.value.push(...response);
    else {
      const index = contact.value.findIndex((chat)=> chat._id === response._id)
      if(index > -1) {
        contact.value.splice(index, 1);
        contact.value.unshift(response);
        document.querySelector('#chat-contact').scrollTo({ top: 0, behavior: 'smooth' });
      }else {
        contact.value.unshift(response)
      }
    }
    if (route.params.user_id) {
      const userSelectFromLegacy = contact.value.find(value => value.admin_id === +route.params.user_id || value.student_id === +route.params.user_id);
      openSelectedChat(userSelectFromLegacy._id);
      router.replace({ name: "chat", params: { user_id: null } });
    }
  });
};

// Open a selected chat by user ID
const openSelectedChat = (userId) => {
  if (mdAndDown) showChatOnMobile.value = true;
  chatInputMessage.value = '';
  mqShallShowLeftSidebar.value = false;
  activeChat.value = userId;
  profileUserData.value = contact.value.find(value => value._id === userId);
  scrollToLastMessage();
  serverHistorySocketEmitter({ chat_box_id: profileUserData.value._id, page: 1 }, (response) => {
    console.log(response, '-----------');
  });
};

// Handle chat log updates
const updateChatLog = (event) => {
  bringToTop(event);
  chatLog.value.push(event);
};

// Remove a chat box by ID
const removeChatBox = async (id) => {
  try {
    const index = contact.value.findIndex(item => item._id === id);
    if (index !== -1) {
      await ChatRepository.deleteChat(id);
      contact.value.splice(index, 1);
    }
  } catch (e) {
    console.error("Error removing chat box:", e);
  }
};

// Fetch contacts from the server
const getContact = () => {
  loading.value = true;
  emitToGetServerHistoryListener({ page_number: pageNumber.value, filter_name: searchQuery.value || null }, (response) => {
    lastPage.value = response.lastPage;
    pageNumber.value += 1;
    scrollIsPend.value = false;
    loading.value = false;
  });
};

// Search contacts on the server
const searchInContactsFromServer = (query) => {
  pageNumber.value = 1;
  searchQuery.value = query;
  contact.value = [];
  getContact();
};

// Bring a chat to the top of the contact list
const bringToTop = (userChat) => {
  const indexFound = contact.value.findIndex(item => userChat.chat_box === item._id);
  if (indexFound > 0) {
    const itemFound = contact.value.splice(indexFound, 1)[0];
    contact.value.unshift(itemFound);
    document.querySelector('#chat-contact').scrollTo({ top: 0, behavior: 'smooth' });
  }
};

// Reset the chat state
const reset = () => {
  activeChat.value = false;
};

// Watcher for chat validity
watch(isValidToChat, (value) => {
  if (value) {
    getContact();
    registerChatReceiveMessageListener();
    registerConversationHistoryListener();
    registerReceiveHistoryListener();
  }
});

// On component mount, initialize the socket connection and chat service
onMounted(() => {
  socketInstance.value = connectSocket(() => {
    chatServiceInitializer();
  });
});
</script>

<template>
  <v-sheet color="transparent" style="flex: 1;">
    <v-row class="pt-2 d-flex align-stretch">
      <v-col cols="12" lg="3" class="cl-messenger">
        <ChatContact
            :items="contact"
            :last-page="lastPage"
            :page-number="pageNumber"
            :loading="loading"
            :profile-user-data="profileUserData"
            :active-chat-contact-id="activeChat || null"
            :mq-shall-show-left-sidebar.sync="mqShallShowLeftSidebar"
            @open-chat-boss="openSelectedChat($event)"
            @removeChatBox="removeChatBox"
            @fetchContactWithPaginate="getContact"
            @filterChatOfContact="searchInContactsFromServer($event)"
        />
      </v-col>

      <!-- Show chat for large screens -->
      <v-col v-if="$vuetify.display.lgAndUp" cols="12" lg="9" class="cl-messenger">
        <Chat
            v-if="isValidToChat"
            ref="chat"
            :chat="chatLog"
            :profile-user-data="profileUserData"
            :socket="socketInstance"
            @update-chat-log="updateChatLog"
        />
      </v-col>
    </v-row>

    <!-- Dialog for mobile view -->
    <v-dialog
        v-if="$vuetify.display.mdAndDown && profileUserData._id"
        v-model="showChatOnMobile"
        transition="slide-x-transition"
        fullscreen
    >
      <v-card>
        <Chat
            v-if="isValidToChat"
            ref="chat"
            :chat="chatLog"
            :profile-user-data="profileUserData"
            :socket="socketInstance"
            @update-chat-log="updateChatLog"
            @back-to-contact="showChatOnMobile = false"
        />
      </v-card>
    </v-dialog>
  </v-sheet>
</template>

<style scoped lang="scss">
.v-list-item__prepend {
  display: unset !important;
}
.cl-messenger {
  height: calc(100vh - 100px);
}
</style>
