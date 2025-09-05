<script setup>

import DashboardNotificationEducationalClass
  from "@/components/dashboard/notifications/DashboardNotificationEducationalClass.vue";
import DashboardNotificationListItem from "@/components/dashboard/notifications/DashboardNotificationListItem.vue";
import {computed, onMounted} from "vue";
import {useNotifications} from "@/composable/notifications/useNotifications";
import {useStore} from "vuex";
import ClLoading from "@/components/base/ClLoading.vue";
import DashboardNotificationEmpty from "@/components/dashboard/notifications/DashboardNotificationEmpty.vue";

const store = useStore();
const {
  loading,
  getUserAllNotifications
} = useNotifications();

const notifications = computed(()=> store.getters['notificationStore/notifications']);


/**
 * Lifecycle hook called after the component has been mounted.
 * Fetches all user notifications.
 * @returns {Promise<void>}
 */
onMounted(async () => {
  await getUserAllNotifications('educational');
});

</script>

<template>
  <div class="position-relative" style="min-height: 200px">
    <ClLoading v-if="loading" />
    <v-list v-else>
     <div v-if="notifications.length">
       <template v-for="item in notifications" :key="'educational-notification-' + item._id" >
         <DashboardNotificationEducationalClass v-if="item.education_type === 'educational_class_delayed'" :item="item"/>
         <DashboardNotificationListItem v-else :item="item"  />
       </template>
     </div>
      <DashboardNotificationEmpty class="mt-16" v-else />
    </v-list>
  </div>
</template>

<style scoped lang="scss">

</style>