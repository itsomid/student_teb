import { ref, onMounted, onUnmounted } from 'vue'

/**
 * CountDown composable for handling countdown functionality.
 * @returns {Object} CountDown composable methods and properties.
 */
export const useCountDown = () => {
    const countDown = ref(60);
    let intervalId;

    /**
     * Starts the countdown with the specified time.
     * @param {number} time - The initial countdown time.
     */
    function startCountDown(time) {
        countDown.value = time;
        intervalId = setInterval(() => {
            if (countDown.value > 0) countDown.value--;
            else clearInterval(intervalId)
        }, 1000);
    }

    // Cleanup function to clear the interval when the component is unmounted
    onUnmounted(() => {
        if (intervalId) {
            clearInterval(intervalId);
        }
    });

    // Return the composable methods and properties
    return {
        startCountDown,
        countDown,
    };
};

export const useCountDownDate = (timesToExpire) => {
    /**
     * @description store start date
     * @type {Ref<UnwrapRef<number>>}
     * @default 0
     * */
    const startDate = ref(0);

    /**
     * @description store count down value
     * @type {Ref<UnwrapRef<number>>}
     * @default 0
     * */
    const countDown= ref(0);

    /**
     * @description store time zone offset from UTC based on milliseconds
     * @type {Ref<UnwrapRef<number>>}
     * @default 0
     * */
    const timeZoneOffset= ref(new Date().getTimezoneOffset() * 60 * 1000)

    /**
     * @description store setInterval return number
     * @type {Ref<UnwrapRef<number>>} return value of setInterval function
     * @default -1
     * */
    const timer= ref(-1);

    /**
     * @description stores days; hours; minutes; seconds of count down
     * */
    const days= ref(0);
    const hours= ref(0);
    const minutes= ref(0);
    const seconds= ref(0);

    const progress = ref(0)

    /**
     * @description calc the diff between current time and expire time
     * @type {Ref<UnwrapRef<number>>}
     * @default 0
     * */
    const distance= ref(0);

    /**
     * @description check countdown is expired or note
     * @type {Ref<UnwrapRef<boolean>>}
     * @default 0
     * */
    const expired= ref(false);

    /**
     * @description keep the current expire time index
     * @type {Ref<UnwrapRef<number>>}
     * @default 0
     * */
    const index= ref(0);


    /**
     * @function start countdown
     * @description set countDown value based on the first index of
     * @param timeToExpireIndex {number}
     * expire times array then start countdown timer
     * */
    function startTimer(timeToExpireIndex) {
        expired.value = false;
        startDate.value = new Date(timesToExpire[timeToExpireIndex].start).getTime() + timeZoneOffset.value;
        countDown.value =  new Date(timesToExpire[timeToExpireIndex].end).getTime() + timeZoneOffset.value;

        // countDown.value = getCountDown(timesToExpire[timeToExpireIndex].end);

        timer.value = setInterval(() => {
            myTimer();
        }, 1000);
    }

    /**
     * @function stop countdown
     * @description stop the countdown timer and clear interval
     * fire an
     * event to parent component
     * */
    function stopTimer() {
        expired.value = true;
        index.value ++;
        clearInterval(timer.value);
    }

    function myTimer() {
        // Get today's date and time
        var now = new Date().getTime() + timeZoneOffset.value;

        // Find the distance between now and the countdown date
        distance.value = countDown.value - now;

        // If the countdown is over, write some text
        if (distance.value < 0) {
            stopTimer();
            if (index.value < timesToExpire.length) {
                startTimer(index.value);
            }
        }else {
            // Time calculations for minutes and seconds
            days.value = Math.floor(distance.value / (1000 * 60 * 60 * 24));
            hours.value = Math.floor(
                (distance.value % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
            );
            minutes.value = Math.floor(
                (distance.value % (1000 * 60 * 60)) / (1000 * 60)
            );
            seconds.value = Math.floor((distance.value % (1000 * 60)) / 1000);

            progress.value = 100 - (((now - startDate.value) / (countDown.value - startDate.value)) * 100);
            // progress.value = (((now - startDate.value) / (countDown.value - startDate.value)) * 100);

        }
    }

    /**
     * @function get countdown based on local time
     * @description get local countdown time
     * @param expireTime {string}
     * expire time that start countdown timer
     * */
    function getCountDown(expireTime){
        let timeSplit = expireTime.split(" ");
        let expireDate = new Date(timeSplit[0]);
        let expireFaTime = timeSplit[1].split(":")
        return   expireTime + timeZoneOffset.value;
    }

    onMounted(() => startTimer(index.value))
    onUnmounted(() => stopTimer())

    // expose managed state as return value
    return { days,hours,minutes,seconds, progress, distance }
}
