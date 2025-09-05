<template>
    <v-layout>
      <v-main class="d-flex align-center justify-center " >
        <v-sheet color="#F2F4F7" min-height="100vh" width="100%" class="d-flex justify-center align-center pa-4">
          <router-view v-slot="{ Component, route }">
            <v-slide-x-transition hide-on-leave>
              <component :is="Component" :key="route.path"  />
            </v-slide-x-transition>
          </router-view>
        </v-sheet>
      </v-main>
    </v-layout>
</template>

<script>

</script>

<style scoped lang="scss">
.cl-auth-layout {
  background:linear-gradient(0deg, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.23)),url("@/assets/images/auth-bg.jpg") no-repeat;
  background-size: cover;
}
.scale-animation {
  animation: scale 0.45s ease-in-out  alternate;
  -webkit-animation: scale 0.45s ease-in-out  alternate;
}
@keyframes scale {
  0% {
    transform: scale(0);
    opacity: 0;
  }
  100% {
    opacity: 1;
    transform: scale(1);
  }
}

.fade-enter-active, .fade-leave-active {
  transition-property: opacity!important;
  transition-duration: .25s!important;
}

.fade-enter-active {
  transition-delay: .25s!important;
}

.fade-enter, .fade-leave-active {
  opacity: 0!important;
}

.text-shadow {
  text-shadow: 0px 2px 14px rgba(0, 0, 0, 0.32);
}

</style>