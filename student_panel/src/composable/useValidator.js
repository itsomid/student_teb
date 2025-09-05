/**
 * @created        16/09/2023 - 16:21
 * @author         Nariman Palangi
 * @user           ragnarok
 * @organization
 * @project        boilerplate-vue-3
 * @file name      useValidator.js
 * @file dir       src/composable
 */
import * as validators from '@vuelidate/validators'
import { i18n } from "@/plugins/i18n"
import { IRAN_OPERATORS } from "@/constants/phoneNumbers";


// or import { createI18nMessage } from '@vuelidate/validators'
const { createI18nMessage } = validators
const messagePath = ({ $validator }) => `validations.${$validator}`
const messageParams = (params) => ({
    ...params,
    property: params.property ? i18n.global.t(`property.${params.property}`) : i18n.global.t(`property.${params.property}`),
});
// Create your i18n message instance. Used for vue-i18n@9
const withI18nMessage = createI18nMessage({ t: i18n.global.t.bind(i18n), messagePath, messageParams  })
// for vue-i18n@8
// const withI18nMessage = createI18nMessage({ t: i18n.t.bind(i18n) })


// wrap each validator.
export const required = withI18nMessage(validators.required)
export const email = withI18nMessage(validators.email)
export const numeric = withI18nMessage(validators.numeric)
export const sameAs = withI18nMessage(validators.sameAs, { withArguments: true })

export const length = withI18nMessage( (param) => (value) =>
    value.length === param, { withArguments: true});
// validators that expect a parameter should have `{ withArguments: true }` passed as a second parameter, to annotate they should be wrapped
export const minLength = withI18nMessage(validators.minLength, { withArguments: true })
// or you can provide the param at definition, statically
export const maxLength = withI18nMessage(validators.maxLength, { withArguments: true })


export const mobile = withI18nMessage( (value) => {
    return  IRAN_OPERATORS.some(operator => value.startsWith('0'+ operator));
});

export const city = withI18nMessage( (value) => {
    return  !isNaN(value) && value != 0;
});