<script setup>
import useDashboardNotifications from '@/composable/dashboard/useDashboardNotifications';
import {computed, onMounted, ref} from "vue";
import {useNotifications} from "@/composable/notifications/useNotifications";
import {useStore} from "vuex";


// Destructure selection and tabs from the useDashboardNotifications composable
const { selection, tabs } = useDashboardNotifications();
const { clearNotifications } = useNotifications();
const store = useStore();
const unreadCount = computed(()=> store.getters['notificationStore/unreadCount']);

</script>


<template>
  <div class="px-3 px-lg-8">
    <!-- Chip Group for Notification Tabs -->
    <v-chip-group  v-model="selection" :show-arrows="false" class="position-sticky sticky-container bg-surface" mobile>
      <!-- Iterate over tabs to create individual chips -->
     <div class="border rounded-lg  mx-auto bg-surface">
       <v-chip
           v-for="(item, index) in tabs"
           :key="'notification-tabs-' + index"
           rounded="lg"
           :value="item.value"
           selected-class="border bg-transparent"
           variant="text"
           style="width: 110px"
           label
           @click.stop="clearNotifications"
       >
         <!-- Chip Icon -->
         <v-icon color="primary" class="ml-1">{{ item.icon }}</v-icon>
         <!-- Chip Text -->
         {{ item.text }}

        <v-slide-y-transition>
           <span v-if="selection === item.value && item.id !== 'suggestions' && unreadCount" class="border notification-badge mr-1">
           {{ unreadCount }}
            </span>
        </v-slide-y-transition>
       </v-chip>
     </div>
    </v-chip-group>

    <!-- Dynamic Component based on the selected tab -->
    <component :is="selection"  />
  </div>
</template>

<style scoped lang="scss">
.sticky-container {
  position: sticky!important;
  top: 0px!important; /* You can adjust this depending on the desired offset */
  z-index: 10; /* Ensures it stays above other content */
  background-color: white; /* Optional: background color to match design */
  padding-top: 10px;
}

/* Add scoped styles here */
.notification-badge {
  width: 16px;
  height: 16px;
  font-size: 12px;
  border-radius: 5px;
  text-align: center;
  line-height: 16px;
}
</style>
