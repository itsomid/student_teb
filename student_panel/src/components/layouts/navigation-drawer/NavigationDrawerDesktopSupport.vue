<script setup>
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

const drawer = defineModel({default: false});

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

onMounted(()=> {
  getUserSupport();
})
</script>

<template>

  <v-navigation-drawer mobile-breakpoint="xl"  v-model="drawer">
    <template #prepend>
      <v-list-item title="پشتیبانی">
        <template #append>
          <v-btn @click="drawer = false" size="small" flat icon="$arrowRight" />
        </template>
      </v-list-item>
    </template>

    <ClSupportSocialList v-if="customerSupport.data" :customer-support="customerSupport" />

    <ClSupportContact />

    <ClSupportGoftinoBtn />

    <ClSupportReportBug />
  </v-navigation-drawer>
</template>

<style scoped lang="scss">

</style>