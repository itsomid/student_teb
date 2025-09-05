<script setup>
/**
 * Vue 3 component script setup for handling login with password functionality.
 * @module LoginWithPassword
 */

import {computed, onMounted, reactive, ref} from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { useStore } from 'vuex';
import useVuelidate from '@vuelidate/core';
import FormGenerator from '../../components/base/form/FormGenerator.vue';
import ClAuthCard from '@/components/app/ClAuthCard.vue';
import RepositoryFactory from '@/repository/RepositoryFactory';
import useJwt from '@/composable/useJwt';
import { useAlert } from '@/composable/useAlert';
import { useNavigator } from "@/composable/useNavigator";
import {useGoogleTagManager} from "@/composable/useGtm";


const { success, error } = useAlert();

/**
 * Auth repository instance for making authentication-related API calls.
 * @type {object}
 * @constant
 */
const Auth = RepositoryFactory.get('Auth');

/**
 * Vuex store instance.
 * @type {object}
 * @constant
 */
const store = useStore();

/**
 * Vue router instance.
 * @type {object}
 * @constant
 */
const router = useRouter();

/**
 * Vue router route instance.
 * @type {object}
 * @constant
 */
const route = useRoute();

/**
 * Navigator functions for redirection.
 * @type {object}
 * @constant
 */
const { navigateToRegister, navigateToDashboard, navigateToRedirectPath } = useNavigator();

/**
 * Computed property that derives the mobile number from route params.
 * @type {ComputedRef<String>}
 * @constant
 */
const mobile = computed(() => route.params.mobile);


/**
 * Schema and Validations
 */
import { SCHEMA } from '@/schema/authentication/LOGIN_WITH_PASSWORD.schema';

/**
 * Reactive state representing the login form schema.
 * @type {Object}
 * @constant
 */
const { schema, model: state, validations: rules } = reactive(SCHEMA);

/**
 * Vuelidate instance used for form validation.
 * @type {Object}
 * @constant
 */
const v$ = useVuelidate(rules, state);

/**
 * Reactive ref for tracking the loading state of API calls.
 * @type {Ref<Boolean>}
 * @constant
 */
const loading = ref(false);

/**
 * Reactive ref for holding error messages.
 * @type {Ref<String>}
 * @constant
 */
const errorMessage = ref('');

/**
 * Reactive object storing captcha-related data.
 * @type {Object}
 * @constant
 */
const captcha = reactive({
  image: ref(''),
  captcha_key: ref(''),
  is_fishy: ref(false),
});

/**
 * Reactive ref for the input value of captcha code.
 * @type {Ref<String>}
 * @constant
 */
const captchaCode = ref('');

/**
 * Lifecycle hook to fetch initial captcha when the component loads.
 * @function
 * @name onMounted
 */
onMounted(() => {
  getCaptcha();
});

/**
 * Asynchronously handles the form submission process for user login with credentials and, if necessary, a captcha.
 * Validates form data, performs the login action, handles token storage and user profile update,
 * navigates the user to the appropriate route post-login, catches any errors and refreshes captcha if an error occurs,
 * and finally resets the loading state.
 * @async
 * @function
 * @name submit
 */
const submit = async () => {
  let isValid = await v$.value.$validate();
  if (!isValid) return;

  try {
    const { trackEventLogin } = useGoogleTagManager();
    loading.value = true;

    // Construct user credentials payload. Conditionally add captcha if required.
    let userCredential = {
      'mobile': mobile.value,
      'password': state.password,
    };

    if (captcha.is_fishy) {
      userCredential.captcha = captchaCode.value;
      userCredential.key = captcha.captcha_key;
    }
    // Attempt to login with the provided credentials.
    const { data: { token } } = await Auth.loginWithPassword(userCredential);
    useJwt.setToken(token); // Store the received token.
    await store.dispatch('userStore/updateProfile');  // Update user profile in the store.
    trackEventLogin({
      userId: store.getters['userStore/userData'].id,
      authentication_method: 'password',
      timestamp: Date.now(),
    })
    await success('ورود با موفقیت انجام شد');
    reset();
    // Conditional navigation based on redirection path or to dashboard.
    await navigateToRedirectPath() || await navigateToDashboard()
  } catch (e) {
    await getCaptcha(); // Refresh the captcha on error.
    if (e.error?.status === 304) await navigateToRegister(mobile.value); // Navigate to registration if status code is 304.
    e.error ? error(e.error?.message) : '';  // Display error using alert system if an error message exists.
  } finally {
    loading.value = false; // Reset submission loading indicator.
  }
};

/**
 * Asynchronously loads a new captcha from the authentication service.
 * Once retrieved, it updates the component's `captcha` reactive object with the new captcha image, key, and status.
 * @async
 * @function
 * @name getCaptcha
 * @returns {Promise<void>} A Promise that resolves when the captcha has been refreshed.
 */
const getCaptcha = async () => {
  const { data: { image, captcha_key, is_fishy } } = await Auth.reloadCaptcha();
  captcha.image = image;
  captcha.captcha_key = captcha_key;
  captcha.is_fishy = is_fishy;
};

const reset = ()=> {
  state.password = "";
  v$.value.$reset();
}
</script>

<template>
  <ClAuthCard :back="true" @back="reset">
    <template #head>
      <v-card-title class="py-6  text-center text-h5 text-md-h4 font-weight-bold">
        رمز عبور خود را وارد کنید
      </v-card-title>
    </template>
    <template #body>
      <div>
        <FormGenerator  @keydown.enter="submit" :schema="schema" :v$="v$" :state="state" v-model="state"/>
      </div>
      <v-img width="150px"  height="" class="mx-auto mb-6 rounded-lg" v-if="captcha.is_fishy" :src="captcha.image" alt="" />
      <div class="form-group mb-3" v-if="captcha.is_fishy">
        <v-text-field id="captcha"
                      variant="outlined"
                      rounded="lg"
                      label="کپچا"
                      placeholder="کد امنیتی"
                      hide-details
                      @keydown.enter="submit"
               class="form-control form-control-rounded "
               name="captchaCode" type="text" v-model="captchaCode">
        </v-text-field>
      </div>
      <router-link v-if="mobile"  :to="{name:'login-otp', params: { mobile: mobile } }" class="text-primary text-decoration-none font-weight-bold">ورود با کد تایید</router-link>
    </template>
    <template #action>
      <v-btn
          @click="submit"
          :loading="loading"
          :disabled="loading || v$.$invalid"
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
        ورود
      </v-btn>
    </template>

    <template #bottom>

    </template>
  </ClAuthCard>

</template>

<style scoped></style>