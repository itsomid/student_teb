<script setup>
  import ClVideoJSPlayer from "@/components/players/ClVideoJSPlayer.vue";

  const props = defineProps(['item']);
  const emit = defineEmits(['openRatingModal']);

  const openRatingModal = (item)=>{
    emit('openRatingModal', item);
  }
</script>

<template>
  <v-card elevation="0" @click.prevent.stop="openRatingModal({
  teacher_id:item.teacher_id,
  video_id: item.video_id,
  })"
  rounded="xl"
  >
    <div >
      <div class="position-absolute   w-100 h-100 bg-transparent" style="z-index: 88888"></div>
      <ClVideoJSPlayer :vodLink="item.video_url" rounded="rounded-xl"/>
    </div>
    <p class="text-right mt-4 text-secondary-darken-2 font-weight-bold">
      {{ item.name }}
    </p>
    <div class="d-flex flex-row">
      <v-spacer/>
      <span class="d-flex justify-center align-center ga-1 text-secondary text-caption">
        از
        {{ item.total_rate }}
        آرا
        <span class="mr-4">
          {{ item.student_rate }}
        </span>
        <v-rating
            readonly
            :length="1"
            :size="24"
            color="warning"
            :model-value="item.student_rate"
            half-increments
        />
      </span>
    </div>
  </v-card>
</template>

<style scoped lang="scss">

</style>