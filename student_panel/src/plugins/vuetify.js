/**
 * plugins/vuetify.js
 *
 * @see vuetify documentation: https://vuetifyjs.com/en/getting-started/installation/#manual-steps
 */

// Styles
import 'vuetify/styles'
/* To remove color pack uncomment below line and comment import 'vuetify/styles'*/
import '@/assets/styles/main.scss'

// Vuetify
import { createVuetify } from 'vuetify'
import { fa, en } from 'vuetify/locale'
import theme from "@/plugins/vuetify-options/theme/theme";
import icons from "@/plugins/vuetify-options/icons/icons";
import { md3 } from 'vuetify/blueprints'

import { VStepperVertical, VStepperVerticalActions, VStepperVerticalItem, } from 'vuetify/labs/VStepperVertical'
export default createVuetify({
  /** @see Vuetify feature guides
   * @tutorial https://vuetifyjs.com/en/introduction/why-vuetify/#feature-guides */
  blueprint: md3,

  locale: {
    locale: 'fa',
    fallback: 'en',
    messages: { fa, en }
  },
  components: {
    VStepperVertical,
    VStepperVerticalActions,
    VStepperVerticalItem
  },
  theme: theme,
  icons: icons,
  defaults: {
    VBtn: {
      color: '', // Set the default button color to primary
      variant: 'flat',  // Other options: 'tonal', 'outlined', 'text', 'elevated'
    },
  },
})
