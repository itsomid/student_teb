<script setup>
import ChatAvatar from "@/components/chat/ChatAvatar.vue";
const props = defineProps(['item']);
const emits = defineEmits(['back-to-contact']);
</script>

<template>
  <v-toolbar color="card" class="px-3">
    <ChatAvatar :show-badge="true" :image="item.img_filename"/>
    <span class="mx-3">
      {{  item.name }}
    </span>
    <v-spacer />
    <v-btn v-if="$vuetify.display.mdAndDown" size="small" icon="$arrowLeft"  @click="emits('back-to-contact')">
    </v-btn>
  </v-toolbar>
</template>

<style scoped lang="scss">

</style>