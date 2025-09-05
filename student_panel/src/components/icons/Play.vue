<template>
  <svg
      xmlns="http://www.w3.org/2000/svg"
      :width="size"
      :height="size"
      viewBox="0 0 24 24"
      fill="none"
      v-if="type === 'bold'"
  >
    <path
        d="M17.49 9.6 5.6 16.77c-.7.42-1.6-.08-1.6-.9v-8c0-3.49 3.77-5.67 6.8-3.93l4.59 2.64 2.09 1.2c.69.41.7 1.41.01 1.82ZM18.089 15.46l-4.05 2.34-4.04 2.33c-1.45.83-3.09.66-4.28-.18-.58-.4-.51-1.29.1-1.65l12.71-7.62c.6-.36 1.39-.02 1.5.67.25 1.55-.39 3.22-1.94 4.11Z"
        :fill="color"
    ></path>
  </svg>
  <svg
      xmlns="http://www.w3.org/2000/svg"
      :width="size"
      :height="size"
      viewBox="0 0 24 24"
      fill="none"
      v-else-if="type === 'bulk'"
  >
    <path
        d="M18.7 8.98 4.14 17.71c-.09-.33-.14-.68-.14-1.04V7.33c0-3.08 3.33-5 6-3.46l4.04 2.33 4.05 2.34c.22.13.43.27.61.44Z"
        :fill="color"
    ></path>
    <path
        opacity=".4"
        d="m18.089 15.46-4.05 2.34-4.04 2.33c-1.91 1.1-4.16.44-5.28-1.17l.42-.25 14.44-8.66c1 1.8.51 4.26-1.49 5.41Z"
        :fill="color"
    ></path>
  </svg>
  <svg
      xmlns="http://www.w3.org/2000/svg"
      :width="size"
      :height="size"
      viewBox="0 0 24 24"
      fill="none"
      v-else-if="type === 'linear'"
  >
    <path
        d="M4 12V8.44c0-4.42 3.13-6.23 6.96-4.02l3.09 1.78 3.09 1.78c3.83 2.21 3.83 5.83 0 8.04l-3.09 1.78-3.09 1.78C7.13 21.79 4 19.98 4 15.56V12Z"
        :stroke="color"
        :stroke-width="strokeWidth"
        stroke-miterlimit="10"
        stroke-linecap="round"
        stroke-linejoin="round"
    ></path>
  </svg>
</template>
<script lang="ts">
import { defineComponent } from "vue";
export default defineComponent({
  props: {
    type: {
      type: String,
      default: "linear"
    },
    size: {
      type: [String, Number],
      default: 24
    },
    color: {
      type: String,
      default: "currentColor"
    },
    strokeWidth: {
      type: String,
      default: "1.5"
    }
  }
});
</script>