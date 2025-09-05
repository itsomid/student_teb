<script setup>
import ClModal from "@/components/app/ClModal.vue";
import ClAuthCard from "@/components/app/ClAuthCard.vue";
import FormGenerator from "@/components/base/form/FormGenerator.vue";
import RepositoryFactory from "@/repository/RepositoryFactory";
import {computed, onMounted, reactive, ref, watch} from "vue";
import {SCHEMA} from "@/schema/authentication/GRADE.schema";
import useVuelidate from "@vuelidate/core";
import {required} from "@/composable/useValidator";
import {MINIMUM_GRAD_FOR_FILED_OF_STUDY} from "@/schema/authentication/REGISTER.schema";
import {useAlert} from "@/composable/useAlert";
import {useStore} from "vuex";

const store = useStore();
const isProfileUpdated = computed(()=> store.getters['userStore/isProfileUpdated']);
const modal = defineModel({
  default: false
});

const { error,success } = useAlert();

/**
 * Auth repository instance for making authentication-related API calls.
 *
 * @type {object}
 * @constant
 */
const User = RepositoryFactory.get('User');


/**
 * Reactive ref for tracking the loading state of API calls.
 *
 * @type {Ref<boolean>}
 * @constant
 */
const loading = ref(false);

/**
 * Reactive ref for holding error messages.
 *
 * @type {Ref<string>}
 * @constant
 */
const errorMessage = ref('');


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
 * Submits the form data. Determines if the user is new and navigates accordingly.
 *
 * @async
 * @function
 * @name submit
 */
const submit = async () => {
  let isValid = await v$.value.$validate();
  if (!isValid) return;
  try {
    loading.value = true;
    await User.updateGrade(state)
    await store.dispatch('userStore/updateProfile');
    success('به روز رسانی با موفقیت انجام شد.');
    modal.value = false;
    v$.value.$reset();
  } catch (e) {
    error(e.error.message);
  } finally {
    loading.value = false;
  }
};

const setFieldOfStudyRules = ()=>{
  schema[1].disabled = false;
  state.field_of_study = null;
  rules.field_of_study = { required };
  v$ = useVuelidate(rules, state);
}


const removeFieldOfStudyRules = ()=> {
  schema[1].disabled = true;
  state.field_of_study = 0;
  rules.field_of_study = { };
  v$ = useVuelidate(rules, state);
}
const reset = ()=> {
  state.name_family = "";
  state.grade = "";
  state.field_of_study = "";
  state.terms = false;
  v$.value.$reset();
}

watch(()=>state.grade,(value)=>{
  if(value > MINIMUM_GRAD_FOR_FILED_OF_STUDY || value === 'ghadim') setFieldOfStudyRules()
  else removeFieldOfStudyRules();
})

onMounted(()=>{
  if(!isProfileUpdated.value) modal.value = true;
})
</script>

<template>
  <ClModal v-model="modal"  class="" color="surface-darken-1"  :persistent="true" :opacity="1" dialog-theme="dark" card-theme="light">
    <ClAuthCard>
      <template #head>
        <v-card-title class="py-6  text-center text-h5 text-md-h4 font-weight-bold">
          تایید اطلاعات پروفایل
        </v-card-title>
        <v-card-subtitle class="text-subtitle-1 my-4  px-12 px-md-12 text-wrap text-center">
          لطفا اطلاعات پروفایلت رو به روز کن تا ما درس‌ها و محتوای متناسب با خودت رو بهت نمایش بدیم!
        </v-card-subtitle>
      </template>
      <template #body>
        <div>
          <FormGenerator  @keydown.enter="submit" :schema="schema" :v$="v$" :state="state" v-model="state"/>
        </div>
        <p class="text-error text-center" v-if="errorMessage.length > 0"> {{ errorMessage }} </p>
      </template>
      <template #action>
        <v-btn
            @click="submit"
            :loading="loading"
            :disabled="loading || v$.$invalid"
            @keydown.enter="submit"
            color="primary"
            variant="elevated"
            block
            size="large"
            rounded="lg"
            height="60"
            width="270"
            flat
            class="mb-3"
            type="submit">
          ذخیره اطلاعات و ورود به پنل
        </v-btn>
      </template>
    </ClAuthCard>
  </ClModal>
</template>

<style scoped lang="scss">

</style>