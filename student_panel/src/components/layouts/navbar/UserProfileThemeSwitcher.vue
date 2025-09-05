<script setup>
  import {useThemeManager} from "@/composable/useThemeManager";

  const { currentThemeName, changeTheme } = useThemeManager();
</script>

<template>
  <div>
    <v-switch
        density="compact"
        inset
        color="warning"
        v-model="currentThemeName"
        @click="changeTheme"
        false-icon="$mdiWeatherNight"
        false-value="dark"
        true-value="light"
        true-icon="$mdiWeatherSunny"
        hide-details
    ></v-switch>
  </div>
</template>

<style scoped lang="scss">

</style>