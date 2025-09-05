<script setup>

import {CLASS_ONGOING_STATUS, USER_CLASS_STATUS} from "@/constants/class.const";
import {useStore} from "vuex";
import {useUrl} from "@/composable/useUrl";

import {DEFAULT_IMAGE_PATH} from "@/config/filePath.config";
import {useThemeManager} from "@/composable/useThemeManager";
import {computed} from "vue";
const props =defineProps(['item']);
const store = useStore();
const selectClass = (class_id)=> {
  store.dispatch('dashboard/updateCourseClass',{id: class_id});
  showClass();
}
const showClass = ()=> {
  store.dispatch('dashboard/closeNotificationDrawer');
  store.dispatch('dashboard/openClassDrawer');
}

const selectedClass = computed(()=> store.getters['dashboard/courseClass']);
const { defaultImageUrlBuilder,imageUrlBuilder } = useUrl();

const { isDark } = useThemeManager();

const isClassOnGoing = (class_status)=> {
  return CLASS_ONGOING_STATUS.includes(class_status);
}

const isActive = (class_id)=> {
  return selectedClass.value?.id === class_id
}
</script>

<template>
  <!-- Card representing a class item -->
  <v-card
      :color="isClassOnGoing(item.class_status)? 'success' : ''"
      :variant="isClassOnGoing(item.class_status) ? 'tonal' : 'flat'"
      @click="selectClass(item.class_id)"
      flat
      :border="isClassOnGoing(item.class_status) ? 'success sm opacity-100' : isActive(item.class_id) ? 'primary sm opacity-100' : ''" rounded="xl" class="pa-4 ma-0 ma-lg-4 mt-4">
    <div class="d-flex flex-column flex-lg-row justify-space-between ">
      <!-- Class details on the left side -->
      <div class="d-flex flex-row flex-0-0-0 justify-start  order-1 order-lg-0 mt-3 w-100 w-lg-66" >
        <div>
          <v-img
              width="48"
              max-width="48"
              rounded="lg"
              aspect-ratio="1"
              cover
              :src="item.course_data.data.image ? imageUrlBuilder(item.course_data.data.image, 'PRODUCT') : defaultImageUrlBuilder(isDark ? DEFAULT_IMAGE_PATH.PRODUCTS_DARK : DEFAULT_IMAGE_PATH.PRODUCTS_LIGHT)"
          />
        </div>
        <div class="mr-4 text-truncate">
          <p class="font-weight-bold text-subtitle-2 text-lg-body-1 text-truncate">{{ item.course_name }}</p>
          <p class="text-caption text-lg-subtitle-2 text-truncate">{{ item.name }}</p>
        </div>
      </div>
      <!-- Chips and status on the right side -->
      <div class="d-flex flex-wrap flex-grow-1  flex-row justify-space-between justify-lg-end order-0 order-lg-1 flex-lg-column w-100 w-lg-33">
        <div class="mt-1 d-flex flex-row flex-wrap flex-lg-nowrap justify-end order-0 order-lg-1 ga-2">
          <!-- Chip for homework -->
          <v-chip v-if="item.force_homework" rounded="xl" size="small" color="warning" variant="tonal">
            <v-icon class="ml-1">$mdiRadioboxMarked</v-icon>
            تکلیف دارد
          </v-chip>
          <!-- Chip for quiz -->
          <v-chip v-if="item.force_quiz" rounded="xl" size="small" color="warning" variant="tonal">
            <v-icon class="ml-1">$mdiRadioboxMarked</v-icon>
            آزمون دارد
          </v-chip>
          <!-- Chip for report -->
          <v-chip v-if="item.force_report" rounded="xl" size="small" color="warning" variant="tonal">
            <v-icon class="ml-1">$mdiRadioboxMarked</v-icon>
            کارنامه دارد
          </v-chip>
          <!-- Chip for class status -->
          <v-chip size="small" rounded="xl"  :color="USER_CLASS_STATUS[item.class_status].color" variant="tonal">
            <v-icon class="ml-1">{{ USER_CLASS_STATUS[item.class_status].icon }}</v-icon>
            <span v-if="item.class_status !== 1">
              {{ USER_CLASS_STATUS[item.class_status].title }}
            </span>
            <span v-else>
              ساعت {{ item.holding_date.split(' ')[1].substring(0, 5) }}
            </span>
          </v-chip>
          <!-- Chip for user absence -->
          <v-chip v-if="item.user_absence"  rounded="xl" size="small" color="error" variant="tonal">
            <v-icon class="ml-1">$mdiEyeOffOutline</v-icon>
            مشاهده نشده
          </v-chip>
        </div>
      </div>
    </div>
  </v-card>
</template>

<style scoped lang="scss">

</style>