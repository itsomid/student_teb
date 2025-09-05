<script setup>
import {ref, watch, defineEmits, defineProps, onMounted} from "vue";
import { Vue3Lottie } from 'vue3-lottie'
import checkmark from "@/assets/images/icons/checkmark.json";
const emit = defineEmits(['update:modelValue']);
const props = defineProps({
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
   * It is recommended for this number to be between 6000 and 10000.
   * Changes to this property will reset the timeout.
   * @type {Number}
   * */
  timeout:{
    type: Number,
    default: 6000
  }
})
const anim = ref(null); // for saving the reference to the animation
// const lottieOptions = ref({animationData: animationData.default, loop: false});
const alert = ref(false)
const value = ref(0)
const timer = ref(null)
function handleAnimation(anim) {
  anim.value = anim;
}
function startTimer(){
  setTimeout(()=>{
    alert.value = false
  }, props.timeout)
}

watch(alert, (value)=>{
  emit('update:modelValue', value)
  emit('input', value)
  if(value) startTimer();
})

watch(() => props.modelValue,(value)=> {
  if(value) {
    setTimeout(()=> {
      let animatedElement = document.querySelector(".alert-animation");
      animatedElement.style["-webkit-animation-duration"] = `${props.timeout}ms`;
      animatedElement.style["animation-duration"] = `${props.timeout}ms`;
    },100)
  }
  alert.value = value;
},{immediate: true})

</script>

<template>
  <div v-if="alert"  class="w-100 position-fixed cl-alert-container d-flex flex-column justify-center align-center">
    <div class="d-flex flex-row align-center justify-space-between px-1 position-fixed cl-alert  alert-animation elevation-12" :class="`bg-${props.type}`">
      <div class="text-white  alert-animation-text text-caption text-right  font-weight-bold ">
        <slot />
      </div>
      <Vue3Lottie
          class="alert-animation-icon"
          :animation-data="checkmark"
          :loop="false"
          :width="90"
          :height="90"
          />
    </div>
  </div>
</template>

<style scoped lang="scss">
.cl-alert-container {
  z-index: 1090;
  height: 90px;
  max-width: 500px;
  top: 50px;
  left: 50%;
  transform: translateX(-50%);
}
.cl-alert {
  z-index: 10;
  height: 80px;
  visibility: hidden;
  flex-shrink: 0;
  border-radius: 80px;
  //background: #2D2D2D!important;
}

.alert-animation {
  animation: alert ease-in-out  alternate;
  -webkit-animation: alert ease-in-out  alternate;
}

.alert-animation-text {
  -webkit-animation: alert-text 6s;
  -webkit-animation-delay:1.3s;
  -webkit-animation-fill-mode: both;
}

.alert-animation-icon {
  -webkit-animation: alert-icon 1s;
  -webkit-animation-delay:1s;
  -webkit-animation-fill-mode: both;
}

@keyframes alert-icon {
  0% {
    width: 90px;
    height: 90px;
  }
  10% {
    width: 50px;
    height: 50px;
  }
  100%{
    width: 50px;
    height: 50px;
  }
}

@keyframes alert-text {
  0% {
    visibility: hidden;
    display: none;
    opacity: 0;
    width: 0;
  }
  10% {
    visibility: visible;
    display: block;
    opacity: 0;
    width: 100%;
  }
  25% {
    visibility: visible;
    display: block;
    padding-right: 16px;
    opacity: 1;
    width: 100%;
  }
  50% {
    visibility: visible;
    display: block;
    opacity: 1;
    padding-right: 16px;
    width: 100%;
  }
  50.1%{
    visibility: hidden;
    display: block;
    opacity: 0;
    width: 100%;
  }
  80%{
    visibility: hidden;
    display: none;
    opacity: 0;
    width: 0;
    padding: 0;
    margin: 0;
  }
  100% {
    visibility: hidden;
    display: none;
    opacity: 0;
    width: 0;
    padding: 0;
    margin: 0;
  }
}
@keyframes alert {
  0% {
    visibility: visible;
    width: 80px;
    transform: translateY(-120px);
  }
  10% {
    display: block;
    width: 80px;
    transform: translateY(0);
  }
  20% {
    display: block;
    width: 80px;
    transform: translateY(0);
  }
  22% {
    display: block;
    width: 95%;
    transform: translateY(0);
  }
  75% {
    display: block;
    width: 95%;
    transform: translateY(0);
  }
  90%{
    display: block;
    width: 80px;
    transform: translateY(0);
  }
  100%{
    width: 80px;
    transform: translateY(-120px);
  }
}
</style>