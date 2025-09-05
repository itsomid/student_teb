<script setup>

import {computed} from "vue";
import { useStore } from "vuex";
const store = useStore();

const count = computed(()=> store.getters['chatStore/userChatUnreadMessage']);

</script>

<template>
  <VBadge
      :model-value="!!count"
      location="top right"
      offset-x="3"
      offset-y="3"
      color="error"
      :content="count"
      aria-label="chat"

  >
    <VBtn border rounded="lg" class="mx-1" size="small" aria-label="chat-btn" variant="text"  icon="$mdiChatOutline" :to="{name : 'chat'}">
    </VBtn>
  </VBadge>
</template>

<style scoped lang="scss">

</style>