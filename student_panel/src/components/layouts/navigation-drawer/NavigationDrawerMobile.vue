<script setup>
import { MOBILE_LINKS} from "@/config/navigationDrawerItems.config";
import {useStore} from "vuex";
import {useNumberFormatter} from "@/composable/useNumberFormatter";
import {computed, onMounted, ref} from "vue";
import {useAlert} from "@/composable/useAlert";
import { useUrl } from "@/composable/useUrl";
import RepositoryFactory from "@/repository/RepositoryFactory";
import ClSupportSocialList from "@/components/layouts/support/ClSupportSocialList.vue";
import ClSupportContact from "@/components/layouts/support/ClSupportContact.vue";
import ClSupportGoftinoBtn from "@/components/layouts/support/ClSupportGoftinoBtn.vue";
import ClSupportReportBug from "@/components/layouts/support/ClSupportReportBug.vue";
const { error } = useAlert();
const { defaultImageUrlBuilder,imageUrlBuilder } = useUrl();



const drawer = defineModel();

const  items = MOBILE_LINKS;


const store = useStore();
// Retrieve user data from the store using computed property
const user = computed(() => store.getters['userStore/userData']);
const { numberFormatter } = useNumberFormatter();



/**
 * Import the application's predefined themes configuration.
 * @type {Array<>}
 */

import useJwt from "@/composable/useJwt";
import {useNavigator} from "@/composable/useNavigator";
import UserProfileThemeSwitcher from "@/components/layouts/navbar/UserProfileThemeSwitcher.vue";
import logo from "@assets/images/logo/Logo.png";
import {useThemeManager} from "@/composable/useThemeManager";



const { navigateToAuthAfterLogout } = useNavigator();
const logout = async () => {
  await useJwt.logout();
  await navigateToAuthAfterLogout();
}

const { isDark } = useThemeManager();

/**
 * Ref for storing the current course.
 * @type {import('vue').Ref<Object>}
 */
const customerSupport = ref({})

/**
 * Ref for tracking the loading state.
 * @type {import('vue').Ref<boolean>}
 */
const loading = ref(false);

/**
 * User repository instance.
 * @type {import('@/repository/Repository').default}
 */
const UserRepository = RepositoryFactory.get("User");

/**
 * Function to fetch user courses from the repository.
 * @async
 * @function
 * @returns {Promise<void>}
 */
const getUserSupport = async () =>{
  try {
    loading.value = true;
    const { data: { data } } = await UserRepository.userSupport();
    customerSupport.value = data;
  }catch (e) {
    error(e.error?.message);
  }finally {
    loading.value = false;
  }
};

const openPwaWizard = ()=>{
  store.dispatch('pwaWizard/openDialog');
}

onMounted(()=> {
  getUserSupport();
})
</script>

<template>
  <v-navigation-drawer
      aria-label="navigation"
      :scrim="true"
      v-model="drawer"
      width="300"
      elevation="0"
      class="border-left"
  >
    <v-img width="200"  class="mx-auto my-6" :src="logo" />
    <v-list role="navigation" nav  link rounded="0" class="mt-3" >
      <v-list-item
          v-for="(item, index) in items"
          :key="'navigation-drawer-item-' + index "
          link
          nav
          :to="item.to"
          active-class="active"
          rounded="pill "
          class=""
          color="primary"
          :prepend-icon="item.icon"
          :title="item.text"
          role="link"
          aria-label="navigation-link">
      </v-list-item>
      <v-list-item
          nav
          :to="{ name: 'finance'}"
          active-class="active"
          rounded="pill "
          class=""
          color="primary"
          prepend-icon="$mdiAccountCreditCardOutline"
          title="اعتبار"
          role="link"
          aria-label="navigation-link"
      >
        <template #append>
          {{numberFormatter(user.credit)}} ریال
        </template>
      </v-list-item>
      <v-list-item
          nav
          @click="openPwaWizard"
          active-class="active"
          rounded="pill "
          class=""
          color="primary"
          prepend-icon="$mdiCellphoneArrowDownVariant"
          title="راهنمای نصب کلاسینو"
          role="link"
          aria-label="navigation-link"
      >
      </v-list-item>
      <v-divider />

    </v-list>
    <ClSupportSocialList v-if="customerSupport.data" :customer-support="customerSupport" />

    <ClSupportContact />

    <ClSupportGoftinoBtn />

    <ClSupportReportBug />
    <template #append>
      <v-list-item
          nav
          active-class="active"
          rounded="pill "
          class=""
          color="primary"
          :prepend-icon="isDark ? '$mdiMoonWaxingCrescent' : '$mdiWeatherSunny'"
          title="حالت شب"
          role="link"
          aria-label="navigation-link"
      >
        <template #append>
          <UserProfileThemeSwitcher />
        </template>
      </v-list-item>

      <!-- Logout link -->
      <VListItem @click="logout" class="mb-6">
        <template #prepend>
          <VIcon
              class="me-2"
              icon="$mdiLogout"
              size="22"
          />
        </template>

        <VListItemTitle>خروج</VListItemTitle>
      </VListItem>
    </template>
  </v-navigation-drawer>
</template>

<style scoped lang="scss">
.border-left {
  border-top-left-radius: 24px;
  border-bottom-left-radius: 24px;

}
</style>