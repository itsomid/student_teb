<script setup>
import ChatAvatar from "@/components/chat/ChatAvatar.vue";
import {useDateFormatter} from "@/composable/useDate";
import {ref} from "vue";
import ChatContactItemMenu from "@/components/chat/ChatContactItemMenu.vue";

const emits = defineEmits(['open-chat', 'remove-chat-box'])

const props = defineProps({
  item: {
    type: Object,
    required: true,
  }
})

const STATUS = {
  offline: "error",
  online: "success"
}



const menu = ref(false);
const event = ref(null);
const removeHtmlTags = (input)=> {
  return input.replace(/<\/?[^>]+(>|$)/g, "");
}
const showMenu = (e) => {
  event.value = e;
  e.preventDefault();
  menu.value = true;
}

const removeChat = (id) => {
  emits("remove-chat-box", id);
}

</script>

<template>
  <v-list-item
      :nav="true"
      :value="item._id"
      rounded="xl"
      class="pa-3 pl-4"
      :slim="true"
      @click="emits('open-chat', item._id)"
      @contextmenu="showMenu"
  >
    <template v-slot:prepend>
      <ChatAvatar :show-badge="true" :image="item.img_filename" :color="STATUS[item.user_status]"/>
    </template>
    <v-list-item-title class="d-flex flex-row justify-space-between">
      <div>
        {{ item.name }}
        <span v-if="item.role === 'admin'">({{ item.student_id }}#)</span>
      </div>
      <v-badge
          v-if="item.unread_message_count > 0"
          color="error"
          bottom
          left
          :inline=" true"
          :content="item.unread_message_count"
      >
      </v-badge>
    </v-list-item-title>
    <v-list-item-subtitle v-if="item.last_message" class="mt-1" v-html="removeHtmlTags(item.last_message.text)">
    </v-list-item-subtitle>
    <v-list-item-subtitle v-if="item.last_message" class="text-end text-secondary text-caption mt-2">
      {{ useDateFormatter(item.last_message.created_at, "CHAT")}}
    </v-list-item-subtitle>
    <ChatContactItemMenu v-model="menu" :e="event" :user_id="item._id" @remove="removeChat" />
  </v-list-item>

</template>

<style scoped lang="scss">

</style>