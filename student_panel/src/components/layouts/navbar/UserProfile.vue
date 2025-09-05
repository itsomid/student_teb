<script setup>
import avatar from '@assets/images/default/avatars/avatar-default.png';
import { useStore } from "vuex";
import { computed } from "vue";
import { useNumberFormatter } from "@/composable/useNumberFormatter";
import UserProfileThemeSwitcher from "@/components/layouts/navbar/UserProfileThemeSwitcher.vue";
import useJwt from "@/composable/useJwt";
import { useNavigator } from "@/composable/useNavigator";
// Access the Vuex store
const store = useStore();

// Retrieve user data from the store using computed property
const user = computed(() => store.getters['userStore/userData']);

// Use the number formatter composable to format the user's credit
const { numberFormatter } = useNumberFormatter();

const { navigateToAuthAfterLogout } = useNavigator();

const logout = async () => {
  await useJwt.logout();
  await navigateToAuthAfterLogout();
}
</script>

<template>
  <!-- User profile badge with a dot -->
  <VBadge
      dot
      location="bottom right"
      offset-x="3"
      offset-y="3"
      color="success"
      class="mx-3"
      bordered
      name="profile"
      role="button"
      aria-label="profile"
  >
    <!-- User avatar inside an avatar with an outlined style -->
    <VAvatar
        class="cursor-pointer"
        color="primary"
        variant="text"
    >
      <!-- User avatar image -->
      <VImg :src="avatar" alt="user profile"/>

      <!-- User profile menu -->
      <VMenu
          :close-on-content-click="false"
          activator="parent"
          width="250"
          location="bottom end"
          offset="20px"
      >
        <!-- List of menu options -->
        <VList density="compact" rounded="xl">
          <!-- User Avatar & Name section -->
          <VListItem>
            <template #prepend>
              <!-- Badge with dot for user avatar -->
              <VListItemAction start>
                <VBadge
                    dot
                    location="bottom right"
                    offset-x="3"
                    offset-y="3"
                    color="success"
                >
                  <!-- Tonal avatar for user's profile -->
                  <VAvatar
                      color="primary"
                  >
                    <!-- User avatar image -->
                    <VImg :src="avatar" />
                  </VAvatar>
                </VBadge>
              </VListItemAction>
            </template>

            <!-- User name and subtitle -->
            <VListItemTitle class="font-weight-semibold">
              {{ user.name }}
            </VListItemTitle>
            <VListItemSubtitle>دانش آموز</VListItemSubtitle>
          </VListItem>

          <!-- Divider between sections -->
          <VDivider class="my-2" />

          <!-- Profile link -->
          <VListItem link :to="{ name : 'profile' }">
            <template #prepend>
              <VIcon
                  icon="$mdiAccountOutline"
                  size="22"
              />
            </template>

            <VListItemTitle >پروفایل</VListItemTitle>
          </VListItem>

          <!-- Credit link with formatted credit information -->
          <VListItem link>
            <template #prepend>
              <VIcon
                  icon="$mdiCurrencyUsd"
                  size="22"
              />
            </template>

            <VListItemTitle>
              <span>اعتبار:</span>
              <span class="text-subtitle-2 font-weight-bold mr-1">{{numberFormatter(user.credit)}} ریال</span>
            </VListItemTitle>
          </VListItem>

          <!-- Theme changer using UserProfileThemeSwitcher component -->
          <VListItem link >
            <template #prepend>
              <VIcon
                  icon="$mdiThemeLightDark"
                  size="22"
              />
            </template>
            <UserProfileThemeSwitcher />
          </VListItem>


          <!-- Divider between sections -->
          <VDivider class="my-2" />

          <!-- Logout link -->
          <VListItem @click="logout">
            <template #prepend>
              <VIcon
                  class="me-2"
                  icon="$mdiLogout"
                  size="22"
              />
            </template>

            <VListItemTitle>خروج</VListItemTitle>
          </VListItem>
        </VList>
      </VMenu>
    </VAvatar>
  </VBadge>
</template>

<style scoped lang="scss">

</style>