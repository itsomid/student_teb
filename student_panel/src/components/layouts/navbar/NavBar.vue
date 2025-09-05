<script setup>
import NavbarCart from "@/components/layouts/navbar/NavbarCart.vue";
import {computed, onMounted, ref, watch} from "vue";
import { useStore } from "vuex";
import NavbarChat from "@/components/layouts/navbar/NavbarChat.vue";
import NavbarNotification from "@/components/layouts/navbar/NavbarNotification.vue";
import {useRoute, useRouter} from "vue-router";
import {NAVBAR_ACTIONS} from "@/constants/navbarActions.const";

const store = useStore();

onMounted(()=>{
  store.dispatch('userStore/updateProfile');
  store.dispatch('cartStore/getCartCount');
  store.dispatch('chatStore/getUserUnreadMessage');
  // store.dispatch('notificationStore/getUserNotification');
})

const drawer = defineModel({default: true});
const page = computed(()=> store.getters['navbar/title'] || route.meta.title);
const route = useRoute();
const router = useRouter();
const ACTIONS = ref(null);
const changeActions = (actions)=> {
  ACTIONS.value = actions ? actions : NAVBAR_ACTIONS;
}
watch(()=>route.meta.actions, (value)=> {
  changeActions(value);
}, { immediate : true})

onMounted(
    ()=> {
     changeActions(route.meta.actions)
    })

const back = ()=> {
  if(route.name === 'answer-sheet') router.push({name: 'dashboard'});
  else {
    if (router?.historyStack?.length > 0) {
      router.back();
    } else {
      router.push({ name: 'store'})
    }
  }
};
</script>

<template>
  <v-app-bar
      flat
      color="background"
      :height="$vuetify.display.lgAndUp ? 80 : 70"
      class="px-2 px-lg-4"
      >
    <template #prepend>
      <v-app-bar-nav-icon v-if="$vuetify.display.mdAndDown && !ACTIONS.BACK" @click="drawer = !drawer" aria-label="hamburger-btn" role="button"></v-app-bar-nav-icon>
    </template>

    <v-btn size="small" class="mx-1" icon="$mdiChevronRight" v-if="ACTIONS.BACK" @click="back" />

    <h1 class="text-subtitle-1 text-lg-h5  font-weight-bold" >
      {{ page }}
    </h1>
    <v-spacer></v-spacer>

<!--    <v-btn v-if="route.name === 'dashboard'" href="https://student.classino.com/" variant="tonal" color="primary" rounded="lg" border="primary sm opacity-100" height="38" class="mx-1">پنل قدیم</v-btn>-->

    <NavbarNotification v-if="ACTIONS.NOTIFICATIONS" />

    <NavbarChat v-if="ACTIONS.CHAT" />

    <NavbarCart v-if="ACTIONS.CART"/>



  </v-app-bar>
</template>

<style scoped lang="scss">

</style>