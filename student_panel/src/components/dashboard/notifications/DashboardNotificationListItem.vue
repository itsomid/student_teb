<script setup>
  import {useDateFormatter} from "@/composable/useDate";
  import {computed} from "vue";
  import {useNavigator} from "@/composable/useNavigator";
  import {useStore} from "vuex";
  import {useAlert} from "@/composable/useAlert";
  const {
    navigateToQuestionAnswer,
    navigateToHomework,
    navigateToQuiz,
    navigateToQuizAnswerSheet,
    navigateToClass,
    navigateToFinance,
    navigateToCourse
  } = useNavigator();
  const props = defineProps(['item'])
  const type = computed(()=> props.item.education_type || props.item.financial_type );
  const store = useStore();
  const { error } = useAlert();
  const TYPES = {
    educational_homework: {
      name: 'تکلیف',
      icon: '$mdiPencilRulerOutline',
      doAction: ()=> {
        navigateToHomework(props.item.action_data.class_id);
        store.dispatch('dashboard/closeNotificationDrawer');
      }
    },
    educational_homework_result: {
      name: 'تکلیف',
      icon: '$mdiPencilRulerOutline',
      doAction: ()=> {
        navigateToClass(props.item.action_data.class_id);
        store.dispatch('dashboard/closeNotificationDrawer');
      }
    },
    educational_qa: {
      name: 'پرسش و پاسخ',
      icon: '$mdiPencilRulerOutline',
      doAction: ()=> {
        if(props.item.action_data.course_id && props.item.action_data.class_id){
          navigateToQuestionAnswer(props.item.action_data.course_id,props.item.action_data.class_id);
          store.dispatch('dashboard/closeNotificationDrawer');
        } else error('انتقال به صفحه پرسش و پاسخ با مشکل مواجه شده است.')
      }
    },
    educational_handout: {
      name: 'آپلود جزوه',
      icon: '$mdiBookOpenVariantOutline',
      doAction: ()=> {
        navigateToClass(props.item.action_data.class_id);
        store.dispatch('dashboard/closeNotificationDrawer');
      }
    },
    educational_quiz: {
      name: 'آزمون',
      icon: '$mdiPencilOutline',
      doAction: ()=> {
        navigateToQuiz(props.item.action_data.quiz_id);
        store.dispatch('dashboard/closeNotificationDrawer');
      }
    },
    educational_vale: {
      name: 'آزمون',
      icon: '$mdiPencilOutline',
      doAction: ()=> {
        navigateToCourse(props.item.action_data.course_id);
        store.dispatch('dashboard/closeNotificationDrawer');
      }
    },
    educational_course: {
      name: 'دوره',
      icon: '$mdiBookOpenVariantOutline',
      doAction: ()=> {
        navigateToCourse(props.item.action_data.course_id);
        store.dispatch('dashboard/closeNotificationDrawer');
      }
    },
    educational_quiz_result: {
      name: 'نتیجه آزمون',
      icon: '$mdiPencilOutline',
      doAction: ()=> {
        navigateToQuizAnswerSheet(props.item.action_data.quiz_id)
        store.dispatch('dashboard/closeNotificationDrawer');
      }
    },
    educational_class_canceled: {
      name: 'لغو جلسه',
      icon: '$mdiPencilOutline',
    },
    educational_class_delayed: {
      name: 'تغییر ساعت جلسه',
      icon: '$mdiPencilOutline',
    },
    financial_installment_pay: {
      name: 'موعد سر رسید قسط',
      icon: '$mdiInvoiceListOutline',
      doAction: ()=> {
        navigateToFinance();
        store.dispatch('dashboard/closeNotificationDrawer');
      }
    },
    financial_installment_overdue: {
      name: 'قسط عقب افتاده',
      icon: '$mdiInvoiceListOutline',
      doAction: ()=> {
        navigateToFinance();
        store.dispatch('dashboard/closeNotificationDrawer');
      }
    },
    financial_refund: {
      name: 'بازگشت وجه',
      icon: '$mdiInvoiceListOutline',
      doAction: ()=> {
        navigateToFinance();
        store.dispatch('dashboard/closeNotificationDrawer');
      }
    },
    financial_deposit: {
      name: 'افزایش وجه',
      icon: '$mdiInvoiceListOutline',
      doAction: ()=> {
        navigateToFinance();
        store.dispatch('dashboard/closeNotificationDrawer');
      }
    },
  }
</script>

<template>
  <div>
    <v-list-item lines="three">
      <v-list-item-title class="d-flex flex-row align-center justify-space-between mt-2">
        <div>
          <v-btn size="x-small" rounded="lg" variant="tonal" color="primary" class="ml-2" readonly :icon="TYPES[type]?.icon"></v-btn>
          {{type === 'educational_course' ? item.title : TYPES[type]?.name }}
        </div>

        <v-icon v-if="item.unread" size="10" color="primary">$mdiCircle</v-icon>
      </v-list-item-title>
      <v-list-item-subtitle v-html="item.message" class="mt-2 text-truncate-none line-height-2">
      </v-list-item-subtitle>
      <v-list-item-subtitle class="mt-2 text-wrap">
        <div class="d-flex align-center justify-space-between">
          {{  useDateFormatter(item.createdAt,'START_WEEK_HOUR') }}

          <v-btn v-if="item.action_data" @click="TYPES[type]?.doAction()" variant="text" color="primary" rounded="lg">
            مشاهده
            <v-icon>$mdiChevronLeft</v-icon>
          </v-btn>
        </div>
      </v-list-item-subtitle>
    </v-list-item>
    <v-divider />
  </div>
</template>

<style scoped lang="scss">

</style>