import { createStore } from 'vuex'
import theme from "./general/theme.store";
import alert from "./general/alert.store";
import user from "@/store/user";
import chat from "@/store/chat";
import cart from "@/store/cart";
import notification from "@/store/notification";
import drawer from "@/store/drawer";
import shop from "@/store/shop";
import dashboard from "@/store/dashboard";
import navbar from "@/store/navbar";
import pwaWizard from "@/store/pwa"
import campaign from "@/store/campaign";
 export const store =  createStore({
  state: {
  },
  getters: {
  },
  mutations: {
  },
  actions: {
  },
  modules: {
   theme,
   alert,
   userStore: user,
   chatStore: chat,
   cartStore: cart,
   notificationStore: notification,
   drawer: drawer,
   shop: shop,
   dashboard: dashboard,
   navbar: navbar,
   pwaWizard: pwaWizard,
   campaign: campaign,

  }
})

export default store;