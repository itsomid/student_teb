<script setup>
  const props = defineProps({
    active: {
      type: Boolean,
      default: false
    }
  })
</script>

<template>
  <div class="position-relative flex-grow-1">
    <span class="line"></span>
    <span class="line-2 position-absolute" style="" :class="{ 'active':active }"></span>
  </div>
</template>

<style scoped lang="scss">
/* Line between steps */
.line {
  display: block;
  width:105%;
  height: 4px;
  background-color: rgb(var(--v-theme-secondary-lighten-3));
  margin: 0 -5px;
  transition: linear 0.25s all;
}

.line-2 {
  top:0;
  width: 0;
  height: 4px;
  transition: linear 0.25s all;
}

.line-2.active {
  width:105%;
  background-color: #F79009;
}
</style>