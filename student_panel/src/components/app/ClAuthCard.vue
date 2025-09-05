<script setup>
import { defineProps } from 'vue';
import logo from "@/assets/images/logo/logo.png";
import FormGenerator from "@/components/base/form/FormGenerator.vue";
import { useRouter } from "vue-router";
const props = defineProps({
  back: {
    type: Boolean,
    default: false
  }
})
const emits = defineEmits(['back']);
const router = useRouter();
const goBack = () => {
  emits('back');
  router.push({ name: 'authentication' });
}
</script>

<template>
  <v-card rounded="xl" width="100%" max-width="500" elevation="12" min-height="400" style="box-sizing: border-box">
    <v-card-title class="justify-center pa-6 pa-lg-6">
      <v-btn v-if="props.back" variant="text" icon="$arrowRight" position="absolute" location="center right"
        color="#000000aa" class="mx-8" style="z-index: 2;" @click="goBack">
        <v-icon>$arrowRight</v-icon>
      </v-btn>
      <div class="d-flex flex-row align-center">
        <v-img width="100" height="100" :src="logo" alt="classino" class="mx-auto" />
      </div>
    </v-card-title>
    <slot name="head" />
    <v-card-text class="px-7">
      <slot name="body" />
    </v-card-text>
    <v-card-actions v-if="$slots.action" class="d-flex justify-center align-center  px-6">
      <slot name="action" />
    </v-card-actions>
    <!--      <v-divider v-if="$slots.action" class="mx-16"></v-divider>-->
    <slot name="bottom" />
  </v-card>
</template>

<style scoped lang="scss">
.cl-auth-card {
  border: 3px solid rgba(255, 255, 255, 0.50);
  background: rgba(255, 255, 255, 0.70);
  backdrop-filter: blur(17px);
  border-radius: 48px !important;
  box-shadow: 0px 16px 32px -16px rgba(0, 0, 0, 0.16) !important;
  transition: box-shadow .2s linear;

  &:hover {
    box-shadow: 0px 16px 32px -16px rgba(0, 0, 0, 0.7) !important;
  }
}
</style>