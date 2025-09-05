<script setup>
/**
* @file This script is a setup component for the register page, handling register functionality.
*/

/**
 * Vue component imports
 */
import FormGenerator from '../../components/base/form/FormGenerator.vue'; // Form generator component
import ClAuthCard from '@/components/app/ClAuthCard.vue'; // Authentication card layout component
import {required } from "@/composable/useValidator";
/**
 * Vue composable function imports
 */
import {computed, reactive, ref, watch} from 'vue'; // Composition API functions
import { useRoute } from 'vue-router'; // Vue Router composables
import { useStore } from 'vuex'; // Vuex store composable
import useVuelidate from '@vuelidate/core'; // Vue form validation
import {useNavigator} from "@/composable/useNavigator";
const { success, error } = useAlert();

/**
 * Repository imports
 */
import RepositoryFactory from '@/repository/RepositoryFactory'; // Factory for API repositories

/**
 * @type {object}
 * @description Auth repository obtained from the RepositoryFactory for making authentication related API calls.
 */
const Auth = RepositoryFactory.get("Auth");

/**
 * Router and Store usage in the setup
 */
const store = useStore(); // Using Vuex store
const route = useRoute(); // Access to the route properties
const { navigateToRedirectPath,navigateToDashboard } = useNavigator();

/**
 * @type {ComputedRef<String>}
 * @description Computed property that derives the mobile number from route params.
 */
const mobile = computed(() => route.params.mobile);


/**
 * Schema and Validations
 */
import {MINIMUM_GRAD_FOR_FILED_OF_STUDY, SCHEMA} from '@/schema/authentication/REGISTER.schema';
import {useCookies} from "@/composable/useCookies";
import {useUTMMA} from "@/composable/useUTMMA";
import useJwt from "@/composable/useJwt";
import {useAlert} from "@/composable/useAlert";
import {useReagent} from "@/composable/useReagent";
import {useGoogleTagManager} from "@/composable/useGtm"; // Login form schema and default values for the form

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
 * @type {Ref<Boolean>}
 * @description Reference indicating whether form submission is in progress.
 */
const loading = ref(false);
const locked = ref(false);

const { getReagentCode } = useReagent();
const { getRepresenter } = useCookies();
const { sendUTMMA } = useUTMMA();



/**
 * Handles form submission.
 * @async
 * @function
 * @returns {Promise<void>}
 */
const submit =async  ()=> {
  let isValid = await v$.value.$validate();
  if(!isValid) return;
  try{
    const { trackEventSignup } = useGoogleTagManager();
    const payload = {
      mobile:mobile.value,
      name: state.name_family,
      grade: state.grade === 'ghadim' ? state.grade : Number(state.grade),
      field_of_study: state.field_of_study,
      reagent_code: getReagentCode() || getRepresenter(),
      sms_token: localStorage.getItem('sms_token'),
      utm: JSON.parse(localStorage.getItem('utm_ma')),
    };

    locked.value = true;
    loading.value = true;
    await sendUTMMA();
    const { data: { token } } = await Auth.register(payload);
    useJwt.setToken(token);
    await success('ثبت نام شما با موفقیت انجام شد');
    await store.dispatch('userStore/updateProfile');
    trackEventSignup({
      userId: store.getters['userStore/userData'].id,
      method: 'signup',
      timestamp: Date.now(),
    })
    reset();
    await navigateToRedirectPath() || await navigateToDashboard({register: 'accomplished'})

  }catch(e) {
    console.log(e.error.message)
    e.error ? error(e.error.message) : '';
  }finally {
    loading.value = false;
    locked.value = false;
  }
}


const setFieldOfStudyRules = ()=>{
  schema[2].disabled = false;
  state.field_of_study = null;
  rules.field_of_study = { required };
  v$ = useVuelidate(rules, state);
}


const removeFieldOfStudyRules = ()=> {
  schema[2].disabled = true;
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
</script>

<template>
  <ClAuthCard @back="reset">
    <template #head>
      <v-card-title class="py-6  text-center text-h4 font-weight-bold">
        ثبت‌نام
      </v-card-title>
      <v-card-subtitle class="text-center text-subtitle-1 my-4  px-12 px-md-12">
       اطلاعات خود را کامل کنید.
      </v-card-subtitle>
    </template>
    <template #body>
      <div class="px-2">
        <FormGenerator @keydown.enter="submit" :schema="schema" :v$="v$" :state="state" v-model="state"/>
      </div>
    </template>

    <template #action>
      <v-btn
          @click="submit"
          :loading="loading"
          :disabled="loading || v$.$invalid || locked"
          @keydown.enter="submit"
          color="primary"
          variant="elevated"
          size="large"
          rounded="lg"
          height="60"
          width="270"
          flat
          block
          class="mb-4"
          type="submit">
        ثبت نام
      </v-btn>
    </template>
  </ClAuthCard>

</template>

<style scoped></style>