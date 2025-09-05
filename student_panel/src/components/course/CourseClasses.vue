<script setup>
import { useDateFormatter } from "@/composable/useDate";
import {PRODUCT_STATUS} from "@/constants/product";
import {ClassNumberDictionary} from "@/constants/classNumberDictionary";
const props = defineProps(['classes', 'loading'])
const classHeaders = [
  {
    title: "وضعیت",
    key: "state",
    sortable: false,
    align: 'start',
  },
  {
    title: "عنوان جلسه",
    key: "name",
    sortable: false,
    align: 'start',
  },
  {
    title: "تاریخ برگزاری",
    key: "holding_date",
    sortable: false,
    align: 'start',
  },
  {
    title: "مشاهده",
    key: "actions",
    sortable: false,
    align: 'start',
  },
]
</script>

<template>
 <div>
   <v-hover v-if="$vuetify.display.lgAndUp">
     <template v-slot:default="{ isHovering,props }">
       <v-card rounded class="rounded-xl" v-bind="props" :elevation="isHovering ? 8 : 3" >
         <v-data-table
             :items="classes"
             :headers="classHeaders"
             hover=""
             hide-default-footer
             :items-per-page="-1"
             :loading="loading"
         >
           <template #top>
             <h2 class="font-weight-bold text-subtitle-1 rounded-xl rounded-b border-b pa-4 " >جلسه‌ها</h2>
           </template>
           <template v-slot:bottom></template>
           <template #no-data>
جلسه‌ای برای شما وجود ندارد
           </template>
           <template #item.state>
             <i class="icon-CL_lock-keyhole-open text-primary text-h6 "></i>
           </template>
           <template #item.holding_date="{item}">
             {{ useDateFormatter(item.holding_date, "LONG") }}
           </template>
           <template #item.actions="{item}">
             <v-btn rounded variant="text" color="primary" :to="{ name: 'show-class', params: { id: item.class_id } }"
                    class="rounded-xl">
               نمایش جلسه
               <v-icon>$mdiChevronLeft</v-icon>
             </v-btn>
           </template>
         </v-data-table>
       </v-card>
     </template>
   </v-hover>
   <div v-else>
     <template v-for="(item,index) in classes">
       <div class="d-flex flex-column text-secondary pa-4">
         <div class="d-flex flex-row justify-space-between align-center mt-2">
           <span class="flex-shrink-1 ml-3 font-weight-bold">{{ ClassNumberDictionary[index] }}</span>
           <span class="">
              <v-chip size="small" prepend-icon="$mdiClockOutline" label rounded="lg" class="d-flex flex-grow-1 justify-center" variant="tonal">
                {{ useDateFormatter(item.holding_date, "LONG") }}
              </v-chip>
            </span>
         </div>
         <div class="mt-3 font">
           {{ item.name}}
         </div>
         <div class="mt-3">
           <v-btn block rounded variant="outlined" color="primary" :to="{ name: 'show-class', params: { id: item.class_id } }"
                  class="rounded-lg">
             ورود به جلسه
             <v-icon>$mdiPlayOutline</v-icon>
           </v-btn>
         </div>
       </div>
       <v-divider color="secondary-darken-5" class="mt-4" />
     </template>
   </div>
 </div>
</template>

<style scoped lang="scss">

</style>