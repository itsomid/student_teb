<script setup>
import {computed, defineAsyncComponent, ref} from "vue";
import ClLoading from "@/components/base/ClLoading.vue";
import ClError from "@/components/app/ClError.vue";

const props = defineProps({
  description : [String,Object],
  className : String,
  loading: Boolean,
})

const GuideInsightHubDescription = defineAsyncComponent({
  loader: () => import("./GuideInsightHubDescription.vue"),
  loadingComponent: ClLoading,
  delay: 0,
  errorComponent: ClError,
  timeout: 3000,
});

const GuideInsightHubGuidance = defineAsyncComponent({
  loader: () => import("./GuideInsightHubGuidance.vue"),
  loadingComponent: ClLoading,
  delay: 0,
  errorComponent: ClError,
  timeout: 3000,
});

const GuideInsightHubFeedback = defineAsyncComponent({
  loader: () => import("./GuideInsightHubFeedback.vue"),
  loadingComponent: ClLoading,
  delay: 0,
  errorComponent: ClError,
  timeout: 3000,
});


const items = [
  {
    id: 1,
    title: "توضیحات",
    component: GuideInsightHubDescription,
    name: "GuideInsightHubDescription",
  },
  {
    id: 2,
    title: "راهنما",
    component: GuideInsightHubGuidance,
    name: "GuideInsightHubGuidance",
  },
  {
    id: 3,
    title: "ارسال نظر",
    component: GuideInsightHubFeedback,
    name: "GuideInsightHubFeedback",
  }
];

const tabs = ref(3);

const currentComponentProps = computed(()=> {
  if(items[tabs.value - 1].name === 'GuideInsightHubDescription') return {
    loading: props.loading,
    classDesc: props.description
  }
  else if(items[tabs.value - 1].name === 'GuideInsightHubFeedback') return {
    loading: props.loading,
    className: props.className
  }
  else  return {}
})
</script>

<template>
  <v-hover>
    <template v-slot:default="{ isHovering,props }">
      <v-card
          v-bind="props"
          :elevation="isHovering ? 8 : 3"
          height="100%"
          min-height="610px"
          rounded="xl"
      >
        <v-tabs
            height="60"
            v-model="tabs"
            color="primary"
            class="px-4 text-secondary"
        >
          <v-tab
              v-for="item in items"
              variant="text"
              :value="item.id"
          >
            {{ item.title }}
          </v-tab>
        </v-tabs>
        <v-divider />
        <v-card-text>
          <v-window v-model="tabs" class="h-100">
            <v-window-item
                v-for="(item, index) in items"
                :key="item.id"
                :value="item.id"
                style="height: calc(100% - 60px)"
            >
              <component :key="'guid-insight-hub-' + index" :is="item.component" v-bind="currentComponentProps" />
            </v-window-item>
          </v-window>
        </v-card-text>
      </v-card>
    </template>
  </v-hover>
</template>

<style scoped lang="scss">

</style>