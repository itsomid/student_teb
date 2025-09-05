<script setup>

import ClStepper from "@/components/app/ClStepper.vue";
import ClStepperItem from "@/components/app/ClStepperItem.vue";
import ClStepperDivider from "@/components/app/ClStepperDivider.vue";
import {PersianNumberDictionary} from "@/constants/persianNumber";
import {onMounted, ref} from "vue";
import {useUrl} from "@/composable/useUrl";

const { isDark } = useThemeManager();

import OstadinoTabs from "@/components/ostadino/OstadinoTabs.vue";
import RepositoryFactory from "@/repository/RepositoryFactory";
import {useThemeManager} from "@/composable/useThemeManager";
import {DEFAULT_IMAGE_PATH} from "@/config/filePath.config";

const { defaultImageUrlBuilder } = useUrl();

const OstadinoRepository = RepositoryFactory.get('Ostadino');
const loading = ref(true);

const steps = ref();
const getSteps = async ()=>{
  try {
    loading.value = true;
    const { data } = await OstadinoRepository.getSteps();
    steps.value = data;
    currentStep.value = steps.value.findLast((step) => step.is_active).level;
    availableStep.value = currentStep.value;
  }catch (e) {
    console.log(e)
  }finally {
    loading.value = false;
  }
}


const currentStep = ref(1);
const availableStep = ref();
onMounted(()=>{
  getSteps();
})
</script>

<template>
  <v-card :loading="loading" border flat width="100%" rounded="xl" class=" px-4">
    <v-row class="mt-16 pt-2 d-flex justify-center align-center">
      <v-col cols="12" md="6" lg="4">
        <v-img class="flex-shrink-1 flex-grow-0 mx-auto" max-width="500px" :src="isDark ? defaultImageUrlBuilder(DEFAULT_IMAGE_PATH.OSTADINO_DARK) : defaultImageUrlBuilder(DEFAULT_IMAGE_PATH.OSTADINO_LIGHT)" />
      </v-col>
      <v-col cols="12" md="6" lg="4">
       <div class="mx-sm-auto" style="max-width:468px">
         <h1 class="text-h5 text-lg-h3 text-center text-lg-right
          font-weight-bold text-primary">مسابقه استادینو</h1>
         <p class="text-secondary text-center text-lg-right mt-4 mt-lg-8 px-4 px-lg-0">
           لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان گرافیک است، چاپگرها و متون بلکه روزنامه و مجله در ستون و سطر آنچنان که لازم است، و برای شرایط فعلی تکنولوژی مورد نیاز، و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می‌باشد، کتاب‌های زیادی در شصت‌وسه درصد گذشته حال و آینده، شناخت فراوان جامعه و متخصصان را می‌طلبد
         </p>
       </div>
      </v-col>
    </v-row>
    <div v-if="!loading && steps.length">
      <v-row class="mt-16 pt-4 pt-lg-16">
        <ClStepper
            v-model="currentStep"
            @next="++currentStep"
            @prev="--currentStep"
            :length="steps.length"
            :available-step="availableStep"
        >
          <template v-for="(step,index) in steps">
            <ClStepperItem
                :title="PersianNumberDictionary[step.level]"
                :active="step.is_available && currentStep >= step.level"
                :available="step.is_available"
                :value="step">
            </ClStepperItem>
            <ClStepperDivider v-if="index < steps.length - 1" :active="currentStep > index + 1" />
          </template>
        </ClStepper>
      </v-row>
      <v-row class="mt-8 pt-0 pt-lg-12">
        <v-col cols="12">
          <OstadinoTabs :current-step="currentStep" />
        </v-col>
      </v-row>
<!--      <div class="bg-background py-16 mx-n4">-->
<!--        <h1 class="text-h5 text-lg-h3 mt-lg-9 text-center-->
<!--          font-weight-bold ">یک قدم تا ستاره شدن فاصله داری!</h1>-->
<!--          <v-col cols="12" lg="5" class="mx-auto">-->
<!--            <p class="mt-12 text-center  text-secondary text-body-1 text-lg-h5" >-->
<!--              اگه استادی و دوست داری به کادر کهکشانی اساتید کلاسینو بپیوندی کافیه ثبت نام کنی و ویدیو خودت رو برای بفرستی-->
<!--            </p>-->
<!--          </v-col>-->
<!--      </div>-->
    </div>
  </v-card>
</template>

<style scoped lang="scss">

</style>