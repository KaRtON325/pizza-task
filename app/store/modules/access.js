// initial state
const state = () => ({
  access_token: null,
  is_logged_in: null,
  is_logged_in_fetching: false,
})

// getters
const getters = {
  getIsLoggedIn: (state) => {
    return state.is_logged_in
  },
  getAccessToken: (state) => {
    return state.access_token
  },
}

// actions
const actions = {
  checkUserAuth ({ state, commit }) {
    // Do not fetch twice
    if (!state.is_logged_in_fetching) {
      if (state.is_logged_in === null) {
        commit('setIsLoggedInFetching', true)
        axios
            .get('/api/public/check-user')
            .then(response => {
              commit('setIsLoggedIn', response.data)
              commit('setIsLoggedInFetching', false)
            });
      } else {
        return getters.getIsLoggedIn;
      }
    }
  },
  changeIsLoggedIn ({ commit }, status) {
    if (status) {
      commit('setIsLoggedIn', true)
    } else {
      commit('setAccessToken', null)
      commit('setIsLoggedIn', false)
    }
  },
  changeAccessToken ({ commit }, token) {
    commit('setAccessToken', token)
  }
}

// mutations
const mutations = {
  setIsLoggedIn (state, status) {
    state.is_logged_in = status
  },
  setIsLoggedInFetching (state, status) {
    state.is_logged_in_fetching = status
  },
  setAccessToken (state, token) {
    state.access_token = token
  },
}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}
