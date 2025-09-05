<template>
  <component :is="computedIcon || fallbackIcon"/>
</template>

<script lang="ts" setup>
import { shallowRef, watch } from "vue";

const props = defineProps({
  icon: String,
  fallbackIcon: { // Optional fallback icon if icon prop is not found
    type: Object,
    default: null,
  },
});

const icons = import.meta.glob('./*.vue');
const computedIcon = shallowRef();

watch(
    () => props.icon,
    async (newIcon) => {
      if (!newIcon) {
        computedIcon.value = props.fallbackIcon;
        return;
      }

      const componentPath = `./${newIcon}.vue`;
      if (icons[componentPath]) {
        try {
          computedIcon.value = (await icons[componentPath]()).default;
        } catch (error) {
          console.error(`Failed to load component "${newIcon}":`, error);
          computedIcon.value = props.fallbackIcon;
        }
      } else {
        console.warn(`Icon component "${newIcon}" not found.`);
        computedIcon.value = props.fallbackIcon;
      }
    },
    { immediate: true }
);
</script>

<style lang="scss" scoped></style>
