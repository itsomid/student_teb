<script setup>
import {onMounted, ref} from "vue";
  import RepositoryFactory from "@/repository/RepositoryFactory";
  import moment from 'moment-jalaali'
  const loading = ref(true);
  const BulletinBoardRepository = RepositoryFactory.get("BulletinBoard");
  const classesInWeek = ref([]);
  const maxRows = ref(0);
  const today = ref(0);
  const weekNumber = ref(0);
  const startWeek = ref(0);
  const endWeek = ref(0);
  const daysOfWeek =  {
        0:'شنبه' ,
        1:'یک‌شنبه' ,
        2:'دوشنبه' ,
        3:'سه‌شنبه' ,
        4:'چهارشنبه',
        5:'پنج‌شنبه',
        6:'جمعه' ,
  };

  const classDateConvertor = (timeStamp) => {
    moment.loadPersian({usePersianDigits: true});
    const time = moment(timeStamp);
    return time.format("ساعت HH:mm");
  };

  const findStartWeekAndEndWeek = ()=>{
    moment.loadPersian({usePersianDigits: true});
    startWeek.value = moment().add(weekNumber.value,'week').startOf('week').format('jD jMMMM');
    endWeek.value = moment().add(weekNumber.value,'week').endOf('week').format('jD jMMMM jYYYY');
  };

  const ifClassExist = (index, maxRow) =>{
    return classesInWeek.value[index] !== undefined &&  classesInWeek.value[index][maxRow] !== undefined
  };

  async function getDataFromWeek(){
    try {
      loading.value = true;
      const { data: { data } } = await BulletinBoardRepository.getUserClassesWithinWeek( {
          'week': weekNumber.value
        });
      classesInWeek.value = data
      findMaxRow(classesInWeek.value);
      findStartWeekAndEndWeek()
    }catch (e) {

    }finally {
      loading.value = false;
    }
  }

  const findMaxRow = (classInWeek) => {
    maxRows.value = 0
    for (const value of Object.values(classInWeek)) {
      if (value.length > maxRows.value) {
        maxRows.value = value.length;
      }
    }
    return maxRows.value;
  }

  const changeWeekNumber = (weekStatus) =>{
    if (weekStatus === 'nextWeek'){
      weekNumber.value += 1
      getDataFromWeek()
    } else if (weekStatus === 'lastWeek') {
      weekNumber.value -= 1
      getDataFromWeek()
    }
  }

  const getDaysOfTheWeek = (day_number) =>{
    day_number -= 1;
    let perweek = weekNumber.value * 7;

    let goForward = (day_number - getCurrentDayNumber()) + perweek;

    let date = moment().locale('en').add(goForward, 'day').format('jYYYY/jM/jD');
    return date;
  }

  const getCurrentDayNumber = ()=> {
    moment.loadPersian({dialect: 'persian-modern'})
    let day = moment().format('dddd')
    if (day === 'شنبه') return 0;
    if (day === 'یک‌شنبه') return 1;
    if (day === 'دوشنبه') return 2;
    if (day === 'سه‌شنبه') return 3;
    if (day === 'چهارشنبه') return 4;
    if (day === 'پنج‌شنبه') return 5;
    if (day === 'جمعه') return 6;
  }

  const checkActiveToday = (day_number)=>{
    return getDaysOfTheWeek(day_number) === moment().locale('en').format('jYYYY/jM/jD')
        ? 'bg-table-active'
        : 'inActive' ;
  }

  onMounted(()=> {
    getDataFromWeek()
  })
</script>

<template>
  <v-hover>
    <template v-slot:default="{ isHovering,props }">
      <v-card v-bind="props" :elevation="isHovering ? 8 : 1" height="100%"  rounded class="rounded-xl" :loading="loading" >
        <template v-slot:loader="{ isActive }">
          <v-progress-linear
              :active="isActive"
              color="primary"
              height="4"
              indeterminate
          ></v-progress-linear>
        </template>
        <v-toolbar>
          <v-btn variant="text" rounded @click="changeWeekNumber('lastWeek')">
            <i class="icon-CL_angle-right ml-1"></i>
            هفته قبل
          </v-btn>
          <v-spacer />
          <div>
            <span class="font-weight-bold">برنامه هفتگی</span>
            <span class="font-weight-normal">(از تاریخ {{ startWeek }} تا {{ endWeek }})</span>
          </div>
          <v-spacer />
          <v-btn variant="text" rounded @click="changeWeekNumber('nextWeek')">
            هفته بعد
            <i class="icon-CL_angle-left mr-1"></i>
          </v-btn>
        </v-toolbar>
        <v-card-text class="pa-0">
            <v-table fixed-header hover="" class="table" density="comfortable">
              <thead>
                <tr>
                <th scope="col"></th>
                <th scope="col" class="text-center pa-3" v-for="(day, index) in daysOfWeek"  :key="day.index" :class="checkActiveToday(++index)">
                 <div class="d-flex flex-column">
                    <span class="">
                    {{ day }}
                  </span>
                   <span class="mt-2">
                          {{getDaysOfTheWeek(index)}}
                  </span>
                 </div>
                </th>
              </tr>
              </thead>
              <tbody  ref="weeklySchedule">
                <tr class="active text-center" v-for="maxRow in maxRows" :key="maxRow">
                  <td class="">
                    زنگ {{maxRow}}
                  </td>
                  <td v-for="(value, index) in 7" :key="index" style="max-width: 200px!important;" :class="checkActiveToday(value)">
                    <router-link :to="{name:'show-class',params:{id:classesInWeek[index][maxRow-1].class_id}}" v-if="ifClassExist(index, maxRow-1)">
                      <p class="my-3">
                        {{classesInWeek[index][maxRow-1].course_data.data.name}}
                      </p>
                      <span class="text-primary my-3 font-weight-bold">{{classesInWeek[index][maxRow-1].name}}</span>
                      <span v-if="classesInWeek[index][maxRow-1].class_status === 8"
                            class="text-error d-block">
                        (به تعویق افتاده)
                      </span>
                      <p class="text-body-2 my-3 text-lg-body-1">
                        {{ classDateConvertor(classesInWeek[index][maxRow-1].holding_date) }}
                      </p>
                    </router-link>
                  </td>
                </tr>
              </tbody>
            </v-table>
        </v-card-text>
      </v-card>
    </template>
  </v-hover>
</template>

<style scoped lang="scss">
.bg-active{
  background: #BEFFDD!important;
}

</style>