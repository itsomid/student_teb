<script setup>
import { SCHEMA } from "@/schema/course-class/ASK_QUESTION.schema";
import { inject, reactive, ref } from "vue";
import FormGenerator from "@/components/base/form/FormGenerator.vue";
import useVuelidate from "@vuelidate/core";
import vueFilePond from 'vue-filepond';
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import FilePondPluginImageResize from 'filepond-plugin-image-resize';
import FilePondPluginImageTransform from 'filepond-plugin-image-transform';
import ClConfirmModal from "@/components/app/ClConfirmModal.vue";
import RepositoryFactory from "@/repository/RepositoryFactory";
import { useRoute } from "vue-router";

// Props and emits
const props = defineProps(['teacher', 'className']);
const emits = defineEmits(['update-questions']);

// Injections and route
const $storeFourUploadBaseUrl = inject('$storeFourUploadBaseUrl');
const route = useRoute();

// Reactive state and validation
const { schema, model: state, validations: rules } = reactive(SCHEMA);
const v$ = useVuelidate(rules, state);

// Refs and loading state
const loading = ref(false);
const confirmDialog = ref(false);
const pond = ref(null);
const question_files = ref([]);

// FilePond setup with plugins
const FilePond = vueFilePond(
    FilePondPluginImagePreview,
    FilePondPluginFileValidateType,
    FilePondPluginImageResize,
    FilePondPluginImageTransform
);

const filePondChatServerConfig = {
  process: {
    url: `${$storeFourUploadBaseUrl}/api/upload/classqa`,
    method: 'POST',
    onload: (response) => JSON.parse(response)[0],
    onerror: (response) => response,
    ondata: (formData) => formData,
  },
};

// Class repository instance
const ClassRepository = RepositoryFactory.get("Class");

// Methods
const confirm = () => {
  confirmDialog.value = true;
};

const submit = async () => {
  const isValid = await v$.value.$validate();
  if (!isValid) return;

  try {
    const imageKeys = pond.value.getFiles().map(file => file.serverId.key);

    const { data: { data } } = await ClassRepository.askQuestion(route.params.class_id, {
      question_file: imageKeys,
      ...state,
    });
    emits('update-questions', data);
    resetForm();
  } catch (e) {
    if (e.error.status === 429) error("حداکثر تعداد سوال مجاز پرسیده شده است");
  }
};

const resetForm = () => {
  state.question_text = null;
  state.question_title = null;
  pond.value.removeFiles();
  v$.value.$reset();
};
</script>

<template>
  <v-card rounded="xl" flat border>
    <v-toolbar class="px-3">
      سوال خود را مطرح کنید
    </v-toolbar>

    <v-card-text>
      <h4>سوال خود را از استاد {{ teacher }} در مورد {{ className }} بپرسید</h4>
      <p class="text-warning mt-3">(برای این جلسه حداکثر ۵ سوال میتوانید بپرسید)</p>
    </v-card-text>

    <v-card-text>
      <FormGenerator :schema="schema" :v$="v$" :state="state" v-model="state" />
    </v-card-text>

    <v-card-text>
      <h4 class="mb-3">اگه عکسی برای سوالت داری اضافش کن (حداکثر ۵ عکس)</h4>
      <file-pond
          name="filepond[]"
          ref="pond"
          v-model="question_files"
          label-idle='جهت درج تصویر <span class="filepond--label-action">اینجا</span> کلیک کنید'
          :allow-multiple="true"
          :maxFiles="5"
          accepted-file-types="image/jpeg,image/jpg,image/png"
          :server="filePondChatServerConfig"
          credits=""
      />
    </v-card-text>

    <v-card-actions>
      <v-btn
          :loading="loading"
          :disabled="loading || v$.$invalid"
          variant="flat"
          size="large"
          color="primary"
          block
          rounded="xl"
          @click="confirm"
      >
        ارسال سوال
      </v-btn>
    </v-card-actions>

    <ClConfirmModal
        v-model="confirmDialog"
        title="شما مطمئن هستید؟"
        subtitle="بعد از ارسال سوال امکان ویرایش آن وجود ندارد"
        @confirm="submit"
    />
  </v-card>
</template>

<style scoped lang="scss">
/* Add any necessary styles here */
</style>
