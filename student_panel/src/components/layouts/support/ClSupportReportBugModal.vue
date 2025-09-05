<script setup>
import {reactive, ref} from "vue";
import RepositoryFactory from "@/repository/RepositoryFactory";

const PanelRepository = RepositoryFactory.get("Panel");
const model = defineModel()
import ClModal from "@/components/base/ClModal.vue";
import {SCHEMA} from "@/schema/support/REPORT_BUG.schema";
import useVuelidate from "@vuelidate/core";
import {useAlert} from "@/composable/useAlert";
import FormGenerator from "@/components/base/form/FormGenerator.vue";

const { schema, model: state, validations: rules } = reactive(SCHEMA);
const v$ = useVuelidate(rules, state);
const loading = ref(false);
const errorMessage = ref("");

const { success, error } = useAlert();

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
    loading.value = true;
    await PanelRepository.reportBug(state)
    success("گزارش شما با موفقیت ارسال شد به زودی توسط تیم فنی بررسی می شود.");
    model.value = false;
  } catch (e) {
    if(e.error?.status === 429) error("شما بیش از حد مجاز گزارش ارسال کرده اید");
    else e.error ? error(e.error?.message) : '';
  } finally {
    loading.value = false;
  }
};
</script>

<template>
  <ClModal v-model="model"  title=" فرم ارسال گزارش خطای پنل آزمایشی" width="900" :blur="true">
      <template #content>
        <v-card-text class="pa-6">
          <FormGenerator  :schema="schema" :v$="v$" :state="state" v-model="state"/>
        </v-card-text>
      </template>

      <template #actions>
        <v-card-actions class="pa-4">
          <v-btn color="error" block variant="flat" size="large" rounded @click="submit" :loading="loading">
            ارسال گزارش
          </v-btn>
        </v-card-actions>
      </template>
  </ClModal>
</template>

<style scoped lang="scss">

</style>