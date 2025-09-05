<script setup>
import {computed, onMounted, ref, watch} from "vue";
import { useAlert } from "@/composable/useAlert";
import { LESSONS, SCORES } from "@/constants/millionScoreCampaign";
import { useStore } from "vuex";
import useVuelidate from "@vuelidate/core";
import { helpers } from "@vuelidate/validators";
import { required } from '@/composable/useValidator';
import {useUtils} from "@/composable/useUtils";
import ClModal from "@/components/app/ClModal.vue";
import {useUrl} from "@/composable/useUrl";
const loading = ref(false);
const { success, error } = useAlert();
const store = useStore();
const { defaultImageUrlBuilder } = useUrl();
const { convertArabicToEnglish, convertPersianToEnglish } = useUtils();
const state = ref({
  avg_score: null,
});

const confirm = ref(false);
// Custom validation rule for numbers with only one floating point
const singleFloatingPoint = helpers.withMessage(
    "معدل شما فقط می تواند یک عدد اعشار داشته باشد که با . جدا شود ۱۹.۲",
    (value) => {
      value = convertArabicToEnglish(value);
      value = convertPersianToEnglish(value);
      if (value === null || value === undefined || value === "") return true; // Allow empty values
      const regex = /^([0-9]|1[0-9]|20)(\.[0-9])?$/; // Matches numbers 0-20.0
      return regex.test(value); // Ensure it's numerically <= 20.0
    }
);

const smallerThan = helpers.withMessage(
    "معدل باید کوچکتر یا مساوی ۲۰ باشد",
    (value ) => {
      value = convertArabicToEnglish(value);
      value = convertPersianToEnglish(value);
      return parseFloat(value) <= 20.0
    }
)
// Set up validation rules
const rules = {
  avg_score: { required, singleFloatingPoint, smallerThan },
};

const v$ = useVuelidate(rules, state);

const submit = async () => {
  try {
    loading.value = true;
    state.value.avg_score = convertArabicToEnglish(state.value.avg_score);
    state.value.avg_score = convertPersianToEnglish(state.value.avg_score);

    await store.dispatch("campaign/updateStudentReport", state.value);
    success("به روز رسانی اطلاعات با موفقیت انجام شد.");
    confirm.value = false;
  } catch (e) {
    console.error(e);
    error(e?.error?.message);
  } finally {
    loading.value = false;
  }
};

onMounted(async () => {
  await store.dispatch("campaign/getStudentReport");
});

watch(
    () => store.getters["campaign/report"],
    (value) => {
      if (value) state.value = value;
    },
    {immediate: true}
);

const hasReport = computed(() => !!store.getters["campaign/hasReport"]);
</script>

<template>
  <v-card v-if="hasReport" disabled flat border rounded="xl">
    <v-card-title class="text-body-1 font-weight-bold mt-5 px-7">
      <v-icon size="20" icon="cli:Gift:type:bold"></v-icon>
      حدس‌های من در مسابقه نمره صد میلیونی
    </v-card-title>
    <v-card-title class="text-body-1 font-weight-bold px-8 my-8">
      معدل حدسی من:
    </v-card-title>

    <v-card-text class="pt-4 px-4">
      <template v-for="(value, key) in state" :key="key">
        <v-col cols="12" class="no-gutters py-0">
          <div v-if="key === 'avg_score'" class="mb-6">
            <v-text-field
                name="avg_score"
                @blur="v$.avg_score.$touch()"
                @input="v$.avg_score.$touch()"
                :error-messages="v$.avg_score.$errors.map((e) => e.$message)"
                v-model="state[key]"
                :label="LESSONS[key]"
                variant="outlined"
                rounded="xl"
            />
            <v-card-title class="text-body-1 font-weight-bold my-8">
              نمره‌های حدسی من برای درس‌های:
            </v-card-title>
          </div>
          <v-select
              v-else-if="!!value"
              v-model="state[key]"
              :label="LESSONS[key]"
              :items="SCORES"
              variant="outlined"
              rounded="xl"
          />
        </v-col>
      </template>
    </v-card-text>

    <v-card-actions class="px-8 pb-4">
      <v-btn
          @click="submit"
          :loading="loading"
          :disabled="loading"
          @keydown.enter="confirm = true"
          color="primary"
          variant="elevated"
          size="x-large"
          rounded="xl"
          block
          type="submit"
      >
        ثبت تغییرات
      </v-btn>
    </v-card-actions>
    <div class="text-caption font-weight-bold text-secondary px-10 py-4">
      <v-icon>$mdiInformationOutline</v-icon>
      تا 15 دی می تونی حدس هایی که زدی رو تغییر بدی!
    </div>

    <ClModal v-model="confirm">
      <v-card-text class="pa-6">
        <v-img :src="defaultImageUrlBuilder('assets/images/hadsino/confirm.png')" max-width="218" class="mx-auto"/>
        <h1 class="text-h5 font-weight-bold text-center my-8">از ثبت تغییرات مطمئنی؟</h1>
        <p class="text-center text-secondary mb-8">
          فقط یک‌بار می‌تونی نمره‌های واقعیت رو برای شرکت در مسابقه وارد کنی. اگه می‌خوای برگرد یه دور دیگه چک کن و این
          صحبت‌ها.
        </p>
      </v-card-text>
      <v-card-actions class="d-flex flex-row ga-2 px-10 pb-6">
        <v-btn @click="confirm = false" :disabled="loading" size="large" color="primary" variant="outlined"
               border="sm primary opacity-100" rounded="lg" class="flex-grow-1">
          بازگشت
        </v-btn>
        <v-btn @click="submit" :disabled="loading" :loading="loading" size="large" variant="flat" color="primary"
               rounded="lg" class="flex-grow-1">
          ثبت تغییرات
        </v-btn>
      </v-card-actions>
    </ClModal>
  </v-card>
</template>

<style scoped lang="scss">
</style>
