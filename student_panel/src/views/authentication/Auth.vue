<script setup>
/**
 * Vue 3 component script setup for handling login and signup panel.
 *
 * @module LoginSignupPanel
 */
import { onMounted, ref, reactive } from 'vue';
import { useRoute } from 'vue-router';
import useVuelidate from '@vuelidate/core';
import { useAlert } from '@/composable/useAlert';
import { useCookies } from '@/composable/useCookies';
import ClAuthCard from '@/components/app/ClAuthCard.vue';
import FormGenerator from '@/components/base/form/FormGenerator.vue';
import { SCHEMA } from '@/schema/authentication/LOGIN.schema';
import { LOGIN_MESSAGE } from '@/constants/apiResponseMessages';
import RepositoryFactory from '@/repository/RepositoryFactory';
import { useNavigator } from "@/composable/useNavigator";
import {useReagent} from "@/composable/useReagent";

const { getCookie } = useCookies();
const { getReagentCode,removeReagentCode } = useReagent();
const { warning, error } = useAlert();

/**
 * Auth repository instance for making authentication-related API calls.
 *
 * @type {object}
 * @constant
 */
const Auth = RepositoryFactory.get('Auth');
const User = RepositoryFactory.get('User');

/**
 * Vue router route instance.
 *
 * @type {object}
 * @constant
 */
const route = useRoute();

const { navigateToRegister, navigateToLoginWithPassword,navigateToLoginWithOTP } = useNavigator();

/**
 * UTM_MA parameter for user tracking.
 *
 * @type {string}
 * @constant
 */
const utm_ma = route.query;

/**
 * regentCode parameter for user support.
 *
 * @type {string}
 * @constant
 */
const reagentCode = getReagentCode();
const support = ref();

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
 * Reactive state representing the login form schema.
 *
 * @type {object}
 * @constant
 */
const { schema, model: state, validations: rules } = reactive(SCHEMA);

/**
 * Vuelidate instance used for form validation.
 *
 * @type {object}
 * @constant
 */
const v$ = useVuelidate(rules, state);

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
    const { data: { is_new_user,has_password } } = await Auth.auth(state);
    if(is_new_user)  navigateToRegister(state.mobile, utm_ma);
    else  navigateToLoginWithPassword(state.mobile)
    // is_new_user ?  navigateToRegister(state.mobile, utm_ma): navigateToLoginWithPassword(state.mobile);
    v$.value.$reset();
  } catch (e) {
    errorMessage.value = LOGIN_MESSAGE.ERROR[e.error?.status];
    error(errorMessage.value);
  } finally {
    loading.value = false;
  }
};

const loginWithPassword = ()=> {
  navigateToLoginWithPassword(state.mobile)
}

const getSupportByReagentCode = async(reagentCode)=> {
  try {
    const { data } = await User.getSupportByReagentCode(reagentCode);
    support.value = data;
  }catch (e) {
    console.log(e);
  }
}
/**
 * Handles side effects upon component mount.
 * Retrieves and checks for redirect path cookie data, alerting the user if needed.
 *
 * @function
 * @name onComponentMount
 */
onMounted(async () => {
  const redirectData = getCookie('redirect_path');
  if (redirectData) {
    warning('کاربر گرامی برای مشاهده محتوای مورد نظر لطفا ابتدا وارد شوید');
  }
  try {
    const {data} = await User.checkVpnBeforeLogin()
    if (data['use-vpn']){
      warning('برای تجربه کاربری بهتر لطفا VPN خود را خاموش کنید');
    }
  } catch (e) {
    console.log("ERROR: FOR VPN CHECK", e)
  }
  if(reagentCode) getSupportByReagentCode(reagentCode);
});
</script>
<template>
  <ClAuthCard>
    <template #head>
      <v-card-title class="py-6  text-center text-h5 text-md-h4 font-weight-bold">
        ورود/ثبت‌نام
      </v-card-title>
      <v-card-subtitle class="text-subtitle-1 my-4  px-12 px-md-12 text-wrap">
        برای ورود یا ثبت نام شماره تلفن همراه خود را وارد کنید.
      </v-card-subtitle>
    </template>
    <template #body>
      <p  v-if="reagentCode" class="text-secondary mb-3"> پشتیبان:
        <v-chip  size="small" closable @click:close="removeReagentCode">
          <span v-if="support?.sales_support_name">{{ support.sales_support_name}}</span>
          <span v-else>{{reagentCode}}</span>
        </v-chip>
      </p>
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
        ورود
      </v-btn>
    </template>

    <template #bottom>
<!--      <v-card-text class="px-6  mb-2">-->
<!--        <v-btn  :disabled="loading || v$.$invalid" variant="text" block height="56" @click="loginWithPassword">-->
<!--          ورود با رمز عبور-->
<!--        </v-btn>-->
<!--      </v-card-text>-->
    </template>
  </ClAuthCard>

</template>

<style scoped></style>