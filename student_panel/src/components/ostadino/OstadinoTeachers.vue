<script setup>
import RepositoryFactory from "@/repository/RepositoryFactory";
import {onMounted, reactive, ref, watch} from "vue";
import {DEFAULT_IMAGE_PATH} from "@/config/filePath.config";
import {useUrl} from "@/composable/useUrl";
import ClPagination from "@/components/app/ClPagination.vue";

const props = defineProps({
  step: {
    type: [String, Number],
    default: 0
  }
})
const desktopHeaders = [
  {
    title: "نام استاد",
    key: "name",
    sortable: false,
    align: 'start',
    maxWidth: '150px',
  },
  {
    title: "درس",
    key: "lessons",
    sortable: false,
    align: 'start',
    maxWidth: '150px',
  },
  {
    title: "تعداد نظرات",
    key: "total_count_rate",
    sortable: false,
    align: 'start',
    maxWidth: '150px',
  },
  {
    title: "امتیاز دانش آموز",
    key: "student_rate",
    sortable: false,
    align: 'start',
    maxWidth: '150px',
  },
  {
    title: "امتیاز کارشناس",
    key: "expert_score",
    sortable: false,
    align: 'start',
    maxWidth: '150px',
  },
  {
    title: "امتیاز کل",
    key: "total_rate",
    sortable: false,
    align: 'start',
    maxWidth: '150px',
  },
]
const mobileHeaders = [
  {
    title: "نام استاد",
    key: "name",
    sortable: false,
    align: 'start',
    maxWidth: '150px',
  },
  {
    title: "امتیاز دانش آموز",
    key: "student_rate",
    sortable: false,
    align: 'start',
    maxWidth: '150px',
  },
  {
    title: "امتیاز کل",
    key: "total_rate",
    sortable: false,
    align: 'start',
    maxWidth: '150px',
  },
]

const {imageUrlBuilder, defaultImageUrlBuilder} = useUrl();
const OstadinoRepository = RepositoryFactory.get('Ostadino');
const loading = ref(true);
const teachers = ref([]);
const pagination = reactive({
  last_page: 1,
  current_page: 1,
  per_page: 10,
})

const getTeachers = async (level, query = {page: 1}) => {
  try {
    loading.value = true;
    const {data: {data, meta}} = await OstadinoRepository.getTeachers(level, query);
    teachers.value = data;
    pagination.last_page = meta.last_page;
    pagination.current_page = meta.current_page;
    pagination.per_page = meta.per_page
  } catch (e) {
    console.log(e)
  } finally {
    loading.value = false;
  }
}

onMounted(() => {
  getTeachers(props.step);
})

watch(() => props.step, (value) => {
  getTeachers(value);
})
watch(() => pagination.current_page, (value) => {
  getTeachers(props.step, {
    page: value
  })
})

const hovering  = reactive({
  isHovering: false,
  index: -1
});
const checkHover = (index,isHover)=> {
  hovering.isHovering = isHover;
  hovering.index = index;
}
</script>

<template>
  <div class="grid-table mt-16 pt-6">
    <!-- Table Headers -->
    <div class="grid-header">
      <div
          v-for="header in $vuetify.display.mobile ? mobileHeaders : desktopHeaders" :key="header.key"
          class="header-cell text-secondary text-right"
          :class="{'text-center' : $vuetify.display.mobile}"
        >
        <span>
           {{ header.title }}
        </span>
      </div>
    </div>

    <!-- Table Rows -->
    <v-card
        :variant="hovering.isHovering && hovering.index === index ? 'tonal' : 'flat'"
        :color="hovering.isHovering && hovering.index === index ? 'primary' : ''"
        class="grid-row pa-0 py-5"
        rounded="xl"
        @mouseover="checkHover(index,true)"
        @mouseleave="checkHover(-1,false)"
        v-for="(item, index) in teachers"
        :key="index"
    >
      <div  class="row-cell text-right">
        <div class="d-flex flex-row align-center text-secondary font-weight-bold">
          <span class="mr-2">
            {{ item.name }}
          </span>
        </div>
      </div>
      <div v-if="!$vuetify.display.mobile" class="row-cell  d-flex flex-column justify-center align-start">
        <div class="d-flex flex-row text-secondary">
          <div class="mx-1" v-for="(lesson, index) in item.lessons">
            {{ lesson }}
            <span v-if="index < item.lessons.length - 1">،</span>
          </div>
        </div>
      </div>
      <div v-if="!$vuetify.display.mobile" class="row-cell d-flex flex-column justify-center align-start">
        <div class="d-flex flex-row  align-center text-secondary" :class="{'fade-element' : hovering.isHovering && hovering.index === index}">
          <span>{{ item.total_count_rate }}</span>
        </div>
      </div>
      <div class="row-cell d-flex flex-column justify-center align-start">
        <div  class="d-flex flex-row  align-center text-secondary " :class="{'slide-element' : hovering.isHovering && hovering.index === index}">
          <v-rating  readonly
                     :length="1"
                     :size="24"
                     empty-icon="cli:Star1"
                     half-icon="cli:Star1:type:bulk"
                     full-icon="cli:Star1:type:bold"
                     color="secondary"
                     :model-value="item.student_rate"
                     active-color="secondary"
                     half-increments>
          </v-rating>
          <span class="mx-2">{{ item.student_rate }}</span>
        </div>
      </div>
      <div v-if="!$vuetify.display.mobile" class="row-cell d-flex flex-column justify-center align-start">
        <div v-if="!!item.expert_score" class="d-flex flex-row  align-center text-secondary">
          <v-rating  readonly
                     :length="1"
                     :size="24"
                     empty-icon="cli:Star1"
                     half-icon="cli:Star1:type:bulk"
                     full-icon="cli:Star1:type:bold"
                     color="secondary"
                     :model-value="item.expert_score"
                     active-color="secondary"
                     half-increments>
          </v-rating>
          <span class="mx-2">{{ item.expert_score }}</span>
        </div>
        <div v-else class="d-flex flex-row  align-center text-secondary">
          <span class="mx-2">درحال بررسی</span>
        </div>
      </div>
      <div class="row-cell d-flex flex-column justify-center align-start">
        <div v-if="!!item.expert_score" class="d-flex flex-row  align-center text-secondary">
          <v-rating  readonly
                     :length="1"
                     :size="24"
                     empty-icon="cli:Star1"
                     half-icon="cli:Star1:type:bulk"
                     full-icon="cli:Star1:type:bold"
                     color="warning"
                     :model-value="item.total_rate"
                     active-color="warning"
                     half-increments>
          </v-rating>
          <span class="mx-2">{{ item.total_rate }}</span>
        </div>
        <div v-else class="d-flex flex-row  align-center text-secondary">
          <span class="mx-2">محاسبه نشده</span>
        </div>
      </div>
    </v-card>

    <div class="mt-16">
      <ClPagination :total-pages="pagination.last_page" v-model="pagination.current_page" size="small" />
    </div>
  </div>
</template>

<style scoped lang="scss">
.grid-table {
  display: grid;
  gap: 16px;
  font-size: 16px!important;
  width: 100%;
}

.grid-header {
  display: grid;
  grid-template-columns: repeat(6, 1fr); /* Six columns */
  font-size: 16px;
  font-weight: bold;
  padding-bottom: 16px;
  border-bottom: 1px solid rgb(var(--v-theme-secondary-lighten-2));
}

.header-cell {
  text-align: right;
  font-size: 14px;
}

.grid-row {
  display: grid;
  grid-template-columns: repeat(6, 1fr); /* Six columns */
  border-radius: 8px; /* Rounded corners for rows */
  transition: all 0.3s ease;
  padding: 16px;
  border: 2px solid rgba(0,0,0,0);
}

.grid-row:hover {
  border: 2px solid rgb(var(--v-theme-primary));
}

.row-cell {
  display: flex;
  text-align: center;
  padding: 8px;
}

@media (max-width: 1280px) {
  .grid-header {
    display: grid;
    grid-template-columns:repeat(3, 1fr); /* Three columns */
    font-size: 14px;
    font-weight: bold;
    padding: 4px;
  }
  .grid-row {
    display: grid;
    font-size: 14px!important;
    grid-template-columns: repeat(3, 1fr); /* Three columns */
    border-radius: 8px; /* Rounded corners for rows */
    transition: all 0.3s ease;
    padding: 12px;
    border: 2px solid rgba(0,0,0,0);
  }
}


.slide-element {
  animation: slide 0.3s ease-in-out; /* Animation that repeats infinitely */
}

@keyframes slide {
  0% {
    transform: translateX(500%); /* Starting position */
  }
  100% {
    transform: translateX(0); /* Return to original position */
  }
}

.fade-element {
  animation: fade 0.3s ease-in-out; /* Animation that repeats infinitely */
}

@keyframes fade {
  0% {
    opacity: 0
  }
  100% {
    opacity: 1;
  }
}
</style>
