<script setup>

import {useStore} from "vuex";
import {computed} from "vue";
import { useUrl } from "@/composable/useUrl";
import ClModal from "@/components/base/ClModal.vue";
import {useThemeManager} from "@/composable/useThemeManager";

const { imageUrlBuilder } = useUrl();

const model = defineModel({default: false})

const store = useStore();
const block = computed(()=> store.getters['userStore/blockReason']);

const { isDark } = useThemeManager();
const btnBackground = computed(() => isDark.value ? 'white' : 'black'); // Calculating btn theme based on current theme

const toggle = ()=> {
  model.value = !model.value;
}
</script>

<template>
  <div class="d-flex flex-column justify-center align-center text-body-1 font-weight-bold" >
    <v-icon size="50" color="error">$mdiAccountCancelOutline</v-icon>
    <span>شما از ورود به جلسه زنده توسط مدیریت منع شده‌اید</span>
    <div class="text-center">
      <p v-if=" block.description" class="mt-3 text-body-2">
        برای مشاهده دلیل کلیک کنید
      </p>
    </div>
    <v-btn size="x-large" rounded class="mt-3" :color="btnBackground" @click="toggle">
      مشاهده جزییات
    </v-btn>
  </div>

  <!--PopUp modal to show detail  -->
  <ClModal v-model="model"  title="بلاک" width="600" :blur="true">
    <template #title>
      <v-icon color="error">$mdiAccountCancelOutline</v-icon>
    </template>
    <template #content>
      <v-card-text class="pa-6">
        <div class="my-6">
          <span>دلایل بلاک شدن:</span>
          <span class="text-body-2 font-weight-bold mx-3">{{ block.description}}</span>
        </div>
        <v-img
            v-if="block.image"
            class="rounded-xl mt-3 elevation-3"
            rounded
            :src="imageUrlBuilder(block.image, 'BLOCK')"
            alt="دلیل بلاک شدن دانش آموز"
        />
      </v-card-text>
    </template>

    <template #actions>
      <v-card-actions class="pa-4">
        <v-btn  color="primary" block variant="tonal" size="large" rounded  @click="toggle">
            بستن
        </v-btn>
      </v-card-actions>
    </template>
  </ClModal>
</template>

<style scoped lang="scss">

</style>