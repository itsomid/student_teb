<script setup>
import ClModal from "@/components/app/ClModal.vue";
import {computed, inject, ref} from "vue";
import vueFilePond from 'vue-filepond';
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import FilePondPluginImageResize from 'filepond-plugin-image-resize';
import FilePondPluginImageTransform from 'filepond-plugin-image-transform';
import {useAlert} from "@/composable/useAlert";
import {useSocketService} from "@/composable/useSocket";


const emits = defineEmits(['update-file-message'])
const props = defineProps(['socket','destinationMessage']);
const { serverSendMessageEmitter } = useSocketService();
const destinationAddress = computed(()=> props.destinationMessage);

const dialog = defineModel({default: false});
const $storeFourUploadBaseUrl = inject('$storeFourUploadBaseUrl');
const { info } = useAlert();

const ACCEPTED_FILE_TYPES = [
  'image/png',
  'image/jpeg',
  'image/jpg',
  'application/pdf',
  'application/zip',
  'application/vnd.rar',
  'application/x-rar-compressed',
  'application/octet-stream',
  'application/octet-stream',
  'application/x-zip-compressed',
  'multipart/x-zip',
  'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
  'application/msword'

];
const isDisabled = ref(true);
const filePondChatServerConfig = {
  process: {
    url: $storeFourUploadBaseUrl + '/api/upload/chat',
    method: 'POST',

    onload: (response) => {
      console.log('uploaded...');
      // console.log("raw", response);
      response = JSON.parse(response);
      return response[0]

    },
    onerror: (response) => {
      // response = JSON.parse(response);

      return response
    },
    ondata: (formData) => {
      window.h = formData;
      return formData;
    }
  },
};
const pond = ref();
const files = ref([]);
const FilePond = vueFilePond(
    FilePondPluginFileValidateType,
    FilePondPluginImageResize,
    FilePondPluginImagePreview,
    FilePondPluginImageTransform
);
const onProcessFile = ()=> {
  isDisabled.value = false;
}

const onRemoveFile = ()=> {
  if(!pond.value.getFiles().length)
    isDisabled.value = true;
}

const fileUploadHandler = ()=> {
  let fileData = null;
  if(pond.value.getFiles().length )fileData = pond.value.getFiles()[0].serverId;
  if (!!fileData) {
    sendFile(fileData.name, fileData.key, fileData.type, 'fileUploadModal');
    dialog.value = false;
  } else {
    info('فایلی انتخاب نشده است');
  }
};

const sendFile = (message, file, mediaType)=>{
  serverSendMessageEmitter(
    props.socket,
      {
    to: destinationAddress.value,
    file: file,
    message: message,
    media_type: mediaType,
  },(response)=>{
    if(response.status === 'ok') emits('update-file-message', response.data)
  });
}
</script>

<template>
   <div>
     <v-btn @click="dialog = true" icon="$mdiPaperclip" color="secondary"/>
     <ClModal width="400" v-model="dialog">
        <v-toolbar density="compact" class="px-3">
          ارسال فایل
          <v-spacer />
          <v-btn size="small" icon="$mdiClose" @click="dialog=false"></v-btn>
        </v-toolbar>
        <v-card-text>
          <file-pond
              name="filepond[]"
              ref="pond"
              v-model="files"
              label-idle='جهت درج فایل <span class="filepond--label-action">اینجا</span> کلیک کنید'
              v-bind:allow-multiple="false"
              :accepted-file-types="ACCEPTED_FILE_TYPES"
              :server="filePondChatServerConfig"
              :required="true"
              credits=""
          />
        </v-card-text>
       <v-card-actions class="px-2">
         <v-btn block variant="elevated" flat rounded="xl"  color="primary" border @click="fileUploadHandler">
           ارسال فایل
         </v-btn>
       </v-card-actions>
     </ClModal>
   </div>
</template>

<style scoped lang="scss">

</style>