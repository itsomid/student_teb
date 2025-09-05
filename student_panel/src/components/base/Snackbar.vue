<script setup>
import {ref, watch, computed} from "vue"
import { useStore } from 'vuex'
const store = useStore();
const alert= ref(false);

const snackbarOptions = {
  /**
   * @description Applies a distinct style to the component. 'text' | 'flat' | 'elevated' | 'tonal' | 'outlined' | 'plain' | 'elevated'
   * @type {string}
   * */
  variant: "elevated",

  /**
   * @description Specifies the anchor point for positioning the component, using directional cues to align it either horizontally, vertically, or both…
   * "top" | "bottom" | "start" | "end" | "left" | "right" | "center" | "center center" | "top start" | "top end" | "top left" | ...
   * @type {string}
   * */
  location: "start top",

  /**
   * @description Designates the border-radius applied to the component. You can find more information on the https://vuetifyjs.com/en/styles/border-radius/
   * @type {string | number | boolean}
   * */
  rounded: "lg",

  /**
   * @description Sets the component transition.
   * Can be one of the [built in](https://v2.vuetifyjs.com/en/styles/transitions/) transitions or one your own.
   * @type {String}
   * */
  transition: "scale-transition",
  /**
   * Time (in milliseconds) to wait until snackbar is automatically hidden.
   * Use -1 to keep open indefinitely (0 in version < 2.3 ).
   * It is recommended for this number to be between 4000 and 10000.
   * Changes to this property will reset the timeout.
   * @type {Number}
   * */
  timeout: 4000,

}
const data = computed(()=>store.getters['alert/data']);
watch(data, () => {
  alert.value = true;
});
</script>

<template>
  <v-snackbar
      :class="{'mt-n1 mx-n1' : $vuetify.display.smAndDown}"
      :width="$vuetify.display.smAndDown ? '100%' : ''"
      :max-width="$vuetify.display.smAndDown ? '100%' : ''"
      min-height="60"
      v-model="alert"
      :color="data.type"
      :timeout="snackbarOptions.timeout"
      :variant="snackbarOptions.variant"
      :rounded="snackbarOptions.rounded"
      :location="snackbarOptions.location"
      :transition="snackbarOptions.transition"
  >
    {{ $t(data.text)}}
  </v-snackbar>
</template>

<style scoped>

</style>
