<script setup>
import NavBar from "@/components/layouts/navbar/NavBar.vue";
import {onMounted, ref} from "vue";

import DashboardNotifications from "@/components/dashboard/notifications/DashboardNotifications.vue";
import DashboardNotificationModal from "@/components/dashboard/notifications/DashboardNotificationModal.vue";
import {useDisplay} from "vuetify";
import DashboardClassDrawer from "@/components/dashboard/class/DashboardClassDrawer.vue";

import NavigationDrawerDesktop from "@/components/layouts/navigation-drawer/NavigationDrawerDesktop.vue";
import NavigationDrawerMobile from "@/components/layouts/navigation-drawer/NavigationDrawerMobile.vue";
import BottomNavigationMenu from "@/components/layouts/BottomNavigationMenu.vue";
import {useRoute} from "vue-router";
// import Porsline from "@/components/porsline/Porsline.vue";
import {useCart} from "@/composable/useCart";
import AuthSetGradeModal from "@/components/authentication/AuthSetGradeModal.vue";

const drawer = ref(false);
const { lgAndUp } = useDisplay();
const route = useRoute();

const includedRoutesForBottomMenu = ['dashboard','my-courses','store.main','finance.main'];

const { trackUnpaidCartStatus } = useCart({});

onMounted(()=> trackUnpaidCartStatus())
</script>

<template>
  <v-responsive>
    <v-layout class="bg-background rounded rounded-md ss02" width="100vw" style="min-height: 100vh!important;">
      <!--    <HeaderBanner />-->


      <NavigationDrawerDesktop v-if="$vuetify.display.lgAndUp" />
      <NavigationDrawerMobile v-else v-model="drawer" />

      <div v-if="route.name === 'dashboard'">
        <DashboardClassDrawer />
      </div>

      <DashboardNotifications v-if="lgAndUp"></DashboardNotifications>
      <DashboardNotificationModal v-else/>

      <NavBar v-model="drawer"/>
      <v-main class="pb-16 mb-16">
        <v-container  fluid style="max-width: 1600px">
          <router-view v-slot="{ Component, route }">
            <v-fade-transition hide-on-leave mode="out-in">
              <component :is="Component" :key="route.path"  />
            </v-fade-transition>
          </router-view>
        </v-container>
        <BottomNavigationMenu v-if="$vuetify.display.mdAndDown && includedRoutesForBottomMenu.includes(route.name)"/>
<!--        <Porsline v-if="route.name === 'my-courses'"/>-->
        <AuthSetGradeModal />
      </v-main>
    </v-layout>
  </v-responsive>
</template>

<style>

</style>
