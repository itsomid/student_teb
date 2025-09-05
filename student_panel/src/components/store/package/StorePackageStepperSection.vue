<script setup>
import StorePackageCourseListItem from "@/components/store/package/StorePackageCourseListItem.vue";
import {DAYS_OF_WEEK} from "../../../constants/date.const";
import {useCart} from "@/composable/useCart";
import {computed} from "vue";
import {useNavigator} from "@/composable/useNavigator";
const emits = defineEmits(['addedToCart']);
const { loading, addToCart, addPackageToCart } = useCart({ emits });
const props = defineProps({
  section         : Object, // Section object containing section details
  index           : Number, // Index of the section in the stepper
  selectedCourses : Object, // Object containing selected courses for each section
  sectionSelected : Function, // Function to get the selected course for a section
  image           : Function, // Function to get the image path of the course teacher
  select          : Function, // Function to handle course selection
  sectionsLength   : Number, // Function to handle course selection
  isLast          : {
    type: Boolean,
    default: false
  },
  product_id: [Number,String],
  isInCart: Boolean,
})
const isValid = computed(() => {
  return props.sectionsLength === Object.keys(props.selectedCourses).length;
});

const { navigateToCart } = useNavigator();

const submit = async ()=>{
  const payload = [];
  if(!isValid) {
    error('شما باید در هر بخش یک درس را انتخاب کنید');
    return;
  }
  for(const key in props.selectedCourses){
    payload.push({
      section_id: key,
      product_id: props.selectedCourses[key],
    })
  }
  try {
    loading.value = true;
    await addPackageToCart({
      product_id: props.product_id,
      packages: payload,
    })
    await navigateToCart();
  }catch (e) {
    console.log(error);
  }finally {
    loading.value = false;
  }
}
</script>

<template>
  <!-- Vertical stepper item representing a section -->
  <v-stepper-vertical-item
      class="rounded-xl"
      :complete="!!sectionSelected(section.id)"
      :title="section.name"
      :value="index + 1"
  >
    <!-- List of courses within the section -->
    <v-list nav rounded="lg" lines="three" color="primary" select-strategy="single-independent">
      <!-- Loop through courses in the section and create a list item for each -->
      <StorePackageCourseListItem
          v-for="course in section.courses"
          :key="'package-item-' + section.id + '-' + course.product_id"
          :section-id="section.id"
          :course="course"
          :isSelected="selectedCourses[section.id] === course.product_id"
          :image="image"
          :select="select"
      />
    </v-list>

    <!-- Custom title template slot displaying section name and selected course teacher's name -->
    <template #title>
      {{ section.name }},
      <span v-if="selectedCourses[section.id]">
              {{ sectionSelected(section.id).teacher_name }}
            </span>
    </template>

    <!-- Custom subtitle template slot displaying course start date, holding days, and start time -->
    <template #subtitle>
      <div v-if="selectedCourses[section.id]" class="mt-3">
        از {{ sectionSelected(section.id).start_date }} {{ DAYS_OF_WEEK[Number(sectionSelected(section.id).holding_days)] }}
        <span> ساعت {{ sectionSelected(section.id).holding_hours.join(" تا ") }}</span>
      </div>
      <div v-else class="mt-3"> انتخاب دوره </div>
    </template>

    <!-- Next button template slot, disabled if no course is selected -->
    <template v-slot:next="{ next }">
<!--      <div v-if="isLast">-->
<!--        <v-btn  v-if="isInCart" :loading="loading" :disabled="!isValid" color="primary" @click.prevent="submit">-->
<!--          <span >ویرایش پکیج</span>-->
<!--        </v-btn>-->
<!--        <v-btn  v-else :disabled="!isValid" :loading='loading' color="primary" @click.prevent="submit">-->
<!--          <span >ساخت پکیج</span>-->
<!--        </v-btn>-->
<!--      </div>-->
<!--      <v-btn v-else :disabled="!selectedCourses[section.id]" color="primary" @click="next">بعدی</v-btn>-->
    </template>

    <!-- Prev button template slot -->
    <template v-slot:prev="{ prev }">
      <!--                    <v-btn variant="plain" @click="prev">قبلی</v-btn>-->
    </template>
  </v-stepper-vertical-item>
</template>

<style scoped lang="scss">

</style>