<script setup>
import { useStore } from 'vuex';
import {computed, ref, watch} from 'vue';
import DashboardNotificationTabs from '@/components/dashboard/notifications/DashboardNotificationTabs.vue';

const store = useStore();
const notificationDrawer = computed(() => store.getters['dashboard/notificationDrawer']);

// Methods
const closeNotifications = () => {
  store.dispatch('dashboard/returnToNotifications');
};

const markAsReadNotifications = ()=> {
  store.dispatch('notificationStore/markAsReadNotifications');
}

</script>


<template>
  <!-- Navigation Drawer for Notifications -->
  <v-navigation-drawer
      v-model="notificationDrawer"
      :width="$vuetify.display.lgAndUp ? 460 : 336"
      :class="$vuetify.display.lgAndUp ? '' : 'rounded-bs-xl rounded-ts-xl'"
      border="0"
      location="left"
      color="surface"
  >
    <!-- Drawer Prepend Section -->
    <template #prepend>
      <!-- Close Button for Small and Medium Screens -->
      <div v-if="$vuetify.display.mdAndDown" class="pa-4">
        <v-btn @click="closeNotifications" size="small" variant="text" icon="$mdiClose"/>
      </div>
      <!-- Toolbar with Notifications Title and Clear All Button -->
      <v-toolbar height="36" color="transparent" class="pa-8">
        <v-icon>$mdiBellOutline</v-icon>
        <span>اعلان‌ها</span>
        <v-spacer></v-spacer>
        <v-btn @click="markAsReadNotifications" variant="text" border  rounded="lg">
          <v-icon size="small" class="ml-1">$mdiChatOutline</v-icon>
همه خوانده شده
        </v-btn>
      </v-toolbar>
    </template>


    <!-- Notifications Tabs -->

    <div class="overflow-scroll position-relative nav-container">
      <DashboardNotificationTabs />
    </div>
  </v-navigation-drawer>
</template>

<style scoped lang="scss">
  .nav-container {
    max-height: calc(100vh - 100px);
  }
</style>