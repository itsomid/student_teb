<script setup>
import {computed, defineAsyncComponent, ref, watch} from "vue";
import ClLoading from "@/components/base/ClLoading.vue";
import ClError from "@/components/app/ClError.vue";
import {useStore} from "vuex";
import {PRODUCT_TYPE} from "@/constants/product";

const props = defineProps({
  data: {
    type: Object,
    required: false,
  },
});

const StoreProductHubTopics = defineAsyncComponent({
  loader: () => import("./StoreProductHubTopics.vue"),
  loadingComponent: ClLoading,
  delay: 0,
  errorComponent: ClError,
  timeout: 3000,
});

const StoreProductHubAbout = defineAsyncComponent({
  loader: () => import("./StoreProductHubAbout.vue"),
  loadingComponent: ClLoading,
  delay: 0,
  errorComponent: ClError,
  timeout: 3000,
});

const StoreProductHubProfessor = defineAsyncComponent({
  loader: () => import("./StoreProductHubProfessor.vue"),
  loadingComponent: ClLoading,
  delay: 0,
  errorComponent: ClError,
  timeout: 3000,
});

const StoreProductHubFeedback = defineAsyncComponent({
  loader: () => import("./StoreProductHubFeedback.vue"),
  loadingComponent: ClLoading,
  delay: 0,
  errorComponent: ClError,
  timeout: 3000,
});

const items = [
  {
    id: 1,
    title: "محتوای دوره",
    component: StoreProductHubTopics,
    name: "StoreProductHubTopics",
  },
  {
    id: 2,
    title: "درباره دوره",
    component: StoreProductHubAbout,
    name: "StoreProductHubAbout",
  },
  {
    id: 3,
    title: "درباره استاد",
    component: StoreProductHubProfessor,
    name: "StoreProductHubProfessor",
  },
  {
    id: 4,
    title: "نظرات",
    component: StoreProductHubFeedback,
    name: "StoreProductHubFeedback",
  }
];

const tabs = ref(1);

const currentComponentProps = computed(()=> {
  if(items[tabs.value - 1].name === 'StoreProductHubTopics') return {
    loading: props.loading,
    classes: props.data.classes,
    package: props.data.package,
    productStatus: props.data.status,
    productType: props.data.product_type_id
  }
  else if(items[tabs.value - 1].name === 'StoreProductHubAbout') return {
    description: props.data.description
  }
  else if(items[tabs.value - 1].name === 'StoreProductHubProfessor') return {
    data: props.data?.package?.data?.teachers || props.data.teacher_bio || '',
    productType: props.data.product_type_id
  }
  else if(items[tabs.value - 1].name === 'StoreProductHubFeedback') return {
    comments: props.data.comments
  }
  else  return {}
})

const store = useStore();

watch(()=>store.getters['shop/selectedProfessor'], (value)=> {
  if(value) tabs.value = 3;
},{ immediate: true});

watch(tabs, (value,oldValue)=> {
  if(props.data.product_type_id === PRODUCT_TYPE.PRODUCT_CUSTOM_PACKAGE &&  oldValue === 3){
    store.dispatch('shop/updateProfessor', null);
  }
})
</script>

<template>
  <div>
    <v-tabs
        v-model="tabs"
        :height="$vuetify.display.mdAndUp ? 60 : ''"
        color="primary"
        class="text-secondary"
        :grow="$vuetify.display.smAndDown"
        density="compact"
    >
      <v-tab
          density="compact"
          v-for="item in items"
          variant="text"
          :value="item.id"
          class="flex-shrink-1"
          :class="{'px-0' : $vuetify.display.smAndDown}"
      >
        {{ item.title }}
      </v-tab>
    </v-tabs>
    <v-divider />
    <v-window v-model="tabs" class="h-100 mt-4 px-3 py-3">
      <v-window-item
          v-for="(item, index) in items"
          :key="item.id"
          :value="item.id"
          style="height: calc(100% - 60px)"
      >
        <component :key="'guid-insight-hub-' + index" :is="item.component" v-bind="currentComponentProps" />
      </v-window-item>
    </v-window>
  </div>
</template>

<style scoped lang="scss">

</style>