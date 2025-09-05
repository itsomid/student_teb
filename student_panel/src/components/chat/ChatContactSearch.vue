<script setup>
import { useUrl } from "@/composable/useUrl";
import ChatAvatar from "@/components/chat/ChatAvatar.vue";
import {useStore} from "vuex";
import {computed} from "vue";
const props = defineProps(['loading']);

const { defaultImageUrlBuilder,imageUrlBuilder } = useUrl();

const search = defineModel({default: ""});

const store = useStore();
const userProfileImage = computed(()=> store.getters['userStore/userImage']);
</script>

<template>
  <v-toolbar color="card" class="px-3" >
    <ChatAvatar :show-badge="true"  :image="userProfileImage"/>
    <v-text-field
        id="search"
        v-model="search"
        label="جستجو"
        placeholder="نام کاربری یا شماره موبایل"
        type="text"
        class="mx-3"
        :hide-details="true"
        variant="solo"
        rounded
        density="compact"
        prepend-inner-icon="$mdiMagnify"
    >
      <template #append-inner>
        <v-progress-circular v-if="loading" size="25" width="2" color="primary" indeterminate />
      </template>
    </v-text-field>
  </v-toolbar>
</template>

<style scoped lang="scss">

</style>