<script setup>
import { useUrl } from "@/composable/useUrl";
import { debounce } from 'lodash';
const { defaultImageUrlBuilder,imageUrlBuilder } = useUrl();
import ChatContactSearch from "@/components/chat/ChatContactSearch.vue";
import ChatContactItem from "@/components/chat/ChatContactItem.vue";
import {ref, watch} from "vue";

const emits = defineEmits(['open-chat-boss', 'remove-chat-box', 'fetchContactWithPaginate','filterChatOfContact']);

const props = defineProps({
  items: {
    type: Array,
    required: true,
  },
  profileUserData: {
    type: Object,
    required: true,
  },
  loading: {
    type: Boolean,
    required: true,
  },
  activeChatContactId: {
    type: String,
    default: null,
  },
  lastPage: {
    type: [String, Number],
    default: null,
  },
  pageNumber: {
    type: [String, Number],
    default: null,
  },
  mqShallShowLeftSidebar: {
    type: Boolean,
    required: true,
  }
})


const isIntersectingBottom = ref(false);
const onIntersect = (isIntersecting, entries, observer) => {
  // More information about these options
  // is located here: https://developer.mozilla.org/en-US/docs/Web/API/Intersection_Observer_API
  isIntersectingBottom.value = isIntersecting;
  if(isIntersectingBottom.value) emits('fetchContactWithPaginate');
};

const openChat = (event) => {
  emits('open-chat-boss', event);
}

const removeChatBox = (event) => {
  emits('remove-chat-box', event);
}

const search = ref('');



const searchCharacterHandler = (query) => {
  // Simulate an API call
  emits('filterChatOfContact',query)
};

// Create a debounced version of the search method
const debouncedSearch = debounce(searchCharacterHandler, 600); // Debounce delay of 300ms

watch(search, (newQuery) => {
  debouncedSearch(newQuery);
});
</script>

<template>
  <v-card height="100%" flat border rounded class="rounded-xl pb-16" >
    <ChatContactSearch v-model="search" :loading="loading" />
    <v-card-text id="chat-contact" style="height: 100%;" class="overflow-auto">
      <v-list nav="" color="primary" rounded>
        <v-list-subheader class="text-h5 text-primary">
          گفتگو‌ها
        </v-list-subheader>
        <ChatContactItem
            v-for="item in items"
            :key="item._id"
            :item="item"
            @open-chat="openChat"
            @remove-chat-box="removeChatBox"
        />
        <v-card  height="35" flat  v-if="items.length && lastPage >1 && pageNumber -1 <= lastPage" v-intersect="onIntersect" :loading="loading">
          <template #loader>
           <div class="w-100 d-flex justify-center">
             <v-progress-circular size="20" width="2" color="primary" indeterminate/>
           </div>
          </template>
        </v-card>
      </v-list>
    </v-card-text>
  </v-card>
</template>

<style scoped lang="scss">

</style>