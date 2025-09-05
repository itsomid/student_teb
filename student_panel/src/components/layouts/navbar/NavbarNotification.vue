<script setup>
import { useStore } from "vuex"; // Importing Vuex store
import {computed, ref, watch} from "vue"; // Importing computed function from Vue
import { useAlert } from "@/composable/useAlert"; // Importing alert composable
import RepositoryFactory from "@/repository/RepositoryFactory"; // Importing RepositoryFactory
import { useNavigator } from "@/composable/useNavigator";
import {useThemeManager} from "@/composable/useThemeManager";
import NotificationModal from "@/components/notification/NotificationModal.vue"; // Importing navigator composable


// Access the Vuex store
const store = useStore();

// Retrieve user data from the store using computed property
const count = computed(() => store.getters['notificationStore/count']);

// Retrieve notifications from the store using computed property
const hasNotificationModal = computed(() => store.getters['notificationStore/modalItems'].length ? true : false);
const notificationDialog =ref(false);

const notificationDrawer = computed(()=> store.getters['dashboard/notificationDrawer']);
const classDrawer = computed(()=> store.getters['dashboard/classDrawer']);
const { isDark } = useThemeManager();
const scrollbarTheme = computed(() => isDark.value ? 'dark' : 'light'); // Calculating scrollbar theme based on current theme


const openNotifications = ()=> {
  store.dispatch('dashboard/openNotificationDrawer');
}

const closeNotifications = ()=> {
  store.dispatch('dashboard/closeNotificationDrawer');
}

const toggleNotification = ()=> {
  if(notificationDrawer.value) {
    closeNotifications();
  }
  else {
    if(!classDrawer.value) openNotifications()
  }
}

watch(()=>hasNotificationModal.value,(value)=>{
  if(value) notificationDialog.value = true;
},{immediate:true})

</script>


<template>
  <!-- User profile badge with a dot -->
  <VBadge
      :model-value="!!count"
      location="top right"
      offset-x="3"
      offset-y="3"
      color="error"
      :content="count"
      role="menu"
      aria-label="notification"
  >
    <!-- Bell icon button -->
    <VBtn border rounded="lg" size="small" @click="toggleNotification"   aria-label="notification-btn" variant="text"  icon="$mdiBellOutline" >
    </VBtn>
    <NotificationModal v-model="notificationDialog"/>
  </VBadge>
</template>

<style scoped lang="scss">

</style>