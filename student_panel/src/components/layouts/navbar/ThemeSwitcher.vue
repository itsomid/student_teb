<script setup>
import { themes } from "@/config/themes.config";
import {useThemeManager} from "@/composable/useThemeManager";

const {changeTheme, currentThemeIndex } = useThemeManager();
</script>

<template>
   <VBtn size="small" class="me-2" icon  @click="changeTheme">
     <VIcon
         size="22"
         :icon="themes[currentThemeIndex].icon" />
   </VBtn>
</template>
