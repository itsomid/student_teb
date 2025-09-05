<script setup>
  import {ref} from "vue";
  import {usePagination} from "@/composable/usePagination";
  import ClPagination from "@/components/app/ClPagination.vue";
  import {useUrl} from "@/composable/useUrl";
  import {useDateFormatter} from "../../../../composable/useDate";

  const props = defineProps(['conversation', 'total-count']);
  const panel = ref();

  const { imageUrlBuilder,fileUrlBuilder } = useUrl();

  const { paginateFactory } = usePagination();
  const page = ref(1);
  const max  = ref(3);

  const getPageItems = (arr,page, max)=> {
    return paginateFactory(arr,page, max)
  }
</script>

<template>
  <v-card v-if="conversation.qa" rounded="xl" flat border>
    <v-toolbar class="px-3">
      سوالات پرسیده شده مربوط به {{ conversation.course_name }}
    </v-toolbar>
    <v-expansion-panels
        v-if="conversation.qa"
        v-model="panel"
        multiple
        variant="accordion"
        elevation="0"
    >
      <v-expansion-panel v-for="(qa,index) in getPageItems(conversation.qa,page,max)" :key="'questions-' + index + qa.created_at" :value="index">
        <v-expansion-panel-title>#{{ qa.conversation[0].user_id }} {{ qa.conversation[0].title }}</v-expansion-panel-title>
        <v-expansion-panel-text>
          <h5 class="text-primary">{{ qa.conversation[0].user_name }} پرسیده است:</h5>
          <v-card variant="tonal"  rounded="lg"  class="ma-3 pa-3" >
            <p v-html="qa.conversation[0].text"></p>
          </v-card>
          <div v-if="qa.conversation[0].hasOwnProperty('images')" class="mt-3">
            <div v-if="qa.conversation[0].images  !==  null">
              <div v-if="qa.conversation[0].images.length">
                <h5>تصاویر ضمیمه شده به سوال</h5>
                <div v-for="(image, index) in qa.conversation[0].images" :key="index" class="m-3 d-flex">
                  <a :href="imageUrlBuilder(image,'QUESTION_ANSWER')" target="_blank">
                    <img width="100" height="auto" :src="imageUrlBuilder(image,'QUESTION_ANSWER')">
                  </a>
                </div>
              </div>
            </div>
          </div>
          <h5 dir="rtl" class="text-end text-muted">{{useDateFormatter(qa.created_at, 'HOUR_DATE')}}</h5>

          <div v-if="qa.conversation[1] && qa.conversation[1].title">
            <v-divider v-if="qa.conversation[1].text || qa.conversation[1].images.length || qa.conversation[1].audios.length" class="my-6" />
            <h5 v-if="qa.conversation[1].text || qa.conversation[1].images.length || qa.conversation[1].audios.length">استاد پاسخ داده است</h5>
            <v-card variant="tonal"  rounded="lg"  class="ma-3 pa-3">
              <p class="answer" v-if="qa.conversation[1].text" v-html="qa.conversation[1].text"></p>
            </v-card>
            <div v-if="qa.conversation[1].hasOwnProperty('images') && qa.conversation[1].hasOwnProperty('audios')">

              <div v-if="qa.conversation[1].images !== null">
                <div v-if="qa.conversation[1].images.length">
                  <h6>تصاویر ضمیمه شده به پاسخ</h6>
                  <div v-for="(image, index) in qa.conversation[1].images" :key="index" class="m-3 d-flex">
                    <a :href="imageUrlBuilder(image,'QUESTION_ANSWER')" target="_blank">
                      <img width="100" height="auto" :src="imageUrlBuilder(image,'QUESTION_ANSWER')">
                    </a>
                  </div>
                </div>
              </div>

              <div v-if="qa.conversation[1].audios  !==  null">
                <div v-if="qa.conversation[1].audios.length">
                  <h5>فایل صوتی ضمیمه شده به پاسخ</h5>
                  <div class="audio-box">
                    <audio controls v-for="(audio, index) in qa.conversation[1].audios" :key="index">
                      <source v-if="audio.includes('wav')" :src="fileUrlBuilder(audio,'QUESTION_ANSWER')" type="audio/wav">
                    </audio>
                  </div>
                </div>
              </div>
            </div>
            <h5 class="text-left text-muted">{{useDateFormatter(qa.conversation[1].created_at,'HOUR_DATE')}}</h5>
          </div>
        </v-expansion-panel-text>
      </v-expansion-panel>
    </v-expansion-panels>
    <v-card-text v-else>
      هنوز سوالی پرسیده نشده است.
    </v-card-text>
    <v-divider />
    <v-card-actions class="justify-center">
      <ClPagination
          v-if="conversation.qa.length"
          class="mt-3"
          v-model="page"
          :model-value="page"
          :total-pages="Math.ceil(conversation.qa.length / max)"
          :total-visible="max" />
    </v-card-actions>
  </v-card>
</template>

<style scoped lang="scss">

</style>