<script setup>
import {computed, onMounted, ref} from "vue";
import {useStore} from "vuex";
import DashboardNotificationTabs from "@/components/dashboard/notifications/DashboardNotificationTabs.vue";
const store = useStore();
const notificationModal = computed(()=> store.getters['dashboard/notificationDrawer']);
const closeNotifications = ()=> {
  store.dispatch('dashboard/closeNotificationDrawer')
}
const transition = ref('slide-x-reverse-transition');
onMounted(()=>{
  setTimeout(()=>{
    transition.value = 'slide-x-transition';
  },200);
  closeNotifications();
})
</script>

<template>
  <div class="text-center ">
    <v-dialog
        v-model="notificationModal"
        :transition="transition"
        fullscreen
    >
      <v-card>
        <v-toolbar color="transparent">
          <v-btn
              icon="$mdiChevronRight"
              @click="closeNotifications"
          ></v-btn>

          <v-toolbar-title>
            اعلان‌ها
          </v-toolbar-title>

          <v-spacer></v-spacer>

        </v-toolbar>

        <DashboardNotificationTabs />
      </v-card>
    </v-dialog>
  </div>
</template>

<style scoped lang="scss">

</style>