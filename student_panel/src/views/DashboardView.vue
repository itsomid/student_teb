<script setup>
import Dashboard from "@/components/dashboard/Dashboard.vue";
import {onMounted, onUnmounted} from "vue";
import {useStore} from "vuex";
import {useDisplay} from "vuetify";
const store = useStore();
const { lgAndUp } = useDisplay();

onMounted(()=>{
  store.dispatch('notificationStore/getUserNotification');
  if(lgAndUp.value) store.dispatch('dashboard/openNotificationDrawer');
})

onUnmounted(()=> {
  store.dispatch('dashboard/closeNotificationDrawer');
})
</script>
<template>
  <Dashboard />
</template>



