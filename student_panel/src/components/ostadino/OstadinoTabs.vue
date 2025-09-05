<script setup>
import OstadinoVideos from "@/components/ostadino/OstadinoVideos.vue";
import OstadinoTeachers from "@/components/ostadino/OstadinoTeachers.vue";
const OSTADINO_TABS = {
  VIDEOS       : {
    title: 'ویدیو‌ها',
    icon: 'cli:VideoPlay',
    value: 0,
  },
  TEACHERS : {
    title: 'اساتید برتر',
    icon: 'cli:Star1',
    value: 1,
  }
}

const props = defineProps({
  currentStep: {
    default: 1
  }
})
const tab = defineModel({
  default: 0
})
const isActive = (type)=> {
  return tab.value === type;
}

const changeTab = async (type) => {
  try {
    tab.value = type;
    console.log(tab.value)
  }catch(e) {
    console.log(e)
  }finally {
  }
}
</script>

<template>
 <div>
   <div :class="$vuetify.display.mobile ? 'rounded-xl' : 'rounded-lg'" class="ostadino-tabs-container d-flex justify-center my-2 mx-auto pa-1 border bg-background" style="">
     <v-btn
         v-for="item in OSTADINO_TABS"
         size="large"
         class="flex-grow-1"
         :rounded="$vuetify.display.mobile ? 'xl' : 'lg'"
         :border="isActive(item.value)"
         :variant="isActive(item.value) ? 'elevated' : 'text'"
         @click.prevent="changeTab(item.value)"
         flat
     >
       <v-icon :color="isActive(item.value) ? 'primary' : ''" class="ml-1" :icon="item.icon" :type="isActive(item.value) ? 'bold' : 'linear'"></v-icon>
       {{item.title }}
     </v-btn>
   </div>
   <v-tabs-window v-model="tab">
     <v-tabs-window-item
         value="0"
     >
       <v-container class="pt-0">
         <div class="text-center">
           <h1 class="mt-16 mb-6">
             ویدیوها
           </h1>
         </div>
        <OstadinoVideos v-if="tab === 0" :step="currentStep" />
       </v-container>
     </v-tabs-window-item>
     <v-tabs-window-item
         value="1"
     >
       <v-container fluid class="px-0 px-lg-4">
          <div class="text-center">
            <h1 class="mt-16 mb-6">
              اساتید برتر
            </h1>
            <v-alert width="584" max-width="100%" color="warning" rounded="lg" variant="tonal" border="sm warning opacity-80" class="border mx-auto text-caption font-weight-bold pa-4 text-center">
              امتیاز کل با در نظر گرفتن امتیاز دانش‌آموز و کارشناس محاسبه خواهد شد.
            </v-alert>
          </div>
         <OstadinoTeachers v-if="tab === 1" :step="currentStep" />
       </v-container>
     </v-tabs-window-item>
   </v-tabs-window>
 </div>
</template>

<style scoped lang="scss">
  .ostadino-tabs-container {
    width: 584px;
    max-width: 100%;
  }
</style>