<script setup>
const props = defineProps({
  title: {
    type: String
  },
  active: {
    type: Boolean,
    default: false,
  },
  value: {
    type: Object,
    default: 0,
  },
  available: {
    type: Boolean,
    default: false,
  }
})
</script>

<template>
  <div class="position-relative disabled" :class="{'disabled' : !available}">
    <span class="position-absolute step-title text-center" :class="{'text-secondary-lighten-2' : !available}">
      <template v-if="$slots.title">
        <slot name="title" />
      </template>
      <template v-else >{{ title }}</template>
    </span>
    <div class="step" :class="{'active' : active}">
      <div class="step-inner"></div>
    </div>
  </div>
</template>

<style scoped lang="scss">
/* Circle for each step */
.step {
  width: 32px;
  height: 32px;
  border-radius: 50%;
  background-color: rgb(var(--v-theme-surface));
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: bold;
  color: #fff;
  position: relative;
  z-index: 10;
}

.step-title {
  font-size: 12px;
  font-weight: 400;
  top: -35px;
  left: -35px;
  width: 100px
}
.step-inner {
  width: 16px;
  height: 16px;
  border-radius: 50%;
  background-color: rgb(var(--v-theme-secondary-lighten-3));
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: bold;
  color: #fff;
  position: relative;
  transition-delay: 0.25s;
  transition: linear 0.25s all;
  z-index: 10;
}



/* Active and completed steps */
.step.active {
  background-color: rgb(var(--v-theme-surface));
}
.step.active .step-inner{
  background-color: #F79009;
  box-shadow: 0px 6px 14px 0px #FF9D14BD;
}
</style>