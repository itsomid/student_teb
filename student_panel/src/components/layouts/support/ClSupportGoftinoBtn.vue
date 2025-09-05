<script setup>

import {onBeforeUnmount, onMounted, ref} from "vue";

const isGoftinoReady = ref(false);
const initGoftino = () => {
  isGoftinoReady.value = true;
  !function () {
    var i = "L1EmdY", a = window, d = document;

    function g() {
      var g = d.createElement("script"), s = "https://www.goftino.com/widget/" + i,
          l = localStorage.getItem("goftino_" + i);
      g.async = !0, g.src = l ? s + "?o=" + l : s;
      d.getElementsByTagName("head")[0].appendChild(g);
    }

    "complete" === d.readyState ? g() : a.attachEvent ? a.attachEvent("onload", g) : a.addEventListener("load", g, !1);
  }();
  window.addEventListener('goftino_ready', function () {
    Goftino.setWidget({
      hasIcon: false,
      hasSound: false,
    });
  });
};

function openGoftino(){
  Goftino.open();
}
onMounted(()=> {
  initGoftino();
})

</script>

<template>
  <v-list max-width="320"  nav color="info">
    <v-list-item active   color="info" @click="openGoftino">
      چت با تیم پشتیبانی فنی
    </v-list-item>
  </v-list>
</template>

<style scoped lang="scss">

</style>