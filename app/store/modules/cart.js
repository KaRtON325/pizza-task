// initial state
// shape: [{ id, quantity }]
const state = () => ({
  items: [],
})

// getters
const getters = {
  cartProducts: (state, getters, rootState) => {
    return state.items.map(({ id, quantity }) => {
      const product = rootState.products.all.find(product => product.id === id)
      return {
        name: product.name,
        prices: product.prices,
        quantity
      }
    })
  },

  cartTotalPrice: (state, getters) => {
    return getters.cartProducts.reduce((total, product) => {
      return total + product.prices.find(price => price.is_base === 1).value * product.quantity
    }, 0)
  }
}

// actions
const actions = {
  addProductToCart ({ state, commit }, product) {
    const cartItem = state.items.find(item => item.id === product.id)
    if (!cartItem) {
      commit('pushProductToCart', { id: product.id })
    } else {
      commit('incrementItemQuantity', cartItem)
    }
  },

  removeProductFromCart ({ state, commit }, product) {
    const cartItem = state.items.find(item => item.id === product.id)
    if (cartItem.quantity === 1) {
      commit('popProductFromCart', { id: product.id })
    } else {
      commit('decrementItemQuantity', cartItem)
    }
  },

  clearCart ({ commit }) {
    commit('setCartItems', [])
  },
}

// mutations
const mutations = {
  pushProductToCart (state, { id }) {
    state.items.push({
      id,
      quantity: 1
    })
  },

  popProductFromCart (state, { id }) {
    state.items = state.items.filter( item => item.id !== id );
  },

  incrementItemQuantity (state, { id }) {
    const cartItem = state.items.find(item => item.id === id)
    cartItem.quantity++
  },

  decrementItemQuantity (state, { id }) {
    const cartItem = state.items.find(item => item.id === id)
    cartItem.quantity--
  },

  setCartItems (state, items) {
    state.items = items
  },
}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}
