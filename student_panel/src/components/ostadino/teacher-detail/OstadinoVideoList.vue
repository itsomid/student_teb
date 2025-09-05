<script setup>
import {ref, defineProps} from "vue"
import OstadinoRatingModal from '@/components/ostadino/OstadinoRatingModal.vue'
const props = defineProps({
  items:{
    type: Array,
    required: true
  }
})
import { useRoute } from 'vue-router'
const isShowRatingModal = ref(false)
const route = useRoute()
const selectedVideo = ref(false)
const openRatingModal = (item) => {
  selectedVideo.value = item
  isShowRatingModal.value = true
}
const closeRatingModal = () => {
  selectedVideo.value = null
  isShowRatingModal.value = false
}
</script>

<template>
  <v-col cols="12" md="4" class="align-center" :class="$vuetify.display.mdAndDown ? 'px-8 mt-8':''">
    <h4 class="text-h5 font-weight-bold">ویدیو ها</h4>
    <v-list mandatory base-color="secondary" class="mt-10">
      <template v-for="(item,index) in items"  :key="'item_index'+index" >
          <v-list-item title="نمونه تدریس مرحله اول" append-icon="cli:Play:type:bold" @click.prevent.stop="openRatingModal({
            teacher_id:item.teacher_id,
            video_id: item.video_id,
            })">
          </v-list-item>
        <v-divider v-if="index < items.length - 1" opacity="1"/>
      </template>
    </v-list>
    <OstadinoRatingModal
      v-if="selectedVideo"
      v-model="isShowRatingModal"
      :teacher_id_from_url="route?.query.teacher_id"
      :teacher_id="selectedVideo.teacher_id"
      :video_id="selectedVideo.video_id"
      @close="closeRatingModal"
    />
  </v-col>
</template>

<style scoped lang="scss">

</style>
