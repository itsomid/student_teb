import RepositoryFactory from "@/repository/RepositoryFactory";
import LocalStorageService from "@/services/LocalStorage.service";

const Cart = RepositoryFactory.get("Cart");

export default {
  namespaced: true,
  state: {
    cart: null,
    isLoading: false,
    cartItemsCount:0,
    nonInstallmentProducts: [],
  },
  getters: {
    cart: (state) => state.cart,
    cartItemsCount: (state) => state.cartItemsCount,
    items: (state) => (state.cart ? state.cart.items : null),
    invoice: (state) => (state.cart ? state.cart.invoice : null),
    installments: (state) => (state.cart ? state.cart.installments : null),
    discount: (state) => (state.cart && state.cart.invoice.conditions ? state.cart.invoice.conditions[0] : ""),
    nonInstallmentProducts: (state) => (state.nonInstallmentProducts),
  },
  mutations: {
    SET_LOADING(state, isLoading) {
      state.isLoading = isLoading;
    },
    UPDATE_CART_ITEMS_COUNT(state, { type }) {
      if (type === "increment") {
        LocalStorageService.set('cart_updated_at', new Date().getTime());
        state.cartItemsCount += 1;
      } else {
        state.cartItemsCount = Math.max(0, state.cartItemsCount - 1);
        if(state.cartItemsCount === 0) LocalStorageService.remove('cart_updated_at');
      }
    },
    SET_CART_ITEMS_COUNT(state, count) {
      state.cartItemsCount = count;
    },
    SET_CART(state, cart) {
      state.cart = cart;
    },

    SET_NON_INSTALLMENT_PRODUCTS(state, products) {
      state.nonInstallmentProducts = products;
    }
  },
  actions: {
    fetchCartItemsCount(context, action){
      context.commit('UPDATE_CART_ITEMS_COUNT', action)
    },
    async getCartCount(context){
      try {
        const { data: { data } } = await Cart.getUserCartItemsCount();
        context.commit('SET_CART_ITEMS_COUNT', data.count)
      }catch (e) {
      }
    },
    updateCart(context, payload) {
      context.commit('SET_CART', payload)
    },
  },
}
