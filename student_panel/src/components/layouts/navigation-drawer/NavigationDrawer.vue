<script setup>
  import logo from "@/assets/images/logo/Logo.png"
  import { LINKS } from "@/config/navigationDrawerItems.config";
  import {useRoute} from "vue-router";
  import avatar from "@assets/images/default/avatars/avatar-default.png";
  import {computed } from "vue";
  import {useStore} from "vuex";
  import useJwt from "@/composable/useJwt";
  import {useNavigator} from "@/composable/useNavigator";
  import {useThemeManager} from "@/composable/useThemeManager";

  const route = useRoute();

  const drawer = defineModel();

  const  items = LINKS;

  const store = useStore();
  // Retrieve user data from the store using computed property
  const user = computed(() => store.getters['userStore/userData']);



  const { navigateToAuthAfterLogout } = useNavigator();
  const logout = async () => {
    await useJwt.logout();
    await navigateToAuthAfterLogout();
  }

  const { changeTheme } = useThemeManager();

</script>

<template>
  <v-navigation-drawer
      aria-label="navigation"
      :scrim="false"
      :expand-on-hover="$vuetify.display.mdAndDown"
      v-model="drawer"
      :permanent="$vuetify.display.lgAndUp"
      :rail="$vuetify.display.md"
      width="260"
      temporary>
    <template #prepend>
      <v-img width="200"  class="mx-auto my-6" :src="logo" />
      <v-card
          class="mx-3 mb-6"
          variant="tonal" border rounded="lg">
        <v-list-item :prepend-avatar="avatar">
          <v-list-item-title>
            {{ user.name}}
          </v-list-item-title>
        </v-list-item>
      </v-card>
    </template>
    <v-list role="navigation" nav  link rounded="0" class="" >
     <v-list-item
         v-for="(item, index) in items"
         :key="'navigation-drawer-item-' + index "
         link
         nav
         :to="item.to"
         active-class="active"
          rounded="pill "
         class=""
         :value="item"
         color="primary"
         :prepend-icon="item.icon"
         :title="item.text"
         role="link"
         aria-label="navigation-link"
     >
     </v-list-item>

    </v-list>

    <template #append>
      <div class="d-flex flex-row pa-4">
        <v-btn rounded="lg" variant="outlined" size="small" icon="$mdiMoonWaningCrescent" @click="changeTheme">

        </v-btn>
        <v-spacer/>
        <v-btn @click="logout" rounded="lg" variant="outlined" size="small" icon="$mdiLogout">

        </v-btn>
      </div>
    </template>
  </v-navigation-drawer>
</template>
