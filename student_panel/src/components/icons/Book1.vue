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
        d="M22 4.85v11.89c0 .97-.79 1.86-1.76 1.98l-.31.04c-1.64.22-3.95.9-5.81 1.68-.65.27-1.37-.22-1.37-.93V5.6c0-.37.21-.71.54-.89 1.83-.99 4.6-1.87 6.48-2.03h.06c1.2 0 2.17.97 2.17 2.17ZM10.708 4.71c-1.83-.99-4.6-1.87-6.48-2.03h-.07c-1.2 0-2.17.97-2.17 2.17v11.89c0 .97.79 1.86 1.76 1.98l.31.04c1.64.22 3.95.9 5.81 1.68.65.27 1.37-.22 1.37-.93V5.6a1 1 0 0 0-.53-.89Zm-5.71 3.03h2.25a.749.749 0 1 1 0 1.5h-2.25a.749.749 0 1 1 0-1.5Zm3 4.5h-3a.749.749 0 1 1 0-1.5h3a.749.749 0 1 1 0 1.5Z"
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
        opacity=".4"
        d="M20.5 7v8H6.35c-1.57 0-2.85 1.28-2.85 2.85V7c0-4 1-5 5-5h7c4 0 5 1 5 5Z"
        :fill="color"
    ></path>
    <path
        d="M20.5 15v3.5c0 1.93-1.57 3.5-3.5 3.5H7c-1.93 0-3.5-1.57-3.5-3.5v-.65C3.5 16.28 4.78 15 6.35 15H20.5ZM16 7.75H8c-.41 0-.75-.34-.75-.75s.34-.75.75-.75h8c.41 0 .75.34.75.75s-.34.75-.75.75ZM13 11.25H8c-.41 0-.75-.34-.75-.75s.34-.75.75-.75h5c.41 0 .75.34.75.75s-.34.75-.75.75Z"
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
        d="M22 16.74V4.67c0-1.2-.98-2.09-2.17-1.99h-.06c-2.1.18-5.29 1.25-7.07 2.37l-.17.11c-.29.18-.77.18-1.06 0l-.25-.15C9.44 3.9 6.26 2.84 4.16 2.67 2.97 2.57 2 3.47 2 4.66v12.08c0 .96.78 1.86 1.74 1.98l.29.04c2.17.29 5.52 1.39 7.44 2.44l.04.02c.27.15.7.15.96 0 1.92-1.06 5.28-2.17 7.46-2.46l.33-.04c.96-.12 1.74-1.02 1.74-1.98ZM12 5.49v15M7.75 8.49H5.5M8.5 11.49h-3"
        :stroke="color"
        :stroke-width="strokeWidth"
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