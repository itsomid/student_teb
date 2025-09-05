<script setup>
import ClLoading from "@/components/base/ClLoading.vue";
const props = defineProps({
  /**
   * @description to handle full screen mode or block mode loading
   * @type {boolean}
   * */
  persistent: {
    type: Boolean,
    default: true
  },
  /**
   * @description to handle full screen mode or block mode loading
   * @type {boolean}
   * */
  contained: {
    type: Boolean,
    default: false
  },
  /**
   * @description to handle opacity of overlay
   * @type {number,string}
   * */
  opacity: {
    type: [Number, String],
    default: 0.1,
  },

  /**
   * @description to handle scale of loading
   * @type {number,string}
   * */
  scale: {
    type: [Number, String],
    default: 0.8
  }
});

const overlay = defineModel();
</script>

<template>
  <v-overlay
      v-model="overlay"
      class="align-center justify-center"
      :contained="contained"
      :opacity="opacity"
      data-test="overlay-loading"
      :persistent="persistent"
  >
    <ClLoading :scale="scale"/>
  </v-overlay>
</template>


