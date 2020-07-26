import Vue from 'vue'
import Vuex from 'vuex'
import cart from './modules/cart'
import products from './modules/products'
import access from './modules/access'
import createPersistedState from "vuex-persistedstate";

Vue.use(Vuex)

const storeState = createPersistedState({
  paths: ['cart', 'access']
})

export default new Vuex.Store({
  modules: {
    cart,
    products,
    access,
  },
  strict: process.env.NODE_ENV === 'production',
  plugins: [storeState],
})
