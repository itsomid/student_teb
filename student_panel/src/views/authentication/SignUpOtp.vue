<script setup>
/**
 * @typedef {Object} Schema
 * @property {Object} schema - Reactive state representing the login form schema.
 * @property {Object} model - Reactive state representing the state of the form including initial values.
 * @property {Object} validations - Rules for form validation.
 */


/**
 * @typedef {Object} ApiResponse
 * @property {string} token - Token received from the API.
 */

/**
 * @typedef {Object} ApiResponseError
 * @property {number} status - Error status code.
 * @property {string} message - Error message.
 */

/**
 * @typedef {Object} UserData
 * @property {string} otp - One-time password entered by the user.
 */

/**
 * @typedef {Object} AuthRepository
 * @property {Function} lockTime - Function to retrieve lock time from the API.
 * @property {Function} verify - Function to verify the user with OTP.
 * @property {Function} login - Function to initiate login with the user's mobile number.
 */

/**
 * @typedef {Object} VueCompositionAPI
 * @property {Function} computed - Function for creating computed properties.
 * @property {Function} onMounted - Function for handling the onMounted lifecycle hook.
 * @property {Function} reactive - Function for creating reactive objects.
 * @property {Function} ref - Function for creating a ref.
 */

/**
 * @typedef {Object} VueRouterComposables
 * @property {Function} useRouter - Function to get the Vue Router instance.
 * @property {Function} useRoute - Function to access the route properties.
 */

/**
 * @typedef {Object} VuexComposables
 * @property {Function} useStore - Function to get the Vuex store instance.
 */

/**
 * @typedef {Object} VuelidateComposable
 * @property {Function} useVuelidate - Function to create an instance of vuelidate for form validation.
 */

/**
 * @typedef {Object} JwtComposable
 * @property {Function} setToken - Function to set the JWT token.
 */

/**
 * @typedef {Object} AlertComposable
 * @property {Function} error - Function to display an error message using the alert system.
 */

/**
 * @typedef {Object} NavigatorComposable
 * @property {Function} navigateToRegisterState - Function to navigate to the registration state.
 * @property {Function} navigateToRedirectPath - Function to navigate to the redirect path.
 * @property {Function} navigateToDashboard - Function to navigate to the dashboard.
 */

/**
 * @typedef {Object} RepositoryFactory
 * @property {Function} get - Function to get a repository instance.
 */

/**
 * Vue component that handles OTP verification.
 * @module OTPVerification
 * @param {Schema} schema - Form schema and default values for the form.
 * @param {AuthRepository} auth - Auth repository for making authentication related API calls.
 * @param {VueRouterComposables} router - Vue Router composables.
 * @param {VuexComposables} store - Vuex store composable.
 * @param {VuelidateComposable} vuelidate - Vuelidate composable for form validation.
 * @param {JwtComposable} jwt - JWT handling composable.
 * @param {AlertComposable} alert - Alert handling composable.
 * @param {NavigatorComposable} navigator - Navigator composable.
 */
import {computed, onMounted, reactive, ref} from "vue";
import { useRouter, useRoute } from "vue-router";
import { useStore } from "vuex";
import useVuelidate from "@vuelidate/core";
import { useAlert } from '@/composable/useAlert';
import {useOtp} from "@/composable/useOtp";
import { useNavigator } from "@/composable/useNavigator";
import RepositoryFactory from '@/repository/RepositoryFactory';
import FormGenerator from '../../components/base/form/FormGenerator.vue';
import ClAuthCard from '@/components/app/ClAuthCard.vue';
import { SCHEMA } from "@/schema/authentication/OTP_VERIFICATION.schema";

const { error } = useAlert();
const Auth = RepositoryFactory.get("Auth");
const store = useStore();
const router = useRouter();
const route = useRoute();
const { navigateToRegisterState } = useNavigator();
const { sendOtp, countDown } = useOtp();


const mobile = computed(() => route.params.mobile);
const { schema, model: state, validations: rules } = reactive(SCHEMA);
const v$ = useVuelidate(rules, state);
const loading = ref(false);


onMounted(() => {
  reset();
  sendOtp(mobile.value);
});

const reset = ()=> {
  state.otp = "";
  v$.value.$reset();
}

/**
 * Submits the OTP for verification.
 * @async
 * @function
 * @returns {Promise<void>}
 */
const submit = async () => {
  let isValid = await v$.value.$validate();
  if (!isValid) return;

  try {
    loading.value = true;
    localStorage.setItem('sms_token', state.otp);
    await Auth.otpRegister({ mobile: mobile.value, token: state.otp });
    reset();
    await navigateToRegisterState(mobile.value);
  } catch (e) {
      e.error ? error(e.error?.message) : '';
  } finally {
    loading.value = false;
  }
};

const resendOtp = (mobile)=> {
  reset();
  sendOtp(mobile);
}

const changeNumber = ()=> {
  reset();
  navigateToAuth();
}


</script>


<template>
  <ClAuthCard :back="true" @back="reset">
    <template #head>
      <v-card-title class="py-6  text-center text-h6 text-lg-h4 font-weight-bold text-wrap">
        کد فعال سازی را وارد کنید.
      </v-card-title>
      <v-card-subtitle class="text-subtitle-1 text-center my-4  px-12 px-md-12 text-wrap">
        کد ارسال شده به شماره <span class="text-success font-weight-bold ss02">{{ mobile }}</span> را وارد کنید.
      </v-card-subtitle>
      <div class="d-flex justify-center align-center">
        <v-btn
            @click="changeNumber"
            color="secondary"
            size="large"
            variant="text"
            rounded="lg"
            border
            flat
            class="mx-auto">
          <v-icon>$mdiPencil</v-icon>
          تغییر شماره
        </v-btn>
      </div>
    </template>
    <template #body>
      <div class="mt-6">
        <label>کد تایید</label>
        <FormGenerator @finishOtp="submit" :schema="schema" :v$="v$" :state="state" v-model="state"/>
        <div v-if="countDown > 0">
          <span style="line-height: 25px" class="px-1 ss02">{{ countDown > 60 ? `${Math.ceil(countDown/60)}` + ":" + `${countDown - Math.floor(countDown/60)*60}`: countDown}}</span>
          ثانیه تا ارسال مجدد کد
        </div>
        <v-btn v-else  class="px-0" variant="text" color="blue" @click.prevent="resendOtp(mobile)" :disabled="countDown > 0">
          ارسال مجدد کد تایید
        </v-btn>
      </div>
    </template>
    <template #action>
      <v-btn
          @click="submit"
          :loading="loading"
          :disabled="loading || v$.$invalid"
          @keydown.enter="submit"
          color="primary"
          variant="elevated"
          size="x-large"
          rounded="lg"
          block
          flat
          height="60"
          width="270"
          class="mb-4"
          type="submit">
        ثبت نام
      </v-btn>
    </template>
  </ClAuthCard>
</template>

<style scoped></style>