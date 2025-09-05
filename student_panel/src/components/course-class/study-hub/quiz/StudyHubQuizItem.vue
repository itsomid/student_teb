<script setup>
  import {useUrl} from "@/composable/useUrl";
  import {computed, onMounted, ref} from "vue";
  import {useThemeManager} from "@/composable/useThemeManager";
  const emits = defineEmits(['setAnswer']);

  const props = defineProps({
    index: {
      type: Number,
      required: true
    },
    question: {
      type: Object,
      required: true
    },
    isQuestion: {
      type: Boolean,
      default: true,
    }
  })

  const answer = (listSelectedItems) => {
    const answer = {
      question_id : props.question.question_id,
      answer_id   : listSelectedItems[0]
    }
    emits('setAnswer',answer);
  }
  const { imageUrlBuilder } = useUrl();

  const { isDark } = useThemeManager();
  const imageTheme = computed(() => isDark.value ? 'invert' : '');

  const getColor = (item)=> {
    if(props.isQuestion) return 'primary';
    else if (item.state === 1) return 'success';
    else if(item.state !== 1 && item.is_selected) return 'error'
  }

  const isActive = (item) => {
    if(!props.isQuestion) return item.is_selected || item.state === 1;
    else {
      //TODO
    }
  }

  const isUnanswered = computed(()=>  !props.isQuestion && props.question.options.every((option)=> !option.is_selected));
</script>

<template>
  <v-card  elevation="3" rounded="xl"  class="mb-6">
    <v-toolbar class="px-6">
      <h3>
        {{index+1}})
        <span v-if="question.caption">{{question.caption}}</span>
      </h3>
    </v-toolbar>
    <v-card-text class="pa-3 pa-lg-8">
      <v-row>
        <v-col cols="12" lg="9">
          <v-img :class="imageTheme" rounded="xl" width="100%" class="mx-auto"  :src="imageUrlBuilder(question.pic_filename, 'QUIZ')" />

          <div class="w-100" v-if="question.answer_pic_filename">
             پاسخ تشریحی:
            <v-img :class="imageTheme" rounded="xl" width="100%" class="mx-auto" :src="imageUrlBuilder(question.answer_pic_filename, 'QUIZ')"  alt=""/>
          </div>
          <div class="d-flex flex-column justify-center align-center mt-3">
            <audio v-if="question.audio_filename" controls class="px-6 px-lg-3">
              <source :src="imageUrlBuilder(question.audio_filename, 'QUIZ')"
                      type="audio/wav">
            </audio>
          </div>
        </v-col>

        <v-col cols="12" lg="3">
         <v-list
             @update:selected="answer"
             variant="elevated"
             nav
             bg-color="transparent"

         >
           <v-list-subheader class="text-body-2 font-weight-bold">
             پاسخ:
           </v-list-subheader>
           <v-divider class="my-3"/>
           <v-list-item
               v-for="item in question.options"
               :active="isActive(item)"
               :key="item.id"
               :value="item.option_id"
               rounded="lg"
               class="mb-3"
               variant="elevated"
               :color="getColor(item)"
               base-color="table-active"
           >
             <template #append="{ isSelected }">
                <v-icon v-if="isSelected" size="small">$mdiClose</v-icon>
             </template>
             <v-list-item-title class="px-3">
              {{ item.caption}}
             </v-list-item-title>
           </v-list-item>
           <span v-if="isUnanswered" class="font-weight-bold text-warning">
             شما جواب این سوال رو ندادی.
           </span>
         </v-list>
        </v-col>
      </v-row>
    </v-card-text>
  </v-card>
</template>
