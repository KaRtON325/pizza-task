import Vue from 'vue'
import Vuex from 'vuex'
import cart from './modules/cart'
import products from './modules/products'
import createPersistedState from "vuex-persistedstate";

Vue.use(Vuex)

const debug = process.env.NODE_ENV !== 'production'

const cartState = createPersistedState({
  paths: ['cart']
})

export default new Vuex.Store({
  modules: {
    cart,
    products
  },
  strict: debug,
  plugins: [cartState],
})
