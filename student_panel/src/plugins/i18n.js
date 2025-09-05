import { createI18n } from "vue-i18n";
import messages from "@/locales/index";


export const i18n = createI18n({
  // something vue-i18n options here ...
  locale: import.meta.env.VITE_APP_I18N_LOCALE || "fa",
  fallbackLocale: import.meta.env.VITE_APP_I18N_FALLBACK_LOCALE || "en",
  silentLocallationWarn: true,
  formatFallbackMessages: true,
  messages: messages,
})

export default i18n;
