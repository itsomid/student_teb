<script setup>
import {useProductData} from "@/composable/package/usePlanZProductData";
import {useSectionSelection} from "@/composable/package/usePlanZSectionSelection";
import {DAYS_OF_WEEK} from "../../constants/date.const";
import {ref} from "vue";
const emits = defineEmits([]);
import {useCart} from "@/composable/useCart";
import {useThemeManager} from "@/composable/useThemeManager";
import {useAlert} from "@/composable/useAlert";

const props = defineProps({
  productId: [Number,String],
})
const { productId,product, sections, loading, initialSelectedItems,serverSelectedItems } = useProductData(props.productId);
const { selectedCourses, sectionSelected, select, currentStep } = useSectionSelection(product,initialSelectedItems);

const { success } = useAlert();
const oldSelectedTeacher = ref('');
const newSelectedTeacher = ref('');
const courseName = ref('');

const headers = [
  {
    title: "درس",
    key: "name",
    sortable: false,
    align: 'start',
  },
  {
    title: "استاد",
    key: "teacher",
    sortable: false,
    align: 'start',
  },
  {
    title: "تاریخ شروع",
    key: "start_date",
    sortable: false,
    align: 'start',
  },
  {
    title: "روز‌های برگزاری",
    key: "holding_days",
    sortable: false,
    align: 'start',
  },
  {
    title: "ساعت برگزاری",
    key: "holding_date",
    sortable: false,
    align: 'start',
  },
  {
    title: "",
    key: "actions",
    sortable: false,
    align: 'start',
  },
];
const expandRow = (item) => {
  if (!expanded.value.includes(item.section_id)) {
    expanded.value = [];
    expanded.value.push(item.id);
    model.value = { section_id: item.section_id,teacher_id: serverSelectedItems.value.section_teacher.find((section)=> section.section_id === item.section_id).teacher_id}
  };
};

const collapseRow = (item) => {
  expanded.value = expanded.value.filter(expandedID=> expandedID !== item.section_id);
};

const collapseAllRow = () => {
  expanded.value = [];
};
const expanded = ref([]);

const isExpanded = (id)=> expanded.value.includes(id);


const model = ref();
const updateLoading = ref(false);



const getTeacherSelected = ()=> {
  const selectedSection = sections.value.find((section) => section.id === model.value.section_id);
  return selectedSection.courses.find((course)=> course.is_selected).teacher_name;
}

const updateSectionOnUserChange = ()=> {
  for (let i = 0; i < sections.value.length; i++) {
    for (let j = 0; j < sections.value[i].courses.length; j++) {
      if (sections.value[i].courses[j].product_id === selectedCourses[sections.value[i].id]) {
        sections.value[i].courses[j].is_selected = true
      } else sections.value[i].courses[j].is_selected = false;
      if(sections.value[i].id === model.value.section_id){
        newSelectedTeacher.value = sections.value[i].courses.find((course)=> course.is_selected).teacher_name
      }
    }
  }
}

const {addPlanZPackageToCart} = useCart({emits})
const submit = async () => {
  oldSelectedTeacher.value = getTeacherSelected();
  const payload = [];

  for (const key in selectedCourses) {
    payload.push({
      section_id: key,
      product_id: selectedCourses[key],
    })
  }

  for (let i = 0; i < sections.value.length; i++) {
    for (let j = 0; j < sections.value[i].courses.length; j++) {
      if (sections.value[i].courses[j].product_id === selectedCourses[sections.value[i].id]) {
        sections.value[i].courses[j].is_selected = true
      } else sections.value[i].courses[j].is_selected = false;
    }
  }


  try {
    updateLoading.value = true;
    await addPlanZPackageToCart({
      product_id: props.productId,
      packages: payload,
    })
    collapseAllRow();

    updateSectionOnUserChange();

    success(`استاد درس ${courseName.value} از ${oldSelectedTeacher.value} به ${newSelectedTeacher.value} تغییر پیدا کرد`)
  } catch (e) {
    console.log(error);
  } finally {
    updateLoading.value = false;
  }
}

const {isDark} = useThemeManager();


const hasChangeSelectedItem = (item) => {
  courseName.value = item.name;
  return model.value.product_id === item.courses.find((course) => course.is_selected).product_id
}


</script>

<template>
  <v-data-table
      :items="sections"
      :headers="headers"
      item-value="id"
      hover=""
      :expanded.sync="expanded"
      hide-default-footer
      :items-per-page="-1"
      :loading="loading"
  >
    <template #item.teacher="{item}">
      <span class="font-weight-bold text-wrap"> {{ item.courses.find(item => item.is_selected).teacher_name }} </span>
    </template>
    <template #item.start_date="{item}">
      <span class="font-weight-bold text-wrap text-secondary">از {{
          item.courses.find(item => item.is_selected).start_date
        }} </span>
    </template>
    <template #item.holding_days="{item}">
      <span class="font-weight-bold text-wrap text-secondary"> {{
          DAYS_OF_WEEK[item.courses.find(item => item.is_selected).holding_days]
        }}  </span>
    </template>
    <template #item.holding_date="{item}">
        <span class="font-weight-bold text-wrap text-secondary">
  ساعت {{ item.courses.find(item => item.is_selected).holding_hours.join(" تا ") }}
        </span>
    </template>
    <template #item.actions="{item, index}">
      <v-btn v-if="isExpanded(item.id)" size="small" rounded="lg" variant="outlined" color="secondary"
             @click="collapseRow(item)">لغو
      </v-btn>
      <v-btn v-else size="small" rounded="lg" variant="outlined" color="primary" @click="expandRow(item)">تغییر</v-btn>

    </template>

    <template v-slot:expanded-row="{ columns, item }">
      <v-expand-transition mode="in-out" leave-absolute hide-on-leave>
        <tr :class="{'bg-grey-lighten-4' : !isDark, 'bg-grey-darken-3' : isDark}">
          <td class="pa-4" :colspan="columns.length - 1">
            <v-radio-group v-model="model">
              <v-radio
                  color="primary"
                  v-for="course in item.courses"
                  :label="course.name"
                  :value="{ section_id: item.id, product_id: course.product_id }"
                  @click="select({ section_id: item.id, product_id: course.product_id })"
              ></v-radio>
            </v-radio-group>
          </td>
          <td>
            <v-btn :disabled="hasChangeSelectedItem(item)" @click="submit" :loading="loading" size="small" rounded="lg"
                   color="primary">ثبت
            </v-btn>
          </td>
        </tr>

      </v-expand-transition>
    </template>
  </v-data-table>
</template>

<style scoped lang="scss">

</style>