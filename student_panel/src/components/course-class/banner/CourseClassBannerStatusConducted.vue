<script setup>
import {computed} from "vue";
import {useThemeManager} from "@/composable/useThemeManager";
const props = defineProps({
  record_video_kavimo: [String, Object],
  record_video_hls_path: [String, Object],
  record_video_HD_hls_path: [String, Object],
  record_video_kavimo_HD: [String, Object],
  class_id: [String,Number]
})

const { isDark } = useThemeManager();
const btnBackground = computed(() => isDark.value ? 'white' : 'black'); // Calculating btn theme based on current theme

</script>

<template>
  <div>
    <span>
    جلسه قبلا برگزار شده است
    </span>
    <div  class="mt-3 mt-lg-0">
      <p class="text-secondary text-caption mt-2">
        میتوانید جلسه را در سرور قدیم یا سرور جدید مشاهده کنید
      </p>
      <div class="justify-center align-center mt-6">
<!--      name = recorded-class  -->
        <v-btn
            v-if="record_video_kavimo || record_video_hls_path"
            rounded="lg"
            :to="{name:'recorded-class', params:{class_id: class_id, video_quality:'md'}}"
            class="mx-3"
            size="large"
            variant="outlined"
        >
          سرور  قدیم
        </v-btn>
        <v-btn
            v-if="record_video_kavimo_HD || record_video_HD_hls_path"
            :to="{name:'recorded-class', params:{class_id: class_id, video_quality:'hd'}}"
            :color="btnBackground"
            rounded="lg"
            class="mx-3"
            size="large"
        >
          سرور  جدید
        </v-btn>
      </div>
    </div>
  </div>
</template>

<style scoped lang="scss">

</style>