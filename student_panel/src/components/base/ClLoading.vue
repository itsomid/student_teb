<script>
import {defineComponent} from 'vue'

export default defineComponent({
  name: "ClLoading",
  props: {
    /**
     * @description to handle scale of loading
     * @type {number,string}
     * */
    scale: {
      type: [Number, String],
      default: 0.8
    }
  }
})
</script>

<template>
  <div class="cl-loading cl-loading--circles cl-loading--target">
    <div class="cl-loading__load" :style="{transform: `scale(${scale})`}">
      <div class="cl-loading__load__animation">
        <div class="cl-loading__load__percent"></div>
        <div class="cl-loading__load__animation__1"></div>
        <div class="cl-loading__load__animation__2"></div>
        <div class="cl-loading__load__animation__3"></div>
      </div>
    </div>
  </div>
</template>

<style scoped lang="scss">
  @import "@/assets/styles/components/loading";
</style>