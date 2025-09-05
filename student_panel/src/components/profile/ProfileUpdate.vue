<script setup>
/**
 * Vue 3 component script setup for handling login with password functionality.
 * @module LoginWithPassword
 */

import { SCHEMA } from '@/schema/profile/profile.schema';
import RepositoryFactory from "@/repository/RepositoryFactory";
import {computed, inject, onMounted, reactive, ref, watch} from 'vue';
import useVuelidate from '@vuelidate/core';
import FormGenerator from '../../components/base/form/FormGenerator.vue';
import { useAlert } from '@/composable/useAlert';
import {useStore} from "vuex";
import {CITIES} from "@/constants/regions";
import vueFilePond from 'vue-filepond';
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import FilePondPluginImageResize from 'filepond-plugin-image-resize';
import FilePondPluginImageTransform from 'filepond-plugin-image-transform';
import {required} from "@/composable/useValidator";
import {MINIMUM_GRAD_FOR_FILED_OF_STUDY} from "@/schema/authentication/REGISTER.schema";

const { success, error } = useAlert();

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
    url: $storeFourUploadBaseUrl + '/api/upload/user_profile',
    method: 'POST',
    onload: (response) => {
      response = JSON.parse(response);
      // return response.key;
      return response[0].key;
    },
    onerror: (response) => {
      response = JSON.parse(response);
      return response.msg
    },
    ondata: (formData) => {
      window.h = formData;
      return formData;
    }
  },
}
const isDisabled = ref(true)
const onProcessFile = ()=> {
  isDisabled.value = false;
}

const onRemoveFile = ()=> {
  if(!pond.value.getFiles().length)
    isDisabled.value = true;
}

const UserRepository = RepositoryFactory.get('User');
/**
 * @type {Object}
 * @description Reactive state representing the login form schema.
 */
const schema = reactive(SCHEMA.schema);

/**
 * @type {Object}
 * @description Reactive state representing the state of the form including initial values.
 */
const state = reactive({
  ...SCHEMA.model
});

/**
 * @type {Object}
 * @description Rules for form validation.
 */
const rules = SCHEMA.validations;

/**
 * @type {Object}
 * @description Instance of vuelidate used for form validation.
 */
let v$ = useVuelidate(rules, state);



/**
 * Reactive ref for tracking the loading state of API calls.
 * @type {Ref<Boolean>}
 * @constant
 */
const loading = ref(false);
const filePondUploader = ref([]);
/**
 * Schema and Validations
 */

const submit = async () => {
  let isValid = await v$.value.$validate();
  if (!isValid) return;
  try {
    let payload = {
      name_english: state.name_english,
      name: state.name,
      province: state.province,
      city: state.city,
      sex: state.sex,
      field_of_study: state.field_of_study,
      familiraity_way: Number(state.familiarity_way),
      grade: state.grade,
    }
    // payload = Object.fromEntries(
    //     Object.entries(payload).filter(([_, value]) => value != null && value !== '')
    // );

    if(pond.value.getFiles().length) payload['filepond'] = pond.value.getFiles()[0].serverId
    loading.value = true;
    await UserRepository.updateProfile(payload);
   await store.dispatch('userStore/updateProfile');
    success('به روز رسانی پروفایل با موفقیت انجام شد.');
    v$.value.$reset();
  } catch (e) {
    error(e.error?.message);  // Display error using alert system if an error message exists.
  } finally {
    loading.value = false; // Reset submission loading indicator.
  }
};


const store = useStore();
const initialState = computed(()=> store.getters['userStore/userData']);

onMounted(()=> {
  state.mobile = initialState.value.mobile;
  state.name = initialState.value.name;
  state.name_english = initialState.value.name_english;
  state.grade = isNaN(initialState.value.grade) ? initialState.value.grade : +initialState.value.grade;
  state.sex = initialState.value.sex;
  state.field_of_study = +initialState.value.field_of_study;
  state.familiarity_way = initialState.value.familiraity_way || null;
  state.province = initialState.value.province || null;
  state.city = initialState.value.city || null;

})
watch(()=>state.province,(value)=> {
  schema[4].items = CITIES[value];
  if(value)  state.city = schema[4].items.find((item)=> +item.code == +initialState.value.city)?.code || '0';
  else state.city = null;
},{immediate: true});

watch(()=>state.grade,(value)=>{
  if(value > MINIMUM_GRAD_FOR_FILED_OF_STUDY || value === 'ghadim') setFieldOfStudyRules()
  else removeFieldOfStudyRules();
})

const setFieldOfStudyRules = ()=>{
  schema[6].disabled = false;
  state.field_of_study = initialState.value.field_of_study > -1 ? initialState.value.field_of_study : null;
  rules.field_of_study = { required };
  v$ = useVuelidate(rules, state);
}


const removeFieldOfStudyRules = ()=> {
  schema[6].disabled = true;
  state.field_of_study = 0;
  rules.field_of_study = { };
  v$ = useVuelidate(rules, state);
}
</script>

<template>
  <v-card  class="card " rounded="xl">
    <v-card-title>
      <v-icon>$account</v-icon>           اطلاعات کاربری
    </v-card-title>
    <v-card-subtitle class="mb-5">

    </v-card-subtitle>
    <v-card-text class="w-100 px-6">
      <FormGenerator :schema="schema" :v$="v$" :state="state" v-model="state"/>
      <div class="mt-6">
        <FilePond
            name="filepond[]"
            v-model="filePondUploader"
            ref="pond"
            label-idle='جهت درج تصویر <span class="filepond--label-action">اینجا</span> کلیک کنید'
            v-bind:allow-multiple="true"
            :accepted-file-types="fileTypes"
            :required="true"
            :server="filepondServerConfig"
            @processfiles="onProcessFile"
            @removefile="onRemoveFile"
            credits=""
        />
      </div>
    </v-card-text>
    <v-card-actions class="pb-4 px-4">
      <v-btn
          @click.prevent="submit"
          :loading="loading"
          :disabled="loading || v$.$invalid"
          class="btn-neo"
          size="x-large"
          variant="elevated"
          color="primary"
          rounded="pill"
          width="270"
          type="submit">
        به روز رسانی
      </v-btn>
    </v-card-actions>
  </v-card>
</template>

<style scoped lang="scss">

</style>