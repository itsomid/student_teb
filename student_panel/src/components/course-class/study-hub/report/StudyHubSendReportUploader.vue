<script setup>
import vueFilePond from 'vue-filepond';
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import FilePondPluginImageResize from 'filepond-plugin-image-resize';
import FilePondPluginImageTransform from 'filepond-plugin-image-transform';
import {computed, ref} from "vue";
import { inject } from 'vue'
import ClModal from "@/components/base/ClModal.vue";
import {useAlert} from "@/composable/useAlert";
import RepositoryFactory from "@/repository/RepositoryFactory";
import {useNavigator} from "@/composable/useNavigator";
import {useRoute} from "vue-router";

const { success, error,info } = useAlert();

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
    url: $storeFourUploadBaseUrl + '/api/upload/report',
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

const onProcessFile = ()=> {
  isDisabled.value = false;
}

const onRemoveFile = ()=> {
  if(!pond.value.getFiles().length)
    isDisabled.value = true;
}

/*
* component functionality
* */
const ClassRepository = RepositoryFactory.get("Class");

const { navigateToClass } = useNavigator();

const route = useRoute();
const classId = computed(()=> route.params.class_id);

const model = defineModel();

const loading = ref(false);
const isDisabled = ref(true)

const openConfirm = ()=> {
  model.value = true;
}

const closeConfirm = () => {
  model.value = false;
}

const confirm = async ()=> {
  const imageKeys = [];
  pond.value.getFiles().forEach((file) => {
    imageKeys.push(file.serverId);
  });
  if(imageKeys.length) info("کارنامه در حال بارگزاری میباشد...");
  try {
    loading.value = true;
    await ClassRepository.report(classId.value,{filepond: imageKeys});
    success("کارنامه با موفقیت بارگزاری شد");
    navigateToClass(classId.value);
  }catch (e) {
    if(e.error.status === 409) error(e.error.message);
  }finally {
    loading.value = false
  }
}
</script>

<template>
  <div class="mt-6">
    <FilePond
        name="filepond[]"
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
  <v-hover   v-slot="{ hover }">
    <v-btn
        class="w-100"
        rounded="xl"
        size="large"
        color="primary"
        :disabled="isDisabled"
        @click="openConfirm"
    >
      <div class="d-flex flex-column">
        <v-slide-y-transition :hide-on-leave="true">
          <span v-show="!hover">ارسال تکلیف</span>
        </v-slide-y-transition>
        <v-slide-y-reverse-transition :hide-on-leave="true">
          <span v-show="hover"> ارسال<i class="icon-CL_paper-plane"></i></span>
        </v-slide-y-reverse-transition>
      </div>
    </v-btn>
  </v-hover>
  <!--PopUp modal to show detail  -->
  <ClModal v-model="model"  title="تایید" width="600" :blur="true">
    <template #title>
      <v-icon color="primary">$mdiFileUploadOutline</v-icon>
    </template>
    <template #content>
      <v-card-text class="pa-6">
        <h3>شما مطمئن هستید؟</h3>
        <p class="text-secondary mt-3">
          بعد از ارسال تکلیف امکان ویرایش آن وجود ندارد
        </p>
      </v-card-text>
    </template>

    <template #actions>
      <v-card-actions class="pa-4 d-flex flex-row justify-center align-center">
        <v-btn @click="confirm" :disabled="loading" :loading="loading" class="px-6"  color="primary" variant="elevated" size="large" rounded  >
          بله مطمئن هستم
        </v-btn>
        <v-btn @click="closeConfirm" :disabled="loading" class="px-6"  color="error"  variant="tonal" size="large" rounded  >
          فعلا نه!
        </v-btn>
      </v-card-actions>
    </template>
  </ClModal>
</template>

<style lang="css">

</style>