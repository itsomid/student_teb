<script setup>
/**
 * Vue OTP Verification component using Composition API.
 *
 * @component
 * @module OTPVerification
 * @see {@link https://vuejs.org/guide/}
 *
 * @description
 * This component handles OTP verification for user login.
 *
 * @script { setup } - The setup function for the component.
 * @script { imports } - Vue and composition API imports.
 *
 * @script { Ref<Object> } schema - Reactive state representing the login form schema.
 * @script { Ref<Object> } state - Reactive state representing the form's current state, including initial values.
 * @script { Ref<Object> } rules - Rules for form validation.
 * @script { VuelidateInstance } v$ - Instance of Vuelidate used for form validation.
 * @script { Ref<Boolean> } loading - Reference indicating whether form submission is in progress.
 * @script { Ref<String> } errorMessage - Reference for storing error messages.
 * @script { Ref<Number> } timerCount - Reference for the countdown timer.
 * @script { Function } getLockTime - Asynchronously retrieves and sets the countdown timer based on lock time.
 * @script { Function } submit - Asynchronously handles the form submission for OTP verification, updating the user's profile and navigating.
 * @script { Function } resend - Asynchronously handles the resend functionality for OTP verification.
 * @script { Function } onMounted - Lifecycle hook triggered after component is mounted to get lock time.
 */
import {computed, onMounted, reactive, ref} from "vue";
import { useRouter, useRoute } from "vue-router";
import { useStore } from "vuex";
import useVuelidate from "@vuelidate/core";
import useJwt from '@/composable/useJwt';
import { useAlert } from '@/composable/useAlert';
import { useOtp } from "@/composable/useOtp";
import { useNavigator } from "@/composable/useNavigator";
import RepositoryFactory from '@/repository/RepositoryFactory';
import FormGenerator from '../../components/base/form/FormGenerator.vue';
import ClAuthCard from '@/components/app/ClAuthCard.vue';
import {SCHEMA} from "@/schema/authentication/OTP_VERIFICATION.schema";
import {useGoogleTagManager} from "@/composable/useGtm";

const { success, error } = useAlert();

const Auth = RepositoryFactory.get("Auth");
const store = useStore();
const route = useRoute();
const { navigateToAuth, navigateToRegister,navigateToRedirectPath,navigateToDashboard } = useNavigator();
const { sendOtp, countDown } = useOtp();

const mobile = computed(() => route.params.mobile);
const { schema, model: state, validations: rules } = reactive(SCHEMA);
const v$ = useVuelidate(rules, state);
const loading = ref(false);


/**
 * Asynchronously handles the form submission for OTP verification, updating the user's profile and navigating.
 *
 * @async
 * @function
 * @name submit
 * @returns {Promise<void>} A Promise that resolves after successful submission.
 */
const submit = async () => {
  let isValid = await v$.value.$validate();
  if (!isValid) return;

  try {
    const { trackEventLogin } = useGoogleTagManager();

    loading.value = true;
    localStorage.setItem('sms_token', state.otp);
    const { data: { token } } = await Auth.otpLogin({ mobile: mobile.value, token: state.otp });
    useJwt.setToken(token);
    await store.dispatch('userStore/updateProfile');
    trackEventLogin({
      userId: store.getters['userStore/userData'].id,
      authentication_method: 'otp',
      timestamp: Date.now(),
    })
    reset();
    await success('ورود با موفقیت انجام شد');
    await navigateToRedirectPath() || await navigateToDashboard()
  } catch (e) {
    if (e.error?.status === 304) await navigateToRegister();
    e.error ? error(e.error?.message) : '';
  } finally {
    loading.value = false;
  }
};

/**
 * Lifecycle hook triggered after component is mounted to get lock time.
 *
 * @function
 * @name onMounted
 * @returns {void}
 */
onMounted(() => {
  reset();
  sendOtp(mobile.value);
});

const resendOtp = (mobile)=> {
  reset();
  sendOtp(mobile);
}


const reset = ()=> {
  state.otp = "";
  v$.value.$reset();
}

const changeNumber = ()=> {
  reset();
  navigateToAuth();
}

</script>
<template>
  <ClAuthCard :back="true" @back="reset">
    <template #head>
      <v-card-title class="py-6  text-center text-h5 text-lg-h4 font-weight-bold text-wrap">
        کد فعال سازی را وارد کنید.
      </v-card-title>
      <v-card-subtitle class="text-subtitle-1 text-center my-4  px-12 px-md-12 text-wrap">
       کد ارسال شده به شماره <span class="text-success font-weight-bold ss021">{{ mobile }}</span> را وارد کنید.
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
        ورود
      </v-btn>
    </template>

    <template #bottom>
      <v-card-text class="px-6">
        <div class="mb-4" >
          <router-link class="text-primary text-decoration-none" :to="{name:'login-pass'}" >
            ورود با رمز عبور
          </router-link>
        </div>
      </v-card-text>
    </template>
  </ClAuthCard>

</template>

<style scoped></style>