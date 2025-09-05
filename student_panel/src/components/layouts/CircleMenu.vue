<script setup>
import {LINKS} from "@/config/navigationDrawerItems.config";
import {onMounted, reactive, ref} from "vue";
import {useRouter,useRoute} from "vue-router";
import {useThemeManager} from "@/composable/useThemeManager";

const router = useRouter();
const route = useRoute();

const items = reactive(LINKS)
const isActive = ref(false);
const activeItem = ref({});
const toggleMenu = ()=> {
  isActive.value = !isActive.value;
}

const closeMenu = ()=> {
  isActive.value = false;
}

const activeLink = (index)=> {
  items.forEach((item)=> item.isActive = false);
  items[index].isActive = true;
  activeItem.value = items[index];
  router.push(activeItem.value.to)
}

const { isDark } = useThemeManager();

onMounted(() => {
  let index = items.findIndex((item)=> item.to.name === route.name);
  if(index > -1) activeLink(index);
})
</script>

<template>
  <div class="menu-container" v-click-outside="closeMenu">
    <ul  class="menu"  :class="{ 'active': isActive, 'dark' : isDark}">
      <div  @click="toggleMenu" class="toggle " :class="{ 'active bg-background': isActive, 'dark' : isDark }">
        <v-icon size="30" >$mdiMenu</v-icon>
      </div>
      <li v-for="(item,index) in items"
          :style="`--i:${index};`"
          @click="activeLink(index)"
          :class="{
            'active': item.isActive,
            'text-white': item.isActive && !isDark,
            'text-black': item.isActive && isDark
          }" >
        <div>
          <i role="presentation" class="nav-icon text-h4"  :class="[item.icon, ]"></i>
<!--          <v-icon size="20"> {{  item.icon2 }}</v-icon>-->
        </div>
      </li>

      <div class="indicator" :class="{ 'dark' : isDark}">
        <v-chip rounded="xl" class="font-weight-medium" :class="{'text-white' : !isDark, 'text-black' : isDark}" v-if="isActive" color="primary" variant="elevated" tag="span"> {{ activeItem.text }}</v-chip>
      </div>
    </ul>
  </div>
</template>

<style scoped lang="scss">
$background-dark: #121212;
$secondary-dark:#424242;
$secondary-light:#dddddd;
$background: #121212;
$background-light: #f9fAfB;
$base: #036af5;
$baseDark: #FFAF20;
$indicatorColor: #424242;
.menu {
  z-index: 1000000;
  width: 300px;
  height: 300px;
  display: flex;
  justify-content: center;
  align-items: center;
  position: fixed;
  bottom: -40px;
  left:-100px;
  //transform: translateX(-105px) translateY(105px);
  transition: 0.5s;
}

.menu.active {
  transform: translateX(0px) translateY(-140px);
}


.menu .toggle {
  position: absolute;
  width: 75px;
  height: 75px;
  border-radius: 50%;
  display: flex;
  background: $base;
  justify-content: center;
  align-items: center;
  cursor: pointer;
  transition: 0.5s;
  //filter: blur(4px);
}
.menu .toggle.dark {
  background: $baseDark;
}
.menu .toggle.active {
  transform: rotate(360deg);
  box-shadow: 0 0 0 60px $secondary-light,
  0 0 0 65px $background-light;
}

.menu .toggle.active.dark {
  box-shadow: 0 0 0 60px $secondary-dark,
  0 0 0 65px $background-dark;
}

.menu li {
  position: absolute;
  list-style: none;
  left: 10px;
  transform-origin: 140px;
  visibility: hidden;
  opacity: 0;
  transition: 0.5s;
  z-index: 10;
}

.menu.active li {
  visibility: visible;
  opacity: 1;
  transform: rotate(calc(360deg / 8 * var(--i) + 90deg)) translateX(40px);
}

.menu li div {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 55px;
  height: 55px;
  font-size: 1.2em;
  transform: rotate(calc(360deg / -8 * var(--i) - 90deg)) ;
  border-radius: 50%;
}

.menu.active li.active {
  transform: rotate(calc(360deg / 8 * var(--i) + 90deg)) translateX(12px);
}

.indicator {
  position: absolute;
  top:calc(50% + 1px);
  left: calc(50% + 1px );
  transform-origin: right;
  width: 100px;
  height: 1px;
  background-color: transparent!important;
  pointer-events: none;
  transition: 0.5s;
}

.indicator::before {
  content: "";
  position: absolute;
  top: -27.5px;
  left: 72px;
  width: 55px;
  height: 55px;
  box-shadow: 0 0 0 6px $base;
  border-radius: 50%;
  transition: 0.5s;
  opacity: 0;
}

.indicator.dark::before {
  box-shadow: 0 0 0 6px $baseDark;
}

.indicator span {
  left: 50%;
  top: 50%;
  transform: translate(-50%,-50%) scale(-1,-1);
  transform-origin: -30px;
  position: absolute;
  transition: 0.5s;
  opacity: 0;
}

.menu.active   .indicator::before {
  opacity: 1;
  top: -28px;
  left: -28px;
  background-color:$base;
  box-shadow: 0 0 0 6px $background-light;
}

.menu.active   .indicator.dark::before{
  background-color:$baseDark;
}
.menu.active.dark   .indicator::before {
  box-shadow: 0 0 0 6px $background-dark;
}

.menu li:nth-child(2).active ~ .indicator {
  transform:translateX(-103px) rotate(90deg);
}
.menu li:nth-child(3).active ~ .indicator {
  transform:translateX(-103px) rotate(135deg);
}
.menu li:nth-child(4).active ~ .indicator {
  transform:translateX(-103px) rotate(180deg);
}
.menu li:nth-child(5).active ~ .indicator {
  transform:translateX(-103px) rotate(225deg);
}

.menu li.active ~ .indicator span {
  opacity: 1;
}

</style>