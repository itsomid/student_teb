<script setup>
import DefaultLayout from './DefaultLayout.vue'
import AuthLayout from './AuthLayout.vue'
import {computed} from "vue";
import {useRouter} from "vue-router";
const layoutComponents = {
  default: DefaultLayout,
  auth: AuthLayout,
};
const router = useRouter();
const currentLayoutComponent = computed(()=> {
  const layout = router.currentRoute.value?.meta?.layout || "auth";
  return layoutComponents[layout];
})
// export default {
//   computed: {
//     currentLayoutComponent() {
//       const layout = this.$router.currentRoute.value?.meta?.layout || "default";
//       return layoutComponents[layout];
//     },
//   },
// };
</script>

<template>
  <!-- Render appropriate layout component -->
  <component :is="currentLayoutComponent">
    <!-- Pass through all the slots -->
    <template
        v-for="slotName in Object.keys($slots)"
        :key="slotName"
        v-slot:[slotName]="slotProps"
    >
      <slot :name="slotName" v-bind="slotProps" />
    </template>
  </component>
</template>

<style scoped>

</style>