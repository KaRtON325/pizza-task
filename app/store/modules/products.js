// initial state
const state = () => ({
  all: []
})

// getters
const getters = {}

// actions
const actions = {
  getAllProducts ({ commit }) {
    axios
        .get('/api/public/get-products?expand=product_properties,product_properties.property')
        .then(response => {commit('setProducts', response.data)});
  }
}

// mutations
const mutations = {
  setProducts (state, products) {
    state.all = products
  }
}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}
