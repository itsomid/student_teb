<script setup>
import {onMounted, ref} from "vue";
import RepositoryFactory from "@/repository/RepositoryFactory";
import { BANNER_TYPES } from "@/constants/bannerTypes";
import { useAlert } from "@/composable/useAlert";
import { useUrl } from "@/composable/useUrl";
import DashboardAnnouncementItem from "@/components/dashboard/announcement/DashboardAnnouncementItem.vue";
import ClLoading from "@/components/base/ClLoading.vue";
import DashboardNotificationEmpty from "@/components/dashboard/notifications/DashboardNotificationEmpty.vue";

const { error } = useAlert();
const { imageUrlBuilder } = useUrl();

const  BannerRepository = RepositoryFactory.get("Banner");
const items = ref([]);
const loading = ref(false);

const getAnnouncement = async ()=> {
  try {
    loading.value = true;
    const { data: { data }} = await BannerRepository.getBanner(BANNER_TYPES.ANNOUNCEMENT);
    items.value = data;
  }catch (e) {
    error(e.error?.message)
  }finally {
    loading.value = false;
  }
}

onMounted(()=> {
  getAnnouncement();
})
</script>

<template>
  <div class="position-relative" style="min-height: 200px">
    <ClLoading v-if="loading"></ClLoading>
    <div v-else >
      <template v-if="items.length">
        <div v-for="item in items" :key="item.title">
          <DashboardAnnouncementItem :item="item" />
        </div>
      </template>
      <DashboardNotificationEmpty class="mt-16" v-else />
    </div>
  </div>
</template>

<style scoped lang="scss">

</style>