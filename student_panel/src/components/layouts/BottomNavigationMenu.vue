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
const isActiveLink = (item) => {
  const matchedRoute = route.matched.some(record => record.name === item.to.name);
  return matchedRoute;
}
</script>

<template>
  <v-bottom-navigation height="72" elevation="0" border >
    <div   v-for="(item, index) in items"
           :key="'navigation-drawer-item-' + index "
           @click="router.push(item.to)"
           class="nav-link-wrapper">
      <div class="d-flex flex-column cursor-pointer justify-center align-center mb-3  " style="z-index: 2">
        <div class="position-absolute   nav-link" :class="{'active bg-primary opacity-30' : isActiveLink(item)}">
        </div>
        <v-btn  color="transparent" rounded="pill" variant="text"  :to="item.to">
          <v-icon  size="24" :color="isActiveLink(item) ? 'primary' : 'onSurface'">
            {{ item.icon }}
          </v-icon>
          <span :class="{'text-primary' : isActiveLink(item)}">{{  item.text }}</span>
        </v-btn>
<!--        <span class="cl-navigation-drawer-item font-weight-bold mt-1" :class="{'text-primary' : isActiveLink(item)}">{{  item.text }}</span>-->
      </div>
    </div>

  </v-bottom-navigation>
</template>

<style scoped lang="scss">
.nav-link {
  transition: all 0.1s linear;
  transform: scale(0);
}
.active {
  width: 40px;
  height: 40px;
  filter: blur(16px);
  transform: scale(1);
}

.nav-link-wrapper:hover .nav-link {
  width: 40px;
  height: 40px;
  filter: blur(16px);
  transform: scale(1);
  background-color: rgb(var(--v-theme-secondary-lighten-4));
  z-index: 1;
}

.nav-link-wrapper:active .nav-link{
  width: 40px;
  height: 40px;
  filter: blur(16px);
  transform: scale(1);
  background-color: rgb(var(--v-theme-primary));
  opacity: 0.3;
}
</style>