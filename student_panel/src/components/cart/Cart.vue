<script setup>

import ClLoadingOverlay from "@/components/base/ClLoadingOverlay.vue";
import RepositoryFactory from "@/repository/RepositoryFactory";
import {useAlert} from "@/composable/useAlert";
import {computed, onMounted, ref} from "vue";
import CartItems from "@/components/cart/CartItems.vue";
import CartPayment from "@/components/cart/CartPayment.vue";
import {useStore} from "vuex";
import {useRouter} from "vue-router";
import CartEmpty from "@/components/cart/CartEmpty.vue";
import { useGoogleTagManager } from "@/composable/useGtm";
import {useDate} from "@/composable/useDate";

// Alert functionality
const { error,warning } = useAlert();

const loading = ref(false);

const CartRepository = RepositoryFactory.get("Cart");
const store = useStore();
const { trackBeginCheckOutEvent } = useGoogleTagManager();

/**
 * Function to fetch cart from the repository.
 * @async
 * @function
 * @returns {Promise<Object>}
 */
const getCart = async () =>{
  try {
    loading.value = true;
    const { data: { data } } = await CartRepository.getUserCart();
    if(data.price_changed) warning('قیمت یک یا چند مورد از اقلام موجود در سبد خرید شما تغییر کرده است.')
    await store.dispatch('cartStore/updateCart',data);
    trackBeginCheckOutEvent(data.items,data.invoice.final_price);
    return data;
  }catch (e) {
    error('دریافت اطلاعات از سرور با مشکل مواجه شده است.لطفا دوباره تلاش کنید.');
  }finally {
    loading.value = false;
  }
};

const items         = computed(()=> store.getters['cartStore/items']);
const invoice       = computed(()=>store.getters['cartStore/invoice']);
const installments  = computed(()=>store.getters['cartStore/installments']);

onMounted(async()=> {
  await getCart();
  await store.dispatch('userStore/updateProfile');
})
const { isDateBetween,getCurrentDateEn } = useDate();

const showYaldaOffText = computed(()=> isDateBetween(getCurrentDateEn(),'2024-12-19 18:00','2024-12-23 18:00'))
</script>

<template>
  <div class="position-relative">
    <!-- Loading indicator -->
    <ClLoadingOverlay v-if="loading" :model-value="loading" v-model="loading" :contained="true" scale="1" opacity="0.1" />
      <div v-else>
        <v-row v-if="items && items.length">
          <v-col cols="12" md="6" lg="8">
            <CartItems :items="items"/>
            <p v-if="showYaldaOffText" class="font-weight-bold text-warning text-caption mt-0 mb-6" >
              بیشترین تخفیف برات فعال شده! قبل از اتمام فرصت، خریدت را نهایی کن!
            </p>
          </v-col>
          <v-col cols="12" md="6" lg="4">
            <CartPayment :invoice="invoice" :installments="installments"/>
            <v-card rounded="xl" border flat class="mt-4">
              <v-card-title>
                <v-icon color="secondary">$mdiAlertOutline</v-icon>
                توجه
              </v-card-title>
              <v-card-text>
                شرایط و قوانین خرید:
                <br/>
                ۱. استفاده از تمامی محتوای دوره‌هایی که خریداری می‌کنید تا زمان برگزاری کنکور و برای سایر پایه‌ها تا پایان سال تحصیلی امکان‌پذیر است و بعد از آن دوره‌ها از لیست درس‌های شما حذف خواهند شد.
                <br/>
                ۲. فقط تا یک هفته بعد از خرید هر دوره امکان حذف دوره و تقاضای بازگشت وجه وجود دارد. در ضمن حذف دوره، تنها در صورتی که امکان‌پذیر است که تعداد جلساتی که از دوره مشاهده کرده‌اید بیشتر از دو جلسه (به غیر از جلسات رایگان) نباشد.
                <br/>
                ۳. از بازه زمانی خرید درس فقط تا 30 روز امکان جابجایی درس و یا استاد وجود دارد و در این بازه زمانی 30 روزه باید حداکثر چهار جلسه کلاس برگزار شده باشد و بعد از جلسه پنجم امکان جابجایی وجود ندارد.
                <br/>
                ۴. لطفا توجه کنید امکان جابجایی و یا حذف دوره‌های مشاوره وجود ندارد.
                <br/>
              </v-card-text>
            </v-card>
          </v-col>
        </v-row>
        <CartEmpty v-else />
      </div>
  </div>
</template>

<style scoped lang="scss">

</style>