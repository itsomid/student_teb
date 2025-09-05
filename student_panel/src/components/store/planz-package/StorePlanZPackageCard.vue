<script setup>
import {DEFAULT_IMAGE_PATH} from "@/config/filePath.config";
import ClImage from "@/components/base/ClImage.vue";
import {useUrl} from "@/composable/useUrl";
import {computed, ref} from "vue";
import {useCart} from "@/composable/useCart";
import {useRoute, useRouter} from "vue-router";
import {useAlert} from "@/composable/useAlert";
import {useNavigator} from "@/composable/useNavigator";
import {useDateFormatter} from "@/composable/useDate";
const emits = defineEmits(['addedToCart']);
const props = defineProps({
  data: {
    type: Object,
    required: false,
  },
  selected: {
    type: Object,
    default: ()=> {}
  },
  isInCart: {
    type: Boolean,
    default: false
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

const { error } = useAlert();
const { defaultImageUrlBuilder } = useUrl();

const route               = useRoute();
const { navigateToCart }  = useNavigator();
const product_id          = computed(()=> route.params.id);
const loading             = ref(false);
const numberConvertor = (number)=> {
  return Intl.NumberFormat('en').format(number)
}


const { addPlanZPackageToCart } = useCart({emits})
const submit = async ()=>{
  const section_teacher = [];
  if(!isValid) {
    error('شما باید در هر بخش یک درس را انتخاب کنید');
    return;
  }
  for(const key in props.selected){
    section_teacher.push({
      section_id: +key,
      teacher_id: +props.selected[key],
    })
  }
  try {
    loading.value = true;
    await addPlanZPackageToCart({
      product_id: +product_id.value,
      section_teacher: section_teacher,
    })
    await navigateToCart();
  }catch (e) {
    console.log(error);
  }finally {
    loading.value = false;
  }
}

const isValid = computed(()=> props.data && props.data?.sections.length === Object.keys(props.selected).length)
</script>

<template>
  <div v-if="data.product_name" class="position-sticky" style="top:100px">
    <v-card rounded="xl"   class="d-flex flex-column pa-3 pa-md-6 pa-lg-6 pa-xl-6">
      <ClImage
          path="PRODUCT"
          :default-image="DEFAULT_IMAGE_PATH.PRODUCTS"
          :alt="data.product_name"
          :image="data.secondary_image ? data.secondary_image : data.img_filename"
          :aspect-ratio="1.77"
          style="border-radius: 16px!important;"
      />
      <v-card-text class="px-0">
        <v-list-item class="px-0">
          <template #prepend>
          <span class="text-secondary text-subtitle-1">
            روزهای برگزاری:
          </span>
          </template>
          <template #append>
            <div class="font-weight-bold  text-subtitle-1">
              <v-icon>$mdiMinus</v-icon>
            </div>
          </template>
        </v-list-item>
        <v-list-item class="px-0">
          <template #prepend>
          <span class="text-secondary text-subtitle-1">
            ساعات برگزاری:
          </span>
          </template>
          <template #append>
            <div class="font-weight-bold   text-subtitle-1">
              <v-icon>$mdiMinus</v-icon>
            </div>
          </template>
        </v-list-item>
        <v-list-item class="px-0">
          <template #prepend>
          <span class="text-secondary text-subtitle-1">
            تاریخ شروع:
          </span>
          </template>
          <template #append>
          <span class="font-weight-bold  text-subtitle-1">
            <div v-if="data.holding_date">
               {{ useDateFormatter(data.holding_date, 'START_WEEK') }}
            </div>
            <v-icon v-else>$mdiMinus</v-icon>
          </span>
          </template>
        </v-list-item>
        <v-list-item class="px-0">
          <template #prepend>
          <span class="text-secondary text-subtitle-1">
            قیمت:
          </span>
          </template>
          <template #append>
          <span class="font-weight-bold  text-subtitle-1">
            <div v-if="data.full_price_show">
              <span class=" text-error mr-2 text-decoration-line-through text-body-2 ">
                  {{ data.off_price ? numberConvertor(data.original_price) : numberConvertor(data.full_price_show) }}
                </span>
                <span class="text-secondary mr-1 ml-2">
                  ریال
                </span>
                <span class="text-success text-body-2">
                {{ numberConvertor(data.price) }}
                </span>
            </div>
            <div v-else>
              {{ data.price === 0 ? 'رایگان' : numberConvertor(data.price) }}
              <span v-if="data.price !== 0" class="text-secondary mr-1 ml-2">
                ریال
              </span>
            </div>
          </span>
          </template>
        </v-list-item>
        <div v-if="data.has_installment" class="module-border-wrap rounded-lg mt-4">
          <div class="module rounded-lg bg-white d-flex flex-row flex-wrap justify-space-between" style="gap: 8px">
            <v-img max-width="20" width="5" class="ml-1 flex-shrink-1"  :src="defaultImageUrlBuilder('assets/images/icons/star.svg')" />
            <div class="flex-grow-1 span-fixer">
              امکان پرداخت در {{ data.installment_count }} قسط
            </div>
            <div class="flex-shrink-1">
              پیش‌پرداخت
              <span class="font-color">
               {{ numberConvertor(data.first_installment) }}
            </span>
              <span class="text-caption">
              ریال
            </span>
            </div>
          </div>
        </div>
      </v-card-text>
      <v-card-actions  v-if="$vuetify.display.mdAndUp" class="pa-0 align-self-start w-100">
        <v-btn
            class="ma-0 pa-0"
            color="primary"
            block
            variant="elevated"
            rounded="lg"
            size="large"
            :disabled="!isValid"
            :loading="loading"
            @click.prevent="submit"
        >
          <v-icon class="rounded-lg mx-3 btn-store-class"  >
            $mdiCartPlus
          </v-icon>
          <span v-if="isInCart">
              ویرایش پکیج
          </span>
          <span v-else>
                      افزودن به سبد خرید
          </span>
        </v-btn>
      </v-card-actions>

      <v-card-subtitle v-if="!isValid" class="mt-3 text-body-2 text-center text-wrap text-warning font-weight-bold">
        برای افزودن به سبد خرید، اول استاد هر درس رو انتخاب کن.
      </v-card-subtitle>
    </v-card>
  </div>
</template>

<style scoped lang="scss">

</style>