<script setup>
import logo from "@/assets/images/logo/nav-logo.png"
import { LINKS } from "@/config/navigationDrawerItems.config";

import avatar from "@assets/images/default/avatars/avatar-default.png";

const  items = LINKS;


/**
 * Import the application's predefined themes configuration.
 * @type {Array<>}
 */

import useJwt from "@/composable/useJwt";
import {useNavigator} from "@/composable/useNavigator";
import {useRoute, useRouter} from "vue-router";
import {useThemeManager} from "@/composable/useThemeManager";
import router from "@/router";
import {computed, ref} from "vue";
import {useUrl} from "@/composable/useUrl";
import {useStore} from "vuex";
import NavigationDrawerDesktopSupport from "@/components/layouts/navigation-drawer/NavigationDrawerDesktopSupport.vue";


const store = useStore();
const { navigateToAuthAfterLogout,navigateToProfile } = useNavigator();
const logout = async () => {
  await useJwt.logout();
  await navigateToAuthAfterLogout();
}

const route = useRoute();

const isActiveLink = (item) => {
  const matchedRoute = route.matched.some(record => record.name === item.to.name);
  return matchedRoute;
}

const { changeTheme } = useThemeManager();

const { imageUrlBuilder } = useUrl();
const userImage = computed(()=> store.getters['userStore/userImage']);

const drawer = ref(false)
</script>

<template>
  <v-navigation-drawer
      aria-label="navigation"
      :scrim="false"
      permanent
      persistent
      rail
      rail-width="100"
      temporary>
    <template #prepend>
      <v-img width="20"  class="mx-auto mt-6 mb-6" :src="logo" alt="کلاسینو"/>
      <v-avatar role="button" :image="userImage ? imageUrlBuilder(userImage, 'USER_PROFILE') : avatar" class="mx-7 cursor-pointer" @click="navigateToProfile" />
    </template>
    <v-divider class="my-3 mx-5"/>
    <div   v-for="(item, index) in items"
           :key="'navigation-drawer-item-' + index "
           @click="router.push(item.to)"
           role="link"
    class="w-100 d-flex flex-column cursor-pointer justify-center align-center mb-1 nav-link-wrapper">
      <div class="position-absolute   nav-link" :class="{'active bg-primary opacity-30' : isActiveLink(item)}">
      </div>
     <div class="d-flex flex-column cursor-pointer justify-center align-center mb-3  " style="z-index: 2">
       <v-btn  color="transparent" rounded="pill" variant="text"  :to="item.to">
         <v-icon  size="24" :color="isActiveLink(item) ? 'primary' : 'onSurface'" :type="isActiveLink(item) ? 'bold' : 'linear'">
           {{ item.icon }}
         </v-icon>
       </v-btn>
       <span role="label" class="cl-navigation-drawer-item font-weight-bold mt-1" :class="{'text-primary' : isActiveLink(item)}">{{  item.text }}</span>
     </div>
    </div>


    <template #append>
      <div @click="drawer = !drawer;" role="button" class="cursor-pointer cl-navigation-drawer w-100 d-flex flex-column justify-center align-center mb-1 nav-link-wrapper">
        <div class="position-absolute nav-link" >
        </div>
        <div class="cursor-pointer cl-navigation-drawer w-100 d-flex flex-column justify-center align-center mb-3" style="z-index: 2">
          <v-btn color="transparent" rounded="pill" variant="text">
            <v-icon icon="cli:MessageQuestion" size="24"  color="onSurface">

            </v-icon>
          </v-btn>
          <span  class="cl-navigation-drawer-item font-weight-bold mt-1">پشتیبانی</span>
        </div>
      </div>
      <div  @click="changeTheme" role="button" class="cursor-pointer cl-navigation-drawer w-100 d-flex flex-column justify-center align-center mb-1 nav-link-wrapper">
        <div class="position-absolute nav-link" >
        </div>
        <div class="cursor-pointer cl-navigation-drawer w-100 d-flex flex-column justify-center align-center mb-3" style="z-index: 2">
          <v-btn color="transparent" rounded="pill" variant="text" >
            <v-icon size="24" color="onSurface" icon="cli:Moon">
            </v-icon>
          </v-btn>
<!--          <span class="cl-navigation-drawer-item font-weight-bold mt-1">حالت شب</span>-->
        </div>
      </div>
      <div  @click="logout" role="button" class="cursor-pointer cl-navigation-drawer w-100 d-flex flex-column justify-center align-center mb-1 nav-link-wrapper">
        <div class="position-absolute nav-link" >
        </div>
        <div class="cursor-pointer cl-navigation-drawer w-100 d-flex flex-column justify-center align-center mb-3" style="z-index: 2">
          <v-btn  color="transparent" rounded="pill" variant="text" >
            <v-icon size="24" color="onSurface" icon="cli:LogoutCurve">
            </v-icon>
          </v-btn>
<!--          <span class="cl-navigation-drawer-item font-weight-bold mt-1">خروج</span>-->
        </div>
      </div>
    </template>
  </v-navigation-drawer>

  <NavigationDrawerDesktopSupport v-model="drawer" />
</template>

<style scoped>
.nav-link {
  transition: all 0.1s linear;
  transform: scale(0);
}
.active {
  width: 40px;
  height: 40px;
  filter: blur(16px);
  transform: scale(1);
}

.nav-link-wrapper:hover .nav-link {
  width: 40px;
  height: 40px;
  filter: blur(16px);
  transform: scale(1);
  background-color: rgb(var(--v-theme-secondary-lighten-4));
  z-index: 1;
}

.nav-link-wrapper:active .nav-link{
  width: 40px;
  height: 40px;
  filter: blur(16px);
  transform: scale(1);
  background-color: rgb(var(--v-theme-primary));
  opacity: 0.3;
}
</style>