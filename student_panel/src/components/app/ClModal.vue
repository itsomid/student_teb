<script setup>
  import {useThemeManager} from "@/composable/useThemeManager";
  const { isDark } = useThemeManager();
  const dialog = defineModel({default:false});
  const props = defineProps({
    width: {
      type: [String,Number],
      default: '500'
    },
    persistent: {
      type: Boolean,
      default: false
    },
    opacity: {
      type: Number,
    },
    dialogTheme:{
      type: String,
      default:'light'
    },
    cardTheme :{
      type: String,
      default:'light'
    }
  })
  const { getUserTheme } = useThemeManager()
</script>

<template>
  <v-dialog
      v-model="dialog"
      :width="width"
      max-width="100%"
      :persistent="persistent"
      :opacity="opacity"
      :theme="dialogTheme ? dialogTheme : getUserTheme"
  >
    <v-card
        rounded="xl"
        flat
        border
        max-width="100%"
        class="mx-3"
        v-bind="$attrs"
        :theme="cardTheme ? cardTheme : getUserTheme"
    >
      <slot />
    </v-card>
  </v-dialog>
</template>

<style scoped lang="scss">

</style>