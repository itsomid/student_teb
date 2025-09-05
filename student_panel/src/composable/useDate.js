import dayjs from "dayjs";
import isSameOrBefore from 'dayjs/plugin/isSameOrBefore';
import isSameOrAfter from 'dayjs/plugin/isSameOrAfter';
import isLeapYear from 'dayjs/plugin/isLeapYear';
import jalaliday from 'jalali-plugin-dayjs'
dayjs.extend(isSameOrBefore);
dayjs.extend(isSameOrAfter);


dayjs.extend(isLeapYear);
dayjs.extend(jalaliday);
// const isSameOrBefore = require('dayjs/plugin/isSameOrBefore');

/**
 * @description date types
 * @type { Object }
 * */
const DATE_TYPES = {
    LONG                : "ddd DD MMMM YYYY ساعت HH:mm",
    SHORT               : "YYYY/MM/DD",
    SHORT_TIME          : "YYYY/MM/DD h:mm",
    CHAT                : "D MMMM  HH:mm",
    MONTH               : "MMMM",
    DAY                 : "ddd",
    DAY_SHORT           : "D",
    HOUR                : "HH:mm",
    TIME                : "hh:mm:ss",
    HOUR_DATE           : "HH:mm - YYYY/M/D",
    SERVER              : "YYYY-MM-DD",
    DEFAULT_TYPE        : "YYYY/MM/DD",
    START_WEEK          : 'D MMMM',
    START_WEEK_HOUR     : 'D MMMM HH:mm',
    END_WEEK            : 'D MMMM',
}


/**
 * @description format dates
 * @param date {String} date to be formatted
 * @param type {String} set date format type
 * @return {String} formatted date
 * */
export function useDateFormatter(date,type = DATE_TYPES.DEFAULT_TYPE, locale = 'fa') {
    /**
     * @description store formatted date
     * @type {String}
     * */
    let formattedDate= "";

    /**
     * @description store date type
     * @type {String}
     * @default 0
     * */
    const formatType = DATE_TYPES[type] || type;

    if(locale === "fa")
    formattedDate = dayjs(date).calendar("jalali").locale("fa").format(formatType);
    else formattedDate =  dayjs(date).locale("en").format(formatType);

    return formattedDate
}

/**
 * @description Check if a date is the same or before a given end date (or current date).
 * @param {String|Date} date - The date to check.
 * @param {String|Date|null} endSubscriptionYear - The reference date for comparison (optional).
 * @return {Boolean} True if the date is the same or before the end date/current date.
 */
export function isDateSameOrBefore(date, endSubscriptionYear = null){
// Current date
    const currentDate = endSubscriptionYear ? endSubscriptionYear: dayjs();
    return dayjs(date).isSameOrBefore(currentDate);
}

export function isDateAfter(date1, date2 = null){
// Current date
    const currentDate = date2 ? dayjs(date2): dayjs();
    return dayjs(date1).isAfter(currentDate);
}

export function useDate(){
    /**
     * @description Get the start of the week for a given week number.
     * @param {Number} weekNumber - The week number to calculate.
     * @param {String} format - The format for the returned date (optional).
     * @return {String} The formatted start date of the week.
     */

    function getStartWeek(weekNumber,format = 'START_WEEK'){
        const formatType = DATE_TYPES[format] || format;
        const currentDayJs = dayjs().add(weekNumber, 'week');
        return currentDayJs.calendar("jalali").locale("fa").startOf('week').format(formatType);
    }

    /**
     * @description Get the end of the week for a given week number.
     * @param {Number} weekNumber - The week number to calculate.
     * @param {String} format - The format for the returned date (optional).
     * @return {String} The formatted end date of the week.
     */
    function getEndWeek(weekNumber,format = 'END_WEEK'){
        const formatType = DATE_TYPES[format] || format;
        const currentDayJs = dayjs().add(weekNumber, 'week');
        return currentDayJs.calendar("jalali").locale("fa").endOf('week').format(formatType);
    }

    /**
     * @description Get a day by week and day number.
     * @param {Number} weekNumber - The week number.
     * @param {Number} dayNumber - The day number (1-7).
     * @return {Object} An object with the day and date.
     */
    function getDayByWeekAndDayNumber(weekNumber,dayNumber) {
        dayNumber -= 1;
        let perWeek = weekNumber * 7;

        let goForward = (dayNumber - getCurrentDayNumber()) + perWeek;

        let day = dayjs().calendar('jalali').locale('fa').add(goForward, 'day').format('DD');
        let date = dayjs().calendar('jalali').locale('fa').add(goForward, 'day').format(DATE_TYPES.SERVER);

        return {
            day,
            date,
        };
    }


    /**
     * @description Get the current day number in the Jalali calendar (0 for Saturday to 6 for Friday).
     * @return {Number} The day number (0-6).
     */
    function getCurrentDayNumber() {
        const day = dayjs().calendar("jalali").locale("fa").format('dddd');
        switch (day) {
            case 'شنبه':
                return 0;
            case 'یک‌شنبه':
                return 1;
            case 'دوشنبه':
                return 2;
            case 'سه‌شنبه':
                return 3;
            case 'چهارشنبه':
                return 4;
            case 'پنج‌شنبه':
                return 5;
            case 'جمعه':
                return 6;
            default:
                return -1; // In case the day does not match any known Persian day
        }
    }

    /**
     * @description Get a date by week and day number in a specific format.
     * @param {Number} weekNumber - The week number.
     * @param {Number} dayNumber - The day number (1-7).
     * @param {String} format - The format for the returned date (optional).
     * @return {String} The formatted date.
     */
    function getDateByWeekAndDay(weekNumber, dayNumber, format = DATE_TYPES.SERVER) {
        // Subtract 1 from dayNumber to align with Day.js where weeks start on Sunday (0)
        const dayAdjustment = dayNumber - 1;
        const daysToAdd = (weekNumber - 1) * 7 + dayAdjustment;

        // Calculate the target date based on Jalali calendar
        const targetDate = dayjs().calendar('jalali').locale('fa').startOf('year').add(daysToAdd, 'day');
        return targetDate.format(format);
    }

    /**
     * @description Get the current date in the specified format.
     * @param {String} format - The format for the returned date (optional).
     * @return {String} The current date formatted.
     */
    function getCurrentDate(format = DATE_TYPES.SERVER) {
        return dayjs().calendar('jalali').locale('fa').format(format);
    }


    /**
     * Checks if a specified number of days have passed since a given date.
     *
     * @param {string|Date} specificDate - The date from which to start counting. Can be a string (ISO format, e.g., '2024-09-25T10:00:00') or a JavaScript Date object.
     * @param {number} days - The number of days to check if they have passed from the specific date.
     *
     * @returns {boolean} - Returns `true` if the specified number of days have passed from the given date, otherwise `false`.
     *
     * @example
     * // Example usage with ISO date string
     * const result = isDaysPast('2024-09-25T10:00:00', 2);
     * console.log(result); // true if more than 2 days have passed from September 25, 2024
     *
     * @example
     * // Example usage with Date object
     * const result = isDaysPast(new Date('2024-09-25'), 5);
     * console.log(result); // true if more than 5 days have passed from September 25, 2024
     */
    function isDaysPast(specificDate, days = 2) {
        if(!specificDate) return false;

        // Convert the input to a Date object if it's not already
        let inputDate = new Date(specificDate);

        // Get the current date and time
        let currentDate = new Date();

        // Calculate the number of days in milliseconds
        let daysInMilliseconds = days * 24 * 60 * 60 * 1000;

        // Add the specified number of days to the input date
        let datePlusDays = new Date(inputDate.getTime() + daysInMilliseconds);

        // Check if the current date is after the date plus the specified number of days
        return currentDate > datePlusDays;
    }

    function isDateBetween(date, startDate, endDate) {
        // Define the date format
        const format = "YYYY-MM-DD HH:mm";

        // Parse the dates with the specified format
        const parsedDate = dayjs(date, format);
        const parsedStartDate = dayjs(startDate, format);
        const parsedEndDate = dayjs(endDate, format);

        // Check if the date is between startDate and endDate (inclusive)
        return parsedDate.isSameOrAfter(parsedStartDate, "second") &&
            parsedDate.isSameOrBefore(parsedEndDate, "second");
    }

    function getCurrentDateEn(format='YYYY-MM-DD HH:mm'){
        return dayjs().format(format);
    }

    return {
        getCurrentDayNumber,
        getStartWeek,
        getEndWeek,
        getDayByWeekAndDayNumber,
        getDateByWeekAndDay,
        getCurrentDate,
        isDaysPast,
        isDateBetween,
        isDateAfter,
        getCurrentDateEn,
    }
}