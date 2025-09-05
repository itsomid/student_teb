<script setup>
import { onMounted, ref } from "vue";
import RepositoryFactory from "@/repository/RepositoryFactory";
import { useAlert } from "@/composable/useAlert";
import NotificationItem from "@/components/notification/NotificationItem.vue";
import ClPagination from "@/components/app/ClPagination.vue";
import { useRoute, useRouter } from "vue-router";
import { usePagination } from "@/composable/usePagination";
import NotificationEmpty from "@/components/notification/NotificationEmpty.vue";
import { PAGINATION } from "@/constants/pagination.const";
import { NOTIFICATION_TYPES } from "@/schema/notification/NOTIFICATION_TYPES.schema";

const { error } = useAlert();

/**
 * Array containing all notification types.
 * @type {Array<{title: string, value: string}>}
 */
const tabs = NOTIFICATION_TYPES;

/**
 * Reference for the currently selected tab.
 * @type {import('vue').Ref<string>}
 */
const tab = ref("");

/**
 * Reference for the list of notifications.
 * @type {import('vue').Ref<Array>}
 */
const notifications = ref([]);

/**
 * Reference for the list of filtered notifications.
 * @type {import('vue').Ref<Array>}
 */
const filteredNotifications = ref([]);

/**
 * Reference for the current page number.
 * @type {import('vue').Ref<number>}
 */
const page = ref(1);

/**
 * Constant for the number of items per page.
 * @type {number}
 */
const ITEM_PER_PAGE = PAGINATION.ITEMS_PER_PAGE;

/**
 * Object containing pagination utilities.
 * @type {Object}
 */
const { paginateFactory } = usePagination();

/**
 * Vue router's route object.
 * @type {import('vue-router').RouteLocationRaw}
 */
const route = useRoute();

/**
 * Vue router instance.
 * @type {import('vue-router').Router}
 */
const router = useRouter();

/**
 * Reference for the loading state.
 * @type {import('vue').Ref<boolean>}
 */
const loading = ref(false);

/**
 * Instance of the Notification repository.
 * @type {import('@/repository/Repository').default}
 */
const NotificationRepository = RepositoryFactory.get("Notification");

/**
 * Function to fetch all user notifications.
 * @async
 * @returns {Promise<void>}
 */
const getUserAllNotifications = async () => {
  try {
    loading.value = true;
    const { data } = await NotificationRepository.getUserAllNotifications();
    notifications.value = data.notifications;
    filterNotification(route.query.filter);
    filteredNotifications.value = paginateFactory(filteredNotifications.value, page.value, ITEM_PER_PAGE);
  } catch (e) {
    error(e.error?.message);
  } finally {
    loading.value = false;
  }
};

/**
 * Function to filter notifications based on a query string.
 * @param {string} queryString - The query string to filter notifications.
 * @returns {void}
 */
const filterNotification = (queryString) => {
  page.value = 1;
  queryString
      ? (filteredNotifications.value = notifications.value.filter((item) => item.type === queryString))
      : (filteredNotifications.value = notifications.value);
  if (queryString !== route.query.filter) {
    router.replace({ name: "notifications", query: { filter: queryString } });
  }
};

/**
 * Lifecycle hook called after the component has been mounted.
 * Fetches all user notifications.
 * @returns {Promise<void>}
 */
onMounted(async () => {
  await router.isReady();
  tab.value = route.query.filter;
  await getUserAllNotifications();
});
</script>

<template>
  <div>
    <!-- Banner for notifications -->
    <v-banner  bg-color="background" border="0">
      <template #text>
        <!-- Heading for notifications -->
        <h1 class="text-h6 font-weight-bold">اعلان‌ها</h1>
      </template>
    </v-banner>
    <!-- Row for layout -->
    <v-row class="mt-3">
      <!-- Column for tab navigation -->
      <v-col cols="12" md="3" lg="3">
        <!-- Card containing vertical tabs -->
        <v-card rounded class="rounded-xl">
          <!-- Vertical tabs for different notification types -->
          <v-tabs v-model="tab" color="primary" direction="vertical" hide-slider height="60">
            <!-- Tab for each notification type -->
            <v-tab v-for="(item) in tabs" :key="'notification-tab-' + item.value" variant="elevated" :value="item.value" @click="filterNotification(item.value)">
              {{ item.title }} <!-- Display title of the notification type -->
            </v-tab>
          </v-tabs>
        </v-card>
      </v-col>

      <!-- Column for loading skeleton or notifications -->
      <v-col v-if="loading" cols="12" md="9" lg="9">
        <!-- Skeleton loader for loading state -->
        <v-skeleton-loader type="card,paragraph" v-for="i in 5" />
      </v-col>
      <v-col v-else cols="12" md="9" lg="9">
        <!-- Window to display notifications -->
        <v-window v-model="tab">
          <!-- Window item for each notification type -->
          <v-window-item v-for="(item) in tabs" :key="'notification-window-' + item.value" :value="item.value" class="px-3">
            <template v-if="notifications.length">
              <!-- Display NotificationItem for each notification -->
              <NotificationItem v-for="notification in paginateFactory(filteredNotifications, page, ITEM_PER_PAGE)" :key="'notification-' + item.value + '-' + notifications._id" :item="notification" />
            </template>
            <!-- Display empty notification if no notifications found -->
            <NotificationEmpty v-if="!filteredNotifications.length" />
          </v-window-item>
        </v-window>
      </v-col>

      <!-- Column for pagination -->
      <v-col cols="12">
        <!-- Pagination component for navigating through notifications -->
        <ClPagination v-if="filteredNotifications.length" v-model="page" :model-value="page" :total-pages="Math.ceil(filteredNotifications.length / ITEM_PER_PAGE)" class="mt-3" />
      </v-col>
    </v-row>
  </div>
</template>


<style scoped lang="scss"></style>