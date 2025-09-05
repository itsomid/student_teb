<template>
  <div class="cl-count-down-container">
      <span id="cd-day">{{ days}}</span>
      :
      <span id="cd-hour">{{ hours}}</span>
      :
      <span id="cd-min">{{ minutes}}</span>
      :
      <span id="cd-second">{{ seconds}}</span>
      <img class="icon" src="@/assets/images/icons/timer.svg" alt="icon-timer"  />
  </div>
</template>

<script>


export default{
  name: "CountDownTimer",
  props: {
    /**
     * @description an array of Strings(Dates) to use for countdown timer
     * @type {Array}
     * */
    timesToExpire: {
      type: Array,
      required: true,
    },
  },


  data(){
    return {
      /**
       * @description store count down value
       * @type {number}
       * @default 0
       * */
      countDown: 0,

      /**
       * @description store time zone offset from UTC based on milliseconds
       * @type {number}
       * @default 0
       * */
      timeZoneOffset: new Date().getTimezoneOffset() * 60 * 1000,

      /**
       * @description store setInterval return number
       * @type {number} return value of setInterval function
       * @default -1
       * */
      timer: -1,

      /**
       * @description stores days, hours, minutes, seconds of count down
       * */
      days: 0,
      hours: 0,
      minutes: 0,
      seconds: 0,

      /**
       * @description calc the diff between current time and expire time
       * @type {number}
       * @default 0
       * */
      distance: 0,

      /**
       * @description check countdown is expired or note
       * @type {boolean}
       * @default 0
       * */
      expired: false,

      /**
       * @description keep the current expire time index
       * @type {number}
       * @default 0
       * */
      index: 0,
    }
  },
  methods: {

    /**
     * @function start countdown
     * @description set countDown value based on the first index of
     * @param timeToExpireIndex {number}
     * expire times array then start countdown timer
     * */
    startTimer(timeToExpireIndex) {
      this.expired = false;
      this.countDown =  new Date(this.timesToExpire[timeToExpireIndex]).getTime() + this.timeZoneOffset;
      this.timer = setInterval(() => {
        this.myTimer();
      }, 1000);
    },

    /**
     * @function stop countdown
     * @description stop the countdown timer and clear interval
     * fire and event to parent component
     * */
    stopTimer() {
      this.$emit("expire", false);
      this.expired = true;
      this.index ++;
      clearInterval(this.timer);
    },

    myTimer() {
      // Get today's date and time
      var now = new Date().getTime();

      // Find the distance between now and the countdown date
      this.distance = this.countDown - now;

      // If the countdown is over, write some text
      if (this.distance < 0) {
        this.stopTimer();
        if (this.index < this.timesToExpire.length) {
          this.startTimer(this.index);
        }
      }else {
        // Time calculations for minutes and seconds

        this.days = Math.floor(this.distance / (1000 * 60 * 60 * 24));
        this.hours = Math.floor(
            (this.distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
        );
        this.minutes = Math.floor(
            (this.distance % (1000 * 60 * 60)) / (1000 * 60)
        );
        this.seconds = Math.floor((this.distance % (1000 * 60)) / 1000);
        // document.getElementById("cd-second").innerHTML = this.seconds;
        // document.getElementById("cd-min").innerHTML = this.minutes;
        // document.getElementById("cd-hour").innerHTML = this.hours;
        // document.getElementById("cd-day").innerHTML = this.days;
      }
    },
  },
  created() {
    this.startTimer(this.index);
  },

}
</script>

<style scoped lang="scss">
  .cl-count-down-container {
    width: 200px;
    height: 30px;
    border-radius: 22px;
    background-color: #ffaf20;
    display: flex;
    flex-direction: row-reverse;
    justify-content: space-between;
    align-content: center;
    align-items: center;
    gap: 3px;
    color: #ffffff;
    font-family: "IranSans",sans-serif !important;
    font-size: 22px;
    font-weight: bold;
    @include media-breakpoint-down(sm){
      height: 20px;
      font-size: 16px;
    }
    .icon {
      width: 25px;
      height: 25px;
      color: #ffffff;
      margin: 0 8px 0 5px;
      @include media-breakpoint-down(sm){
        width: 15px;
        height: 15px;
      }
    }
    span:first-child {
      margin: 0 0 0 8px;
    }
  }
</style>
