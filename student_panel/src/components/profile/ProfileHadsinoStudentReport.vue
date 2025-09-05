<script setup>
import {computed, inject, onMounted, ref, watch} from "vue";
import { useAlert } from "@/composable/useAlert";
import { LESSONS, SCORES } from "@/constants/millionScoreCampaign";
import { useStore } from "vuex";
import useVuelidate from "@vuelidate/core";
import { helpers } from "@vuelidate/validators";
import { required } from '@/composable/useValidator';
import {useUtils} from "@/composable/useUtils";
import ClModal from "@/components/app/ClModal.vue";
import {useUrl} from "@/composable/useUrl";
import vueFilePond from 'vue-filepond';
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import FilePondPluginImageResize from 'filepond-plugin-image-resize';
import FilePondPluginImageTransform from 'filepond-plugin-image-transform';

const loading = ref(false);
const { success, error,info } = useAlert();
const store = useStore();
const { defaultImageUrlBuilder } = useUrl();
const { convertArabicToEnglish, convertPersianToEnglish } = useUtils();
const state = ref({
  avg_score: null,
});

const confirm = ref(false);
const isDisabled = ref(true)
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
let rules = {
  avg_score: { required, singleFloatingPoint, smallerThan },
};

let v$ = useVuelidate(rules, state);

const submit = async () => {
  try {
    let isValid = await v$.value.$validate();
    if (!isValid) return;
    loading.value = true;
    const imageKeys = [];
    state.value.avg_score = convertArabicToEnglish(state.value.avg_score);
    state.value.avg_score = convertPersianToEnglish(state.value.avg_score);
    pond.value.getFiles().forEach((file) => {
      console.log(file, '----------')
      imageKeys.push(file.serverId);
    });
    // if(imageKeys.length) info("کارنامه در حال بارگزاری میباشد...");
    await store.dispatch("campaign/submitStudentFinalReport", {
      transcript_file: imageKeys[0],
      ...state.value
    });
    success("اطلاعات کارنامه شما با موفقیت ارسال شد.");
    confirm.value = false;
    await store.dispatch("campaign/getStudentRealReport")
  } catch (e) {
    console.error(e);
    error(e?.error?.message);
  } finally {
    loading.value = false;
  }
};

/*
* Filepond configs
* */
const pond = ref()
const $storeFourUploadBaseUrl = inject('$storeFourUploadBaseUrl');
const FilePond = vueFilePond(
    FilePondPluginFileValidateType,
    FilePondPluginImageResize,
    FilePondPluginImagePreview,
    FilePondPluginImageTransform
);
const fileTypes = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'];
const filepondServerConfig = {
  process: {
    url: $storeFourUploadBaseUrl + '/api/upload/hadsino',
    method: 'POST',
    onload: (response) => {
      response = JSON.parse(response);
      // return response.key;
      return response[0].key;
    },
    onerror: (response) => {
      console.log(response)
      response = JSON.parse(response);
      return response.msg
    },
    ondata: (formData) => {
      window.h = formData;
      return formData;
    }
  },
}

const onProcessFile = ()=> {
  isDisabled.value = false;
}

const onRemoveFile = ()=> {
  if(!pond.value.getFiles().length)
    isDisabled.value = true;
}


const openConfirm = async ()=> {
  let isValid = await v$.value.$validate();
  if (!isValid) return;

  const imageKeys = [];
  pond.value.getFiles().forEach((file) => {
    console.log(file, '----------')
    imageKeys.push(file.serverId);
  });
  if (imageKeys.length === 0) {
    error('هنوز کارنامت رو آپلود نکردی!');
    return
  }

  confirm.value = true;
}

onMounted(()=>  store.dispatch("campaign/getStudentRealReport"))
watch(
    () => store.getters["campaign/report"],
    (value) => {
      if (value) {
        Object.keys(value).forEach((key) => {
          if (!!value[key]) state.value[key] = store.getters["campaign/real_report"] ? store.getters["campaign/real_report"][`real_${key}`] : null;
          if (!!value[key] && key !== 'avg_score') rules[key] = {required}
        })
        v$ = useVuelidate(rules, state);
      }
    },
    {immediate: true}
);

const hasReport = computed(() => !!store.getters["campaign/hasReport"]);
</script>

<template>
<!--  <v-card v-if="hasReport" :disabled="store.getters['campaign/hasRealReport']" flat border rounded="xl">-->
  <v-card v-if="hasReport" disabled flat border rounded="xl">
    <v-card-title class="text-body-1 font-weight-bold mt-5 px-7">
      <v-icon size="20" icon="cli:Gift:type:bold"></v-icon>
      نمره‌های واقعی من در نیم‌ترم اول مدرسه!
    </v-card-title>
    <v-card-title class="text-body-1 font-weight-bold px-8 my-8">
      معدل واقعی من:
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
              نمره‌های واقعی من برای درس‌های:
            </v-card-title>
          </div>
          <v-select
              v-else
              v-model="state[key]"
              :label="LESSONS[key]"
              :items="SCORES"
              @blur="v$[key].$touch()"
              @input="v$[key].$touch()"
              :error-messages="v$[key].$errors.map((e) => e.$message)"
              variant="outlined"
              rounded="xl"
          />
        </v-col>
      </template>
      <div class=" px-4">
        <FilePond
            name="filepond[]"
            ref="pond"
            label-idle='جهت درج تصویر <span class="filepond--label-action">اینجا</span> کلیک کنید'
            v-bind:allow-multiple="false"
            :accepted-file-types="fileTypes"
            :required="true"
            :server="filepondServerConfig"
            @processfiles="onProcessFile"
            @removefile="onRemoveFile"
            credits=""
        />
      </div>
    </v-card-text>

    <v-card-actions class="px-8 pb-4">
      <v-btn
          @click="openConfirm"
          :loading="loading"
          :disabled="loading || v$.$invalid"
          @keydown.enter="openConfirm"
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

    <ClModal v-model="confirm">
      <v-card-text class="pa-6">
        <v-img :src="defaultImageUrlBuilder('assets/images/hadsino/confirm.png')" max-width="218" class="mx-auto"/>
        <h1 class="text-h5 font-weight-bold text-center my-8">از ثبت تغییرات مطمئنی؟</h1>
        <p class="text-center text-secondary mb-8">
          بعد از انتخاب ثبت تغییرات دیگه ‌نمی‌تونی نمره‌هایی که وارد کردی رو ویرایش کنی، پس اگه می‌خوای دوباره نمره‌هاتو
          چک کن!
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
