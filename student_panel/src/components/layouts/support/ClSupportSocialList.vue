<script setup>
import {useStore} from "vuex";
import {computed} from "vue";
import { useUrl } from "@/composable/useUrl";

const props = defineProps(['customerSupport']);
const store = useStore();

const userData = computed(() => store.getters['userStore/userData']);

const { defaultImageUrlBuilder,imageUrlBuilder } = useUrl();

const whatsAppSendMessage = () => {
  if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
    window.open(`whatsapp://send?phone=${props.customerSupport.data.whatsapp_id}&text=سلام ${userData.name} هستم از کلاسینو با ایدی کاربری ${userData.id} و شماره موبایل ${userData.mobile} سوالی داشتم`, ' _blank')
  } else {
    window.open(`https://web.whatsapp.com/send?phone=${props.customerSupport.data.whatsapp_id}&text=سلام ${userData.name} هستم از کلاسینو با ایدی کاربری ${userData.id} و شماره موبایل ${userData.mobile} سوالی داشتم`, ' _blank')
  }
};
</script>

<template>
  <v-list nav class="mx-1">
    <v-list-item v-if="customerSupport.data.shown_phone" rounded class="rounded-lg px-3" :href="`tel:${customerSupport.data.shown_phone}`">
      <v-list-item-title>
        پشتیبان فروش
      </v-list-item-title>
      <v-list-item-subtitle>
        {{ customerSupport.name }}
      </v-list-item-subtitle>
      <template #append><span class="text-caption mt-4">
        {{ customerSupport.data.shown_phone}}
      </span></template>
    </v-list-item>

<!--    <v-list-item v-if="customerSupport.data.whatsapp_id" rounded class="rounded-lg px-3" @click="whatsAppSendMessage">-->
<!--      <template #append>-->
<!--        <v-icon size="large">$mdiWhatsapp</v-icon>-->
<!--      </template>-->
<!--      <span>واتساپ پشتیبان</span>-->
<!--    </v-list-item>-->

<!--    <v-list-item v-if="customerSupport.data.telegram_id"  rounded class="rounded-lg px-3" :href="`https://t.me/${customerSupport.data.telegram_id}`">-->
<!--      <template #append>-->
<!--        <v-icon size="large">$mdiSendCircle</v-icon>-->
<!--      </template>-->
<!--      <span>تلگرام پشتیبان</span>-->
<!--    </v-list-item>-->

<!--    <v-list-item  rounded class="rounded-lg px-3" :href="`https://www.instagram.com/${customerSupport.data.instagram_id}`">-->
<!--      <template #append>-->
<!--        <v-icon size="large">$mdiInstagram</v-icon>-->
<!--      </template>-->
<!--      <span>اینستاگرام پشتیبان</span>-->
<!--    </v-list-item>-->
  </v-list>
</template>

<style scoped lang="scss">

</style>