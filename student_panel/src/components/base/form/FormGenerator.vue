<script setup>
import {defineAsyncComponent, reactive, ref, watch} from "vue";
const ColorPicker = defineAsyncComponent(()=>import("./ColorPicker.vue"))
const PersianDatetimePicker = defineAsyncComponent(()=>import("vue3-persian-datetime-picker"))
const openDatePickerModal = ref(false)
const visiblePassword = ref(false)

const props = defineProps(["schema","modelValue",'v$','state'])
const emit = defineEmits(['update:modelValue', 'finishOtp'])
const index = ref(0);
/**
 * form state
 * */
let state = reactive(props.state);

/**
 * @description update parent v-model on form
 * */
watch(state,(value)=> {
  emit('update:modelValue', value)
});

</script>

<template>

  <slot v-if="$slots.body" name="body"></slot>

  <v-row v-else class="d-flex flex-wrap justify-start" >
    <v-col v-for="(input, i) in props.schema"  :cols="input.cols" :xl="input.xl" :lg="input.lg" :md="input.md" :sm="input.sm" class="px-2"
           id="form-generator-input">
      <v-text-field
          v-if="input.type==='text'"
          :variant="input.variant || 'solo'"
          :rounded="input.rounded || 'lg'"
          v-bind="$attrs"
          class="ss02"
          :class="input.inputClasses || ''"
          :label="$t(`property.${input.id}`)"
          :name="$t(input.id)"
          :placeholder="input.placeholder"
          :clearable="input.clearable"
          :hide-details="input.hideDetails"
          :suffix="input.suffix"
          :append-inner-icon="input.innerIcon"
          :prepend-icon="input.prependIcon || ''"
          :prepend-inner-icon="input.prependInnerIcon || ''"
          :readonly="!!input.readOnly"
          :disabled="input.disabled"
          v-model="state[input.id]"
          :error-messages="props.v$[input.id].$errors.map(e => e.$message)"
          @input="props.v$[input.id].$touch()"
          @blur="props.v$[input.id].$touch()"
      ></v-text-field>
      <v-text-field
          v-else-if="input.type==='password'"
          :variant="input.variant || 'solo'"
          :rounded="input.rounded || 'lg'"
          color="primary"
          :class="input.inputClasses || ''"
          v-bind="$attrs"
          :append-inner-icon="visiblePassword ? '$mdiEyeOffOutline' : '$mdiEyeOutline'"
          :type="visiblePassword ? 'text' : 'password'"
          :label="input.label"
          :placeholder="input.password"
          :clearable="input.clearable"
          :hide-details="input.hideDetails"
          :suffix="input.suffix"
          @click:append-inner="visiblePassword = !visiblePassword"
          :disabled="input.disabled"
          v-model="state[input.id]"
          :error-messages="props.v$[input.id].$errors.map(e => e.$message)"
          @input="props.v$[input.id].$touch()"
          @blur="props.v$[input.id].$touch()"
      ></v-text-field>
      <v-select
          v-else-if="input.type==='select'"
          :variant="input.variant || 'solo'"
          :color="input.color || ''"
          :closable-chips="true"
          :rounded="input.rounded || 'lg'"
          v-bind="$attrs"
          :class="input.inputClasses || ''"
          :items="input.items"
          :item-title="input.itemTitle"
          :item-value="input.itemValue"
          :label="input.label"
          :placeholder="input.placeholder"
          :clearable="input.clearable"
          :suffix="input.suffix"
          :hide-details="input.hideDetails"
          :multiple="!!input.multiple"
          :chips="!!input.chips"
          :menu-icon="input.menuIcon"
          :append-inner-icon="input.innerIcon"
          :prepend-icon="input.prependIcon"
          :disabled="input.disabled"
          v-model="state[input.id]"
          :error-messages="props.v$[input.id].$errors.map(e => e.$message)"
          @input="props.v$[input.id].$touch()"
          @blur="props.v$[input.id].$touch()"
      >
      </v-select>
      <div  v-else-if="input.type==='switch'">
        <label :for="input.id" class="text-body-2 text-secondary mt-n3">{{input.label }}</label>
        <v-switch
            v-model="state[input.id]"
            :id="input.id"
            :name="input.id"
            bg-color="card"
            :color="input.color || ''"
            :hide-details="input.hideDetails"
            :inset="input.inset || false"
            :error-messages="props.v$[input.id].$errors.map(e => e.$message)"
            @input="props.v$[input.id].$touch()"
            @blur="props.v$[input.id].$touch()"
            density="compact"
            role="switch"
        >
        </v-switch>
      </div>
      <v-textarea
          v-else-if="input.type==='textarea'"
          :variant="input.variant || 'solo'"
          :rounded="input.rounded || 'lg'"
          v-bind="$attrs"
          :class="input.inputClasses || ''"
          :label="$t(`property.${input.id}`)"
          :name="$t(input.id)"
          :placeholder="input.placeholder"
          :clearable="input.clearable"
          :hide-details="input.hideDetails"
          :suffix="input.suffix"
          :append-inner-icon="input.innerIcon"
          :prepend-icon="input.prependIcon"
          :disabled="input.disabled"
          v-model="state[input.id]"
          :error-messages="props.v$[input.id].$errors.map(e => e.$message)"
          @input="props.v$[input.id].$touch();emit('update:modelValue', $event.target.value)"
          @blur="props.v$[input.id].$touch()"
      ></v-textarea>
      <v-autocomplete
          v-else-if="input.type==='autocomplete'"
          :variant="input.variant || 'solo'"
          :color="input.color || ''"
          :closable-chips="true"
          :rounded="input.rounded || 'lg'"
          v-bind="$attrs"
          :class="input.inputClasses || ''"
          :items="input.items"
          :item-title="input.itemTitle"
          :item-value="input.itemValue"
          :label="input.label"
          :placeholder="input.placeholder"
          :clearable="input.clearable"
          :suffix="input.suffix"
          :hide-details="input.hideDetails"
          :multiple="!!input.multiple"
          :chips="!!input.chips"
          :menu-icon="input.menuIcon"
          :append-inner-icon="input.innerIcon"
          :prepend-icon="input.prependIcon"
          :disabled="input.disabled"
          v-model="state[input.id]"
          :error-messages="props.v$[input.id].$errors.map(e => e.$message)"
          @input="props.v$[input.id].$touch()"
          @blur="props.v$[input.id].$touch()"
          :return-object="!!input.returnObject"
      >
        <template v-if="!!input.hideSelection" #selection>

        </template>
      </v-autocomplete>
      <template  v-else-if="input.type==='date'" :key="'container-' + input.id">
        <v-text-field
            :variant="input.variant || 'solo'"
            bg-color="btn"
            :label="input.label"
            :placeholder="input.placeholder"
            :clearable="input.clearable"
            :suffix="input.suffix"
            class="ss02"
            :append-inner-icon="input.innerIcon"
            :prepend-icon="input.prependIcon"
            :hide-details="input.hideDetails"
            :disabled="input.disabled"
            v-model="state[input.id]"
            @click="openDatePickerModal = true;index=i;"
            :error-messages="props.v$[input.id].$errors.map(e => e.$message)"
            @input="props.v$[input.id].$touch()"
            @blur="props.v$[input.id].$touch()"
        ></v-text-field>
        <PersianDatetimePicker
            :show="openDatePickerModal && i === index"
            v-model="state[input.id]"
            color="#F4561B"
            class="rounded rounded-xl text-grey-darken-3 ss02"
            @close="openDatePickerModal=false;"
            customInput="true"
        />
      </template>
      <template  v-else-if="input.type==='color'">
        <ColorPicker :input="input"/>
      </template>
      <v-otp-input v-else-if="input.type==='otp'"
                   dir="ltr"
                   :length="input.length || 5"
                   :type="input.otpType || 'number'"
                   :variant="input.variant || 'solo'"
                   :label="input.label"
                   :rounded="input.rounded || 'rounded-lg'"
                   v-bind="$attrs"
                   :placeholder="input.placeholder"
                   :hide-details="input.hideDetails"
                   :disabled="input.disabled"
                   :loading="input.loading || false"
                   v-model="state[input.id]"
                   class="ss02"
                   :error-messages="props.v$[input.id].$errors.map(e => e.$message)"
                   @input="props.v$[input.id].$touch();emit('update:modelValue', $event.target.value)"
                   @blur="props.v$[input.id].$touch()"
                   @finish="emit('finishOtp')"
      ></v-otp-input>
      <v-checkbox v-else-if="input.type==='checkbox'"
                  v-model="state[input.id]"
                  :id="input.id"
                  :name="input.id"
                  :false-value="input.falseValue || false"
                  :true-value="input.trueValue || true"
                  :variant="input.variant || 'solo'"
                  :rounded="input.rounded || 'lg'"
                  :color="input.color || 'primary'"
                  :model-value="state[input.id]"
                  :disabled="input.disabled || false"
                  :hide-details="input.hideDetails || false"
                  :error-messages="props.v$[input.id].$errors.map(e => e.$message)"
                  @input="props.v$[input.id].$touch();emit('update:modelValue', $event.target.value)"
                  @blur="props.v$[input.id].$touch()"
      >
        <template #label>
          <div v-html="input.label" />
        </template>
      </v-checkbox>
    </v-col>

    <slot name="inline-action" class="m-4" />
  </v-row>

</template>

<style scoped>
.my-input.v-input .v-input__slot {
  border-radius: 100px;
}
</style>

