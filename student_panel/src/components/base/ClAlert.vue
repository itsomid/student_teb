<script>

export default {
  name: "ClAlert",
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
    }
  },
  data(){
    return {
      alert: false,
    }
  },
  watch: {
    modelValue: {
      handler: function (value){
        this.alert = value;
      },
      immediate: true,
    },
    alert: function (value){
      this.$emit('update:modelValue', value)
      this.$emit('input', value)
    }
  },
}
</script>

<template>
  <v-alert
      dir="ltr"
      v-model="alert"
      :color="type"
      :transition="transition"
      :dismissible="dismissible"
      class="my-0"
  >
    <div dir="rtl" class="text-right pr-2">
      <slot class="text-right mr-8" />
    </div>
  </v-alert>
</template>

<style scoped lang="scss">

</style>