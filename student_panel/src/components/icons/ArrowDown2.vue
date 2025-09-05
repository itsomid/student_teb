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
        :fill="color"
        d="M17.919 8.18H6.079c-.96 0-1.44 1.16-.76 1.84l5.18 5.18c.83.83 2.18.83 3.01 0l1.97-1.97 3.21-3.21c.67-.68.19-1.84-.77-1.84z"
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
        :fill="color"
        d="M15.48 13.23l-3.79-5.05H6.08c-.96 0-1.44 1.16-.76 1.84l5.18 5.18c.83.83 2.18.83 3.01 0l1.97-1.97z"
        opacity=".4"
    ></path>
    <path
        :fill="color"
        d="M17.92 8.18h-6.23l3.79 5.05 3.21-3.21c.67-.68.19-1.84-.77-1.84z"
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
        :stroke="color"
        stroke-linecap="round"
        stroke-linejoin="round"
        stroke-miterlimit="10"
        :stroke-width="strokeWidth"
        d="M19.92 8.95l-6.52 6.52c-.77.77-2.03.77-2.8 0L4.08 8.95"
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