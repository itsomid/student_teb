<script setup>
import {DEFAULT_IMAGE_PATH} from "@/config/filePath.config";
import ClImage from "@/components/base/ClImage.vue";
import StoreProductBtn from "@/components/store/StoreProductBtn.vue";
import {useUrl} from "@/composable/useUrl";
import {defineEmits} from "vue";
import {useThemeManager} from "@/composable/useThemeManager";
import {PRODUCT_TYPE} from "@/constants/product";
import ClPlyrPlayerWithoutHls from "@/components/players/ClPlyrPlayerWithoutHls.vue";
const emits = defineEmits(['addedToCart'])
const props = defineProps({
  data: {
    type: Object,
    required: false,
  },
});

const  daysOfWeek =  {
  0: '',
  1: 'شنبه',
  2: 'یک‌شنبه',
  3: 'دوشنبه',
  4: 'سه‌شنبه',
  5: 'چهارشنبه',
  6: 'پنج‌شنبه',
  7: 'جمعه',
};

const { defaultImageUrlBuilder,introduceVideoUrlBuilder } = useUrl();

const numberConvertor = (number)=> {
  return Intl.NumberFormat('en').format(number)
}

const emitUpdateProductStatusToParent = (value) => {
  emits('addedToCart',value)
}

const { isDark } = useThemeManager();
</script>

<template>
  <div v-if="data.name" class="position-sticky" style="top:100px">
    <v-card rounded="xl"   class="d-flex flex-column pa-3 pa-md-6 pa-lg-6 pa-xl-6">
      <ClPlyrPlayerWithoutHls  v-if="$vuetify.display.smAndDown && data.video_source" :vod-link="introduceVideoUrlBuilder(data.video_source)" />
      <ClImage
          v-else
          path="PRODUCT"
          :default-image="DEFAULT_IMAGE_PATH.PRODUCTS"
          :alt="data.name"
          :image="data.secondary_image ? data.secondary_image : data.img_filename"
          :aspect-ratio="1.77"
          style="border-radius: 16px!important;"
      />
      <v-card-text class="px-0 text-secondary">
        <v-list-item class="px-0">
          <template #prepend>
          <span :class="{'text-secondary-darken-4' : !isDark}"  class="text-secondary-lighten-3 text-subtitle-1">
            روزهای برگزاری:
          </span>
          </template>
          <template #append>
            <div v-if="data.product_type_id === PRODUCT_TYPE.PRODUCT_CUSTOM_PACKAGE || !data.holding_days" class="font-weight-bold">
              <v-icon>$mdiMinus</v-icon>
            </div>
            <div v-else :class="{'text-secondary-darken-5' : !isDark}" class="font-weight-bold text-secondary-lighten-3 text-subtitle-1">
              {{ daysOfWeek[+data.holding_days] }}
              <span v-if="data.holding_days2 && data.options.holding_days2 != 0">
              {{ ` ,` + daysOfWeek[+data?.holding_days2] }}
            </span>
              <span v-if="data.holding_days3 && data.options.holding_days3 != 0" >
              {{ ` ,` + daysOfWeek[+data?.holding_days3] }}
            </span>
            </div>
          </template>
        </v-list-item>
        <v-list-item class="px-0">
          <template #prepend>
          <span :class="{'text-secondary-darken-4' : !isDark}" class="text-secondary-lighten-3 text-subtitle-1">
            ساعات برگزاری:
          </span>
          </template>
          <template #append>
            <div v-if="data.product_type_id === PRODUCT_TYPE.PRODUCT_CUSTOM_PACKAGE || !data.start_time">
              <v-icon>$mdiMinus</v-icon>
            </div>
            <div v-else :class="{'text-secondary-darken-5' : !isDark}" class="font-weight-bold text-secondary-lighten-3 text-subtitle-1">
            <span>
               {{ data.start_time }} تا {{ data.finish_time }}
            </span>
              <span v-if="+data.holding_days2">
              {{ ` ,` + data.options.holding_hours2[0] }}
              تا {{ data.options.holding_hours2[1] }}
            </span>
              <span v-if="+data.holding_days3" >
               {{ ` ,` + data.options.holding_hours3[0] }}
              تا {{ data.options.holding_hours3[1] }}
            </span>
            </div>
          </template>
        </v-list-item>
        <v-list-item class="px-0">
          <template #prepend>
          <span :class="{'text-secondary-darken-4' : !isDark}" class="text-secondary-lighten-3 text-subtitle-1">
            تاریخ شروع:
          </span>
          </template>
          <template #append>
          <span  >
            <span v-if="data.start_date" :class="{'text-secondary-darken-5' : !isDark}" class="font-weight-bold text-secondary-lighten-3 text-subtitle-1">{{ data.start_date }}</span>
            <span v-else class="text-secondary">
               <v-icon>$mdiMinus</v-icon>
            </span>
          </span>
          </template>
        </v-list-item>
        <v-list-item class="px-0">
          <template #prepend>
          <span :class="{'text-secondary-darken-4' : !isDark}" class="text-secondary-lighten-3 text-subtitle-1">
            قیمت:
          </span>
          </template>
          <template #append>
          <span  :class="{'text-secondary-darken-5' : !isDark}" class="font-weight-bold text-secondary-lighten-3 text-subtitle-1">
            <div v-if="data.full_price_show">
              <span class=" text-error mr-2 text-decoration-line-through text-body-2">
                  {{ data.off_price ? numberConvertor(data.original_price) : numberConvertor(data.full_price_show) }}
                </span>
                <span class="text-secondary mr-1 ml-2">
                  ریال
                </span>
                <span class="text-success text-body-2">
                {{ numberConvertor(data.price) }}
                </span>
              <span class="text-secondary mr-1">
                  ریال
                </span>
            </div>
            <div v-else>
              {{ data.price === 0 ? 'رایگان' : numberConvertor(data.price) }}
              <span v-if="data.price !== 0" class="text-secondary mr-1">
                ریال
              </span>
            </div>
          </span>
          </template>
        </v-list-item>
        <div v-if="data.is_plan_z_product && $vuetify.display.mobile">
          <v-chip class="mt-4 font-weight-medium px-0" variant="text" color="#00874E">️‍🔥 این دوره توی پکیج پلن زد با تخفیف بیش‌تر موجوده!</v-chip>
          <v-btn color="#00874E" variant="plain" to="/newpanel/store?course=538,541,544" class="text-decoration-underline px-0  opacity-100">مشاهده جزيیات</v-btn>
        </div>
        <div v-if="data.has_installment" class="module-border-wrap rounded-lg mt-4">
          <div class="module rounded-lg bg-white d-flex flex-row flex-wrap justify-space-between" style="gap: 8px">
            <v-img max-width="20" width="5" class="ml-1 flex-shrink-1"  :src="defaultImageUrlBuilder('assets/images/icons/star.svg')" />
            <div class="flex-grow-1 span-fixer">
              امکان پرداخت در {{ data.installment_count }} قسط
            </div>
            <div class="flex-shrink-1">
             پیش‌پرداخت
              <span class="font-color text-body-1 font-weight-bold">
               {{ numberConvertor(data.first_installment) }}
            </span>
              <span class="text-caption">
              ریال
            </span>
            </div>
          </div>
        </div>
        <div v-if="data.is_plan_z_product && !$vuetify.display.mobile" class="mt-4">
          <v-chip class="font-weight-medium px-0" variant="text" color="#00874E">️‍🔥 این دوره توی پکیج پلن زد با تخفیف بیش‌تر موجوده!</v-chip>
          <v-btn color="#00874E" variant="plain" to="/newpanel/store?course=538,541,544" class="text-decoration-underline pl-0 pr-1 opacity-100">مشاهده جزيیات</v-btn>
        </div>
      </v-card-text>
      <v-card-actions  v-if="$vuetify.display.mdAndUp" class="pa-0 align-self-start w-100">
        <StoreProductBtn
            :product_id="data.id"
            :is_new_panel="data.name.includes('1405')"
            :course_id="data.course_id"
            :status="data.status"
            :product_type="data.product_type_id"
            @addedToCart="emitUpdateProductStatusToParent"
        />
      </v-card-actions>
    </v-card>
  </div>
</template>

<style lang="scss">

</style>
