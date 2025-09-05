<script setup>
import {computed, onMounted, ref, watch} from "vue";
import {useDate} from "@/composable/useDate";
import {DAYS_OF_WEEK_FOR_WEEKLY_SCHEDULE} from "@/constants/date.const";
import {useDisplay} from "vuetify";
import DashboardCalendarClass from "@/components/dashboard/calendar/DashboardCalendarClass.vue";
import {useThemeManager} from "@/composable/useThemeManager";
import DashboardCalendarClassEmpty from "@/components/dashboard/calendar/DashboardCalendarClassEmpty.vue";

  const props = defineProps({
    data: {
      type: Object,
      required: true,
    },
    weekNumber : {
      type: [Number,String],
      required: true,
    }
  })

  const { getDayByWeekAndDayNumber, getCurrentDayNumber } = useDate();
  const selectDay = defineModel();


const { lgAndUp } = useDisplay();
const { isDark } = useThemeManager();

const isActive = (dayNumber)=>{
  return selectDay.value === getDayByWeekAndDayNumber(props.weekNumber, dayNumber).date
}

const getDefaultDayByWeekNumber = (weekNumber, dayNumber) => {
  return getDayByWeekAndDayNumber(weekNumber,dayNumber).date;
}

const selectDefaultDayByWeekNumber = (weekNumber)=> {
  if(weekNumber !== 0 ) {
    selectDay.value = getDefaultDayByWeekNumber(weekNumber,1);
  }else selectDay.value = getDayByWeekAndDayNumber(weekNumber,getCurrentDayNumber()+1).date;
}

onMounted(()=>{
  selectDay.value = getDefaultDayByWeekNumber(props.weekNumber,getCurrentDayNumber()+1);
})

watch(()=> props.weekNumber, (value)=> {
  selectDefaultDayByWeekNumber(value)
})
</script>

<template>
  <v-card :color="$vuetify.display.mdAndUp ? '' : 'transparent'" flat :border="$vuetify.display.lgAndUp" class="mt-4" rounded="xl">
    <v-tabs
        v-model="selectDay"
        hide-slider
        :grow="true"
        :bg-color="isDark ? 'grey-darken-3' : 'grey-lighten-5'"
        selected-class="bg-surface"
        :class="$vuetify.display.mdAndDown ? 'border-t border-e border-s rounded-t-xl border-b' : ''"
        color="primary"

    >
      <v-tab
          v-for="(day,index) in DAYS_OF_WEEK_FOR_WEEKLY_SCHEDULE"
          class="px-0"
          rounded="0"
          :min-width="lgAndUp ? '90px' : '50px'"
          :class="isActive(index) ? 'border border-b-0 border-t-0' : 'border-b'"
          :value="getDayByWeekAndDayNumber(weekNumber, index).date">
        <div class="d-flex flex-column-reverse flex-lg-row flex-xl-row">
          <span class="mx-1">
              {{ getDayByWeekAndDayNumber(weekNumber, index).day }}
          </span>
          <span>
          {{ lgAndUp ? day : day[0]}}
          </span>
        </div>
      </v-tab>
    </v-tabs>
    <v-tabs-window v-model="selectDay" >
      <v-tabs-window-item
          v-for="(day,index) in DAYS_OF_WEEK_FOR_WEEKLY_SCHEDULE"
          :value="getDayByWeekAndDayNumber(weekNumber, index).date">
        <div v-if="data[index - 1]">
          <DashboardCalendarClass v-for="item in data[index - 1]" :item="item" />
        </div>

        <v-card v-else height="500" class="d-flex justify-center align-center">
          <DashboardCalendarClassEmpty  />
        </v-card>
      </v-tabs-window-item>
    </v-tabs-window>
  </v-card>
</template>

<style scoped lang="scss">
  .schedule-hour {
    border-top: 1px solid rgba(var(--v-theme-secondary-lighten-4));
  }
</style>