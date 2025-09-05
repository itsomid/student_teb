<script setup>
import RepositoryFactory from "@/repository/RepositoryFactory";
import {useAlert} from "@/composable/useAlert";
import {onMounted, ref} from "vue";
import AdvertiseHubBannerItem from "@/components/course-class/advertise-hub/AdvertiseHubBannerItem.vue";

const props = defineProps({
  productId: [String,Number],
  loading: Boolean,
})

const { error } = useAlert();

const  BannerRepository = RepositoryFactory.get("Banner");

const item = ref({});
const loading = ref(false);
const getCourseSpecificBanners = async ()=> {
  try {
    loading.value = true;
    const { data } = await BannerRepository.getClassBanner(props.productId);
    item.value = data;
  }catch (e) {
    error(e.error?.message)
  }finally {
    loading.value = false;
  }
}

onMounted(()=> {
  getCourseSpecificBanners();
});

</script>

<template>
  <div v-if="loading">
    <v-responsive :aspect-ratio="6.125">
      <v-card rounded="xl">
        <v-skeleton-loader type="image" />
      </v-card>
    </v-responsive>
  </div>
  <div v-else-if="item.title" class="d-flex flex-column" style="gap: 10px">
    <AdvertiseHubBannerItem
        :item="item"
        :closeable="false"
    />
  </div>
</template>

<style scoped lang="scss">

</style>