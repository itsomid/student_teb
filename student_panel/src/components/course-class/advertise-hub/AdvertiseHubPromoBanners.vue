<script setup>
import RepositoryFactory from "@/repository/RepositoryFactory";
import {BANNER_TYPES} from "@/constants/bannerTypes";
import {useAlert} from "@/composable/useAlert";
import {onMounted, ref} from "vue";
import AdvertiseHubBannerItem from "@/components/course-class/advertise-hub/AdvertiseHubBannerItem.vue";

const { error } = useAlert();

const  BannerRepository = RepositoryFactory.get("Banner");

const items = ref([]);
const loading = ref(false);
const getPromoBanners = async ()=> {
  try {
    loading.value = true;
    const { data: { data }} = await BannerRepository.getBanner(BANNER_TYPES.PROMO);
    items.value = data;
  }catch (e) {
    error(e.error?.message)
  }finally {
    loading.value = false;
  }
}

onMounted(()=> {
  getPromoBanners();
});

const removeItem = (itemTitle)=> {
  const index = items.value.indexOf((item)=> item.title === itemTitle)
  if(index) items.value.splice(index,1);
}
</script>

<template>
  <div v-if="loading">
    <v-responsive :aspect-ratio="6.125">
      <v-card  rounded="xl">
        <v-skeleton-loader type="image" />
      </v-card>
    </v-responsive>
  </div>
  <div v-else-if="items.length" class="d-flex flex-column" style="gap: 10px">
    <AdvertiseHubBannerItem
        v-for="(banner, index) in items"
        :key="'banner-promo-course-' + index"
        :item="banner"
        @remove="removeItem"
    />
  </div>
</template>

<style scoped lang="scss">

</style>