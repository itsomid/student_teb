<script setup>
import { DAYS_OF_WEEK } from "@/constants/date.const";

const props = defineProps({
  sectionId : Number, // Section ID to which the course belongs
  teacher    : Object, // Course object containing course details
  isSelected: Boolean, // Boolean indicating if the course is selected
  image     : Function, // Function to get the image path of the course teacher
  select    : Function // Function to handle course selection
})
</script>

<template>
    <!-- List item representing a course -->
    <v-list-item
        :variant="isSelected ? 'tonal' : 'elevated'"
        elevation="0"
        :border="isSelected ? 'primary sm opacity-100' :'secondary sm opacity-80'"
        :color="isSelected ? 'primary' : 'white'"
        :value="{ section_id: sectionId, teacher_id: teacher.teacher_id }"
        @click="select({ section_id: sectionId, teacher_id: teacher.teacher_id })"
        :active="isSelected"
        rounded="xl"
    >
      <template #prepend>
        <v-avatar color="white" :image="image(teacher.teacher_img)" />
      </template>
      <!-- Append slot for adding a radio button to the list item -->
      <template v-slot:append="{ isActive }">
        <v-list-item-action start>
          <v-radio :model-value="isActive"></v-radio>
        </v-list-item-action>
      </template>

      <!-- Course teacher's name as the title -->
      <v-list-item-title class="text-primary-darken-3">{{ teacher.teacher_name }}</v-list-item-title>

      <!-- Subtitle with course start date and holding days -->
      <v-list-item-subtitle v-for="(product) in teacher.products" class="mt-2 opacity-100">
        <v-icon>$mdiCircleSmall</v-icon>
        <span class="package-course">
           {{ product.name }}
         (        از {{ product.start_date }} {{ DAYS_OF_WEEK[Number(product.holding_days)] }} ساعت {{ product.holding_hours.join(" تا ") }})
        </span>
      </v-list-item-subtitle>
    </v-list-item>
</template>

<style scoped lang="scss">
.package-course {
  line-height: 24px        ;
}
</style>