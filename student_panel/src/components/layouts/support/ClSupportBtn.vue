<script setup>
import {computed, onMounted, ref} from "vue";
import {useAlert} from "@/composable/useAlert";
import { useUrl } from "@/composable/useUrl";
import RepositoryFactory from "@/repository/RepositoryFactory";
import ClSupportSocialList from "@/components/layouts/support/ClSupportSocialList.vue";
import ClSupportContact from "@/components/layouts/support/ClSupportContact.vue";
import ClSupportGoftinoBtn from "@/components/layouts/support/ClSupportGoftinoBtn.vue";
import ClSupportReportBug from "@/components/layouts/support/ClSupportReportBug.vue";
  const menu = ref(false);
  const location = "bottom";
  const offsetTop = 20;
const { error } = useAlert();
  const { defaultImageUrlBuilder,imageUrlBuilder } = useUrl();


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
  <v-menu
      v-model="menu"
      :offset="offsetTop"
      :close-on-content-click="false"
      >
    <template v-slot:activator="{ props }">
      <v-btn
          v-bind="props"
          position="fixed"
          location="bottom left"
          :rounded="$vuetify.display.smAndUp ? true : 0"
          variant="elevated"
          color="success"
          size="x-large"
          :block="!$vuetify.display.smAndUp"
          :class="{'cl-support-btn' : $vuetify.display.smAndUp}"
      >
        <template #prepend>
          <i class="icon-CL_message-lines mx-3"></i>
        </template>
        <span class="mx-4">پشتیبانی</span>
        <template #append>
          <i id="customerServiceImg" class="icon-CL_angle-up mx-3"></i>
        </template>
      </v-btn>
    </template>
    <v-card  rounded class="rounded-xl mx-auto">
      <v-card-title class="d-flex flex-row justify-center align-center justify-space-between bg-primary">
        <i class="icon-CL_message-lines"></i>
        <span class="mx-4">پشتیبانی</span>
        <v-btn size="small" icon  variant="text" @click="menu = false">
          <i class="icon-CL_xmark"></i>
        </v-btn>
      </v-card-title>

      <v-divider />

      <v-card-text class="pa-4">
        <v-avatar size="50" class="elevation-3">
          <v-img v-if="customerSupport.img_filename" :src="imageUrlBuilder(customerSupport.img_filename, 'USER_PROFILE')" />
          <v-img v-else width="100%" :src="defaultImageUrlBuilder('assets/images/default/avatars/avatar-default.png')" />
        </v-avatar>
        <span class="text-h6 mx-3">  {{ customerSupport.name }} </span>
        <a v-if="customerSupport.data.shown_phone">{{ customerSupport.data.shown_phone }}</a>
      </v-card-text>

      <v-divider />

      <ClSupportSocialList :customer-support="customerSupport" />

      <v-divider />

      <ClSupportContact />

      <ClSupportGoftinoBtn />

      <ClSupportReportBug />
    </v-card>
  </v-menu>

</template>

<style scoped lang="scss">
.v-overlay__content {
  right: unset!important;
}
</style>