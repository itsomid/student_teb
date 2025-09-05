<script setup>
import {useDate} from "@/composable/useDate";
import {computed} from "vue";

const emits = defineEmits(['next','prev', 'changeDate','selectToday']);
const props = defineProps({
  data : {
    type:Object,
    required: true,
  },
  // weekNumber : {
  //   type: [Number,String],
  //   required: true,
  // },
  selectedDay: {
    type:[String],
  },
  loading: {
    type: Boolean,
    default: false,
  }
})

const { getCurrentDate } = useDate();

const weekNumber = defineModel({default:0})

const nextWeek = ()=> {
  emits('next');
}

const prevWeek = ()=> {
  emits('prev');
}

//Select specific date
const selectDate = (date) => {
  emits('changeDate', date)
}

const selectToday = () => {
  emits('selectToday')
}

const isToday = computed(()=> props.selectedDay === getCurrentDate());

</script>

<template>
  <div class="d-flex flex-row justify-space-between align-center">
    <v-btn height="44"  @click="prevWeek" :disabled="loading" flat variant="text" border rounded="lg" :icon="$vuetify.display.mdAndDown">
      <v-icon>$mdiChevronRight</v-icon>
      <span v-if="$vuetify.display.lgAndUp">
                   هفته قبل
      </span>
    </v-btn>
    <div>
      <v-chip style="height: 44px" label variant="text" border rounded="lg">
        <v-progress-circular v-if="loading" color="secondary" width="2" size="20" indeterminate />
        <span v-else>
        از {{ data.startWeek }} تا {{ data.endWeek }}
            <v-icon>$mdiCalendarMonth</v-icon>
      </span>
      </v-chip>
      <v-btn
          v-if="!isToday"
          @click="selectToday"
          :disabled="loading"
          height="44"
          flat
          variant="tonal"
          color="primary"
          border="primary sm opacity-50"
          class="mr-1"
          rounded="lg">
          <span v-if="$vuetify.display.lgAndUp">نمایش</span>
        امروز
      </v-btn>
    </div>
    <v-btn height="44" @click="nextWeek" :disabled="loading"  flat variant="text" border rounded="lg" :icon="$vuetify.display.mdAndDown">
      <span v-if="$vuetify.display.lgAndUp">
              هفته بعد
      </span>
      <v-icon >$mdiChevronLeft</v-icon>
    </v-btn>
  </div>
</template>

<style scoped lang="scss">

</style>