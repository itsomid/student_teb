<script setup>
import {reactive, ref} from 'vue';
import RepositoryFactory from '@/repository/RepositoryFactory';
import { useAlert } from '@/composable/useAlert';

/**
 * Schema and Validations
 */
import { SCHEMA } from '@/schema/authentication/RESET_PASSWORD.schema';
import FormGenerator from "@/components/base/form/FormGenerator.vue";
import useVuelidate from "@vuelidate/core";


const AuthRepository = RepositoryFactory.get('Auth');
const { success, error } = useAlert();
const loading = ref(false);


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


const submit = async ()=> {
  let isValid = await v$.value.$validate();
  if (!isValid) return;
  try {
    loading.value = true;
    await AuthRepository.changePassword({ password: state.password });
    v$.value.$reset();
    success('رمز عبور با موفقیت تغییر کرد.')
  }catch (e) {
    error(e.error?.message)
  }finally {
    loading.value = false;
  }
}
</script>

<template>
  <v-card flat border rounded="xl">
    <v-card-title>
      <v-icon>$mdiSecurity</v-icon>            تغییر رمز عبور
    </v-card-title>
    <v-card-subtitle>
      رمز عبور جدید خود را وارد کنید.
    </v-card-subtitle>

    <v-card-text class="pt-4 px-6">
      <FormGenerator :schema="schema" :v$="v$" :state="state" v-model="state"/>
    </v-card-text>


    <v-card-actions class="px-4 pb-4">
      <v-btn
          @click="submit"
          :loading="loading"
          :disabled="loading || v$.$invalid"
          @keydown.enter="submit"
          color="primary"
          variant="elevated"
          size="x-large"
          rounded="xl"
          block
          type="submit">
        تغییر رمز عبور
      </v-btn>
    </v-card-actions>
  </v-card>
</template>

<style scoped lang="scss">

</style>