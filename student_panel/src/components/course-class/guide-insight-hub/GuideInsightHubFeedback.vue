<script setup>
import {computed, ref} from "vue";
import RepositoryFactory from "@/repository/RepositoryFactory";
import {useRoute} from "vue-router";
import {useAlert} from "@/composable/useAlert";

const props = defineProps({
  className : [String,Object],
  loading: Boolean,
})

const route   = useRoute();
const classId = computed(()=> route.params.id);

const { success, error } = useAlert();

const isLoading = ref(false);

const score = ref(0);
const comment = ref("");

const ClassRepository = RepositoryFactory.get("Class");

const sendFeedback = async (classId)=> {
  try {
    isLoading.value = true;
    const result = await ClassRepository.feedback(classId,{
      comment : comment.value,
      score   : score.value
    });
    success("نظر با موفقیت ثبت شد");
    reset();
  }catch (e) {
    let errorText = '';
    if (e.error.status === 422) {
      errorText = `لطفا امتیاز را وارد کنید`
    } else {
      errorText = e.error.status === 409 ? "شما قبلا نظر ارسال کرده اید" : 'مشکلی رخ داده دوباره امتحان کنید'
    }
    error(errorText);
  }finally {
    isLoading.value = false;
  }
}

const reset = ()=> {
  comment.value = "";
  score.value = 0
}
</script>

<template>
  <v-card elevation="0" class="pa-4">
    <v-card-title class="text-body-2 font-weight-bold">
     ارسال نظر
    </v-card-title>
    <v-skeleton-loader v-if="loading" min-width="200" type="card" ></v-skeleton-loader>
    <v-card-text v-else>
      <h3 class="text-body-2 font-weight-bold">{{ className }}</h3>
      <p class="text-caption text-secondary mt-4 font-weight-bold">
        امتیاز شما به این دوره از ۱ تا ۵ ستاره:
      </p>
      <div class="text-center">
        <v-rating
            dir="ltr"
            v-model="score"
            :size="$vuetify.display.smAndDown ? 'large' : 'x-large'"
            color="secondary"
            active-color="primary"
            class="my-12"
            hover
        ></v-rating>
      </div>

      <v-textarea v-model="comment" rounded="xl" variant="solo-filled" label="توضیحات (اختیاری):"></v-textarea>

    </v-card-text>
    <v-card-actions class="d-flex flex-row-reverse px-4">
      <v-btn
          @click="sendFeedback(classId)"
          :disabled="loading || isLoading"
          :loading="isLoading"
          color="primary"
          variant="elevated"
          width="174"
          rounded
          size="large">
        ثبت نظر
      </v-btn>
    </v-card-actions>
  </v-card>
</template>

<style scoped lang="scss">

</style>