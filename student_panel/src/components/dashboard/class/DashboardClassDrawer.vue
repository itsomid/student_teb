<script setup>
import { useStore } from 'vuex';
import { computed, watch } from 'vue';
import { useDisplay } from 'vuetify';
import { useClassManager } from '@/composable/class/useClassManager';
import { useNavigator } from '@/composable/useNavigator';

import ClLoading from '@/components/base/ClLoading.vue';
import DashboardClassInfo from "@/components/dashboard/class/DashboardClassInfo.vue";
import DashboardClassDetails from "@/components/dashboard/class/DashboardClassDetails.vue";
import DashboardClassStudyHub from "@/components/dashboard/class/DashboardClassStudyHub.vue";
import {useThemeManager} from "@/composable/useThemeManager";
import {HOMEWORK_STATES, QUIZ_STATES, USER_CLASS_STATUS} from "@/constants/class.const";
import {useAlert} from "@/composable/useAlert";
import RepositoryFactory from "@/repository/RepositoryFactory";


const store = useStore();

const { error,success,info } = useAlert();
const classDrawer = computed(() => store.getters['dashboard/classDrawer']);
const class_id = computed(() => store.getters['dashboard/courseClass']);
const { course, loading, getUserCourseClass } = useClassManager();
const { navigateToClass } = useNavigator();

const { lgAndUp } = useDisplay();
const { isDark } = useThemeManager();
const ClassRepository = RepositoryFactory.get('Class');
const showNotifications = () => {
  store.dispatch('dashboard/clearCourseClass');
  store.dispatch('dashboard/closeClassDrawer');
  if (lgAndUp.value) store.dispatch('dashboard/openNotificationDrawer');
};

watch(
    class_id,
    (value) => {
      if (value && value.id) getUserCourseClass(value.id);
    },
    { immediate: true }
);

const goToConductedClass = (classData) => {
  navigateToClass(classData.class_id);
}
const goToOnlineClass = async (classData)=> {
  if(classData.homework_status === HOMEWORK_STATES.FORCED && classData.quiz_status === QUIZ_STATES.FORCED) error('برای ورود به جلسه هم باید تکلیفتو بارگزاری کنی هم توی آزمون شرکت کنی!')
  else if(classData.homework_status === HOMEWORK_STATES.FORCED) error('برای ورود به جلسه حتما باید تکلیفتو بارگزاری کنی!')
  else if(classData.quiz_status === QUIZ_STATES.FORCED) error('برای ورود به جلسه حتما باید توی آزمون شرکت کنی!')
  else  {
    window.open(classData.cc_url, '_blank');
    try {
      await ClassRepository.setUserClassPresent(classData.class_id,{
        watch_online: 1
      });
      success('حضور شما در جلسه ثبت شد.')
    }catch(e) {
      e?.error?.status === 409 ? info(e?.error?.message) :
      error('حضور شما در جلسه ثبت نشد.')
    }
  }
}

const classBtnActionHandler = ( classData )=> {
  if(classData.class_status === 3 ) goToConductedClass(classData);
  else goToOnlineClass(classData)
}

</script>

<template>
  <v-navigation-drawer v-model="classDrawer"
  :width="$vuetify.display.lgAndUp ? 400 : 336"
  :class="$vuetify.display.lgAndUp ? '' : 'rounded-bs-xl rounded-ts-xl'"
  border="0"
  location="left"
  color="surface"
                       floatin
  >
  <!-- Drawer Prepend Section -->
  <template #prepend>
    <v-toolbar height="36" color="transparent" class="pa-6">
      <!-- Back button to show notifications -->
      <v-btn @click="showNotifications">
        <v-icon>$mdiChevronRight</v-icon>
        بازگشت
      </v-btn>
    </v-toolbar>
  </template>
  <div class="position-relative" style="min-height: 200px">
    <!-- Loading indicator while data is being fetched -->
    <ClLoading v-if="loading" />
    <div v-else>
      <!-- Display course details if data is available -->
      <div v-if="course && course.course_data" class="px-6">
        <!-- Component to display class information -->
        <DashboardClassInfo :course="course" :isDark="isDark" />
        <p class="px-0 text-subtitle-2 font-weight-regular text-secondary">
          {{ course.name }}  <!-- Display course name -->
        </p>
        <div class="d-flex flex-row justify-space-between mt-4">
          <!-- Button to navigate to class details -->
          <v-btn  @click="navigateToClass(class_id.id)" :to="{ name: 'show-class' , params:{id: class_id.id}}" width="140" height="36" variant="text" flat border rounded="lg">
            جزییات جلسه
          </v-btn>
          <!-- Button to join the session -->
          <v-btn  @click="classBtnActionHandler(course)" :disabled="course.class_status === 1  " color="primary" flat width="140" height="36" rounded="lg">
            {{ course.class_status === 3 ? 'مشاهده جلسه' : 'ورود به جلسه'}}
          </v-btn>
        </div>
        <v-divider class="my-4" />
        <!-- Component to display additional class details -->
        <DashboardClassDetails :course="course" />
        <v-divider class="my-4" />
        <!-- Component for study hub resources like handouts and homework -->
        <DashboardClassStudyHub :course="course" :loading="loading" />
      </div>
    </div>
  </div>
  </v-navigation-drawer>
</template>


<style scoped lang="scss">

</style>