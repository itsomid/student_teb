<script setup>
import { themes } from "@/config/themes.config";
import ThemeSwitcher from "@/components/layouts/navbar/ThemeSwitcher.vue";
</script>

<template>
  <ThemeSwitcher :themes="themes" />
</template>
