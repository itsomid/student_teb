<script setup>
import {useAlert} from "@/composable/useAlert";
import RepositoryFactory from "@/repository/RepositoryFactory";

const props = defineProps({
  status: Number,
  loading: Boolean,
  live_stream_link: String,
  class_id: [String,Number]
})

const { error, success,info} = useAlert();
const ClassRepository = RepositoryFactory.get('Class');

const loginToClassinoConnect = async (id)=> {
  window.open(props.live_stream_link, '_blank');
  try {
    await ClassRepository.setUserClassPresent(id,{
      watch_online: 1
    });
    success('حضور شما در جلسه ثبت شد.')
  }catch(e) {
    e?.error?.status === 409 ? info(e.error.message) : error('در خواست شما با خطا مواجه شده است.')
  }
}
</script>

<template>
  <div>
    <span  class="text-body-2 font-weight-bold">
      جلسه در حال برگزاری می باشد
    </span>
    <div class="d-flex flex-row flex-wrap">
      <v-btn
          v-if="status === 106 || status === 107"
          color="success"
          rounded
          :disabled="loading"
          class="mx-auto mt-3"
          :loading="loading"
          @click="loginToClassinoConnect(class_id)"
      >
        <span class="font-weight-bold text-caption"> ورود به جلسه (Shafa Connect)</span>
      </v-btn>
      <!--              <router-link :to="{name: 'live-class', params:{class_id: data.class_id}}" v-if="data.live_stream_link"-->
<!--      <v-btn-->
<!--          v-if="!live_stream_link"-->
<!--          variant="tonal"-->
<!--          color="success"-->
<!--          rounded-->
<!--          :to="{name: 'dashboard', params:{class_id: class_id}}"-->
<!--          class="mx-auto mt-3"-->
<!--          href="">-->
<!--        ورود به جلسه <small>(نسخه با کیفیت HD)</small> <small>(حجم مصرفی بالاتر)</small>-->
<!--      </v-btn>-->
    </div>
  </div>
</template>

<style scoped lang="scss">

</style>