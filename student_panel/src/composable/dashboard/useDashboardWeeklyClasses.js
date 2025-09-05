import {onMounted, ref } from 'vue';
import { useAlert } from "@/composable/useAlert";
import RepositoryFactory from "@/repository/RepositoryFactory";
import { useDate } from "@/composable/useDate";

export function useWeeklyClasses() {
    const CURRENT_WEEK = 0;
    const classes = ref([]);
    const weekNumber = ref(CURRENT_WEEK);
    const selectedDay = ref();
    const startWeek = ref();
    const endWeek = ref();
    const errorMessage = ref(null);
    const loading = ref(false);
    const { error } = useAlert();
    const { getStartWeek, getEndWeek, getDayByWeekAndDayNumber, getCurrentDayNumber } = useDate();
    const WeeklyScheduleRepository = RepositoryFactory.get("Schedule");

    // Common error handler
    function handleError(e, fallbackMessage) {
        errorMessage.value = e;
        error(e?.error?.message || fallbackMessage);
    }

    // Fetch weekly classes based on the given week number
    async function fetchWeeklyClasses() {
        loading.value = true;
        try {
            const { data: { data } } = await WeeklyScheduleRepository.getUserClassesWithinWeek({
                week: weekNumber.value
            });
            classes.value = data;
            startWeek.value = getStartWeek(weekNumber.value);
            endWeek.value = getEndWeek(weekNumber.value);
        } catch (e) {
            handleError(e, 'دریافت اطلاعات برنامه هفتگی با مشکل مواجه شده است. لطفا مجددا تلاش کنید.');
        } finally {
            loading.value = false;
        }
    }

    // Navigate to the next week
    async function nextWeek() {
        weekNumber.value += 1;
        await fetchWeeklyClasses();
    }

    // Navigate to the previous week
    async function prevWeek() {
        weekNumber.value -= 1;
        await fetchWeeklyClasses();
    }

    // Fetch classes for the current week and set today as the selected day
    async function selectToday() {
        if(weekNumber.value !== CURRENT_WEEK){
            weekNumber.value = CURRENT_WEEK;
            await fetchWeeklyClasses();
        } else {
            startWeek.value = getStartWeek(weekNumber.value);
            endWeek.value = getEndWeek(weekNumber.value);
        }
        selectedDay.value = getDayByWeekAndDayNumber(weekNumber.value, getCurrentDayNumber() + 1).date;
    }

    function selectDefaultDay() {
        selectedDay.value = weekNumber.value !== CURRENT_WEEK
            ? getDayByWeekAndDayNumber(weekNumber.value, 1).date
            : getDayByWeekAndDayNumber(weekNumber.value, getCurrentDayNumber() + 1).date;
    }

    // Fetch weekly classes on component mount
    onMounted(() => {
        fetchWeeklyClasses();
        selectDefaultDay();
    });

    return {
        CURRENT_WEEK,
        classes,
        errorMessage,
        loading,
        weekNumber,
        startWeek,
        endWeek,
        nextWeek,
        prevWeek,
        selectToday,
        selectedDay,
        selectDefaultDay,
        fetchWeeklyClasses,
    };
}
