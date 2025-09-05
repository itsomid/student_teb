<script>
import ClAlert from "@/views/components/miscellaneous/ClAlert.vue";

export default {
  name: "ClSnackbar",
  components: {ClAlert},
  props:{
    /**
     * @description v-model for alert
     * @type {boolean}
     * */
    modelValue: {
      type: Boolean,
      default: false,
    },

    /**
     * @description Specify a success, info, warning or error alert.
     * Uses the contextual color and has a pre-defined icon.
     * @type {String}
     * */
    type: {
      type: String,
      default: "success",
      validator:(value)=> ['success','info','warning','error'].includes(value)
    },

    /**
     * @description Sets the component transition.
     * Can be one of the [built in](https://v2.vuetifyjs.com/en/styles/transitions/) transitions or one your own.
     * @type {String}
     * */
    transition: {
      type: String,
      default: "scale-transition",
    },

    /**
     * @description Adds a close icon that can hide the alert.
     * @type {String}
     * */
    dismissible: {
      type: Boolean,
      default: true,
    },
    /**
     * Time (in milliseconds) to wait until snackbar is automatically hidden.
     * Use -1 to keep open indefinitely (0 in version < 2.3 ).
     * It is recommended for this number to be between 4000 and 10000.
     * Changes to this property will reset the timeout.
     * @type {Number}
     * */
    timeout:{
      type: Number,
      default: 4000
    }
  },
  data(){
    return {
      alert: false,
      value: 0,
      timer: null,
    }
  },
  methods: {
    startTimer(){
      this.value = 0;
      this.timer = setInterval(()=>{
        this.value++;
      }, this.timeout/100)
    },
    stopTimer(){
      clearInterval(this.timer);
    }
  },
  watch:{
    alert: function (value) {
      this.$emit('update:modelValue', value)
      this.$emit('input', value)
      if(value) this.startTimer();
      else if(this.timer) this.stopTimer();
    },
    value: function (percent){
      if(percent === 100) this.stopTimer();
    },
    modelValue: {
      handler: function (value){
        this.alert = value;
      },
      immediate: true,
    },
  },
}
</script>

<template>
  <v-snackbar
      :value="alert"
      top
      :left="$vuetify.breakpoint.mdAndUp"
      :color="type"
      v-model="alert"
      :timeout="timeout + 150"
      :min-width="$vuetify.breakpoint.smAndDown ? '100%' : ''"
      :tile="$vuetify.breakpoint.smAndDown"
      class="overflow-hidden"
      :class="{'ma-3' : $vuetify.breakpoint.mdAndUp}"
      style="right:0!important;"
  >
      <template #default>
        <ClAlert
            v-model="alert"
            :model-value="alert"
            :type="type"
            :transition="transition"
            :dismissible="dismissible">
          <slot />
        </ClAlert>
        <v-progress-linear
            bottom
            absolute
            :rounded="$vuetify.breakpoint.mdAndUp"
            color="white"
            :background-color="type"
            :value="value"
        />
      </template>
  </v-snackbar>
</template>

<style scoped lang="scss">
.v-snack__wrapper{
  overflow: hidden!important;
}
</style>