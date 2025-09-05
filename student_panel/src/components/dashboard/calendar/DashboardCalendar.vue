<script setup>
import {useStore} from "vuex";
import DashboardCalendarWeekChanger from "@/components/dashboard/calendar/DashboardCalendarWeekChanger.vue";
import {useWeeklyClasses} from "@/composable/dashboard/useDashboardWeeklyClasses";
import DashboardCalendarWeeklySchedule from "@/components/dashboard/calendar/DashboardCalendarWeeklySchedule.vue";
import {onBeforeUnmount } from "vue";

const { classes, loading, weekNumber,selectedDay, endWeek, startWeek, nextWeek, prevWeek, selectToday} = useWeeklyClasses();

const store = useStore();
// const selectClass = ()=> {
//   store.dispatch('dashboard/updateCourseClass',{id: 12});
//   showClass();
// }


// const showClass = ()=> {
//   store.dispatch('dashboard/closeNotificationDrawer');
//   store.dispatch('dashboard/openClassDrawer');
// }

onBeforeUnmount(()=> {
  store.dispatch('dashboard/closeClassDrawer')
  store.dispatch('dashboard/clearCourseClass')
})


</script>

<template>
  <div >
    <DashboardCalendarWeekChanger
        v-model="weekNumber"
        :selected-day="selectedDay"
        :loading="loading"
        :data="{
          startWeek,
          endWeek
        }"
        @next="nextWeek"
        @prev="prevWeek"
        @select-today="selectToday"
    />

    <DashboardCalendarWeeklySchedule v-model="selectedDay" :week-number="weekNumber" :data="classes"/>
  </div>
</template>

<style scoped lang="scss">

</style>