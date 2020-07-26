<style scoped lang="scss">
@import '../bootstrap';
@import 'node_modules/bootstrap/scss/buttons';
@import '../colors';
@import '../fonts';

.header {
  font-family: Montserrat, sans-serif;
  font-weight: bold;

  &__navbar {
    position: fixed;
    z-index: 11;
    top: 4rem;
    right: 6rem;
    list-style: none;
  }

  &--icon {
    width: 3rem;
    height: 3rem;
    fill: $base;
  }

  &--button {
    position: absolute;
    top: 0;
    right: 0;
    display: flex;
    align-items: center;
    padding: 1rem;
    border-radius: 3rem;

    &-text {
      margin-left: 1rem;
      color: $base;
      font-size: 2.5rem;
      text-transform: uppercase;
    }

    &:hover {
      background-color: $accent;
    }
  }
}

// Dropdown Menu

.dropdown__menu {
  position: fixed;
  z-index: 10;
  top: 0;
  right: 0;
  left: 0;
  display: flex;
  overflow: hidden;
  padding: 3rem;
  margin: 1rem;
  background-clip: padding-box;
  background-color: white;
  border-radius: 2rem;
  box-shadow: rgb(172, 153, 153) 0 0 20px 0;

  &-nav {
    padding: 0;
    list-style: none;

    &:first-child {
      flex-grow: 1;
    }

    &:last-child {
      padding-right: 10rem;
    }
  }

  &-item {
    display: inline-flex;

    &:focus {
      outline: none !important;
    }
  }

  &-link {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    padding: 0.8rem 0 0.8rem 2rem;
    border-radius: 0 50px 50px 0;
    box-shadow: none !important;
    text-decoration: none !important;

    :focus {
      border: none !important;
      box-shadow: none !important;
      outline: none !important;
    }
  }

  &-text {
    color: $text;
    font-family: Montserrat, sans-serif;
    font-size: 24px;
    font-weight: bold;
    text-transform: uppercase;
    transition: 0.3s color;

    &:hover {
      color: $secondary;
      outline: 0 !important;
      text-decoration: none !important;
    }

    &:focus {
      outline: none !important;
      text-decoration: none !important;
    }
  }
}

// Animation Menu Icon

.slide-fade-enter-active,
.slide-fade-leave-active {
  transition: all 0.6s;
}

.slide-fade-enter,
.slide-fade-leave-active {
  opacity: 0;
}

.slide-fade-enter {
  transform: translateX(31px);
}

.slide-fade-leave-active {
  transform: translateX(-31px);
}

// Dropdown Menu Animation

.dropdown-enter-active,
.dropdown-leave-active {
  transition: all 1s;
}

.dropdown-enter,
.dropdown-leave-to {
  opacity: 0;
  transform: translateY(30px);
}
</style>

<template>
    <nav class="header">
        <div class="header__navbar">
            <a v-on:click.prevent href="#" class="header__link">
                <transition name="slide-fade">
                    <!-- Header Navigation Menu Icons -->
                    <b-button class="header--button"  variant="secondary" v-if="showMenu" key="on" @click="showMenu = false">
                        <svg viewBox="0 0 24 24" class="header--icon">
                            <title>Close</title>
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path d="M18.3 5.71c-.39-.39-1.02-.39-1.41 0L12 10.59 7.11 5.7c-.39-.39-1.02-.39-1.41 0-.39.39-.39 1.02 0 1.41L10.59 12 5.7 16.89c-.39.39-.39 1.02 0 1.41.39.39 1.02.39 1.41 0L12 13.41l4.89 4.89c.39.39 1.02.39 1.41 0 .39-.39.39-1.02 0-1.41L13.41 12l4.89-4.89c.38-.38.38-1.02 0-1.4z" />
                        </svg>
                    </b-button>
                    <b-button variant="secondary" class="header--button" v-else key="off" @click="showMenu = true">
                        <svg viewBox="0 0 24 24" class="header--icon">
                            <title>Navigation Menu</title>
                            <path d="M6,8c1.1,0 2,-0.9 2,-2s-0.9,-2 -2,-2 -2,0.9 -2,2 0.9,2 2,2zM12,20c1.1,0 2,-0.9 2,-2s-0.9,-2 -2,-2 -2,0.9 -2,2 0.9,2 2,2zM6,20c1.1,0 2,-0.9 2,-2s-0.9,-2 -2,-2 -2,0.9 -2,2 0.9,2 2,2zM6,14c1.1,0 2,-0.9 2,-2s-0.9,-2 -2,-2 -2,0.9 -2,2 0.9,2 2,2zM12,14c1.1,0 2,-0.9 2,-2s-0.9,-2 -2,-2 -2,0.9 -2,2 0.9,2 2,2zM16,6c0,1.1 0.9,2 2,2s2,-0.9 2,-2 -0.9,-2 -2,-2 -2,0.9 -2,2zM12,8c1.1,0 2,-0.9 2,-2s-0.9,-2 -2,-2 -2,0.9 -2,2 0.9,2 2,2zM18,14c1.1,0 2,-0.9 2,-2s-0.9,-2 -2,-2 -2,0.9 -2,2 0.9,2 2,2zM18,20c1.1,0 2,-0.9 2,-2s-0.9,-2 -2,-2 -2,0.9 -2,2 0.9,2 2,2z" />
                        </svg>
                        <span class="header--button-text">Menu</span>
                    </b-button>
                </transition>
            </a>
        </div>
        <!-- Dropdown Menu -->
        <transition name="dropdown">
            <div class="dropdown__menu" v-bind:class="{ active: showMenu }" v-if="showMenu">
                <ul class="dropdown__menu-nav">
                    <li class="dropdown__menu-item">
                        <router-link to="/" class="dropdown__menu-link" title="Home">
                            <div class="dropdown__menu-text">Home</div>
                        </router-link>
                    </li>
                    <li class="dropdown__menu-item">
                        <router-link to="/cart" class="dropdown__menu-link" title="Cart">
                            <div class="dropdown__menu-text">Cart</div>
                        </router-link>
                    </li>
                    <li class="dropdown__menu-item">
                        <router-link to="/about" class="dropdown__menu-link" title="Cart">
                            <div class="dropdown__menu-text">About</div>
                        </router-link>
                    </li>
                </ul>

                <!-- Dropdown Menu Separator -->

                <!-- Logged in user menu start -->
                <ul v-if="is_logged_in" class="dropdown__menu-nav">
                    <li class="dropdown__menu-item">
                        <router-link to="/history" class="dropdown__menu-link" title="History">
                            <div class="dropdown__menu-text">History</div>
                        </router-link>
                    </li>
                    <li class="dropdown__menu-item">
                        <b-button variant="link" @click="logout" class="dropdown__menu-link" title="Logout">
                            <div class="dropdown__menu-text">Logout</div>
                        </b-button>
                    </li>
                </ul>
                <!-- Logged in user menu end -->

                <!-- Not logged in user menu start -->
                <ul v-else class="dropdown__menu-nav">
                    <li class="dropdown__menu-item">
                        <router-link to="/login" class="dropdown__menu-link" title="Cart">
                            <div class="dropdown__menu-text">Login</div>
                        </router-link>
                    </li>
                    <li class="dropdown__menu-item">
                        <router-link to="/signup" class="dropdown__menu-link" title="History">
                            <div class="dropdown__menu-text">Signup</div>
                        </router-link>
                    </li>
                </ul>
                <!-- Not logged in user menu end -->
            </div>
        </transition>

        <b-modal centered id="logout-error-modal"><div v-html="logout_errors"></div></b-modal>
    </nav>
</template>

<script>
    window.Vue = require('vue');
    import { mapState,  mapActions } from 'vuex'
    import AsyncComputed from 'vue-async-computed'
    import { ButtonPlugin } from 'bootstrap-vue'
    Vue.use(ButtonPlugin)
    Vue.use(AsyncComputed)

    export default {
        created () {
            this.$store.dispatch('access/checkUserAuth')
        },
        methods: {
            ...mapActions('access', [
                'checkUserAuth',
            ]),
            logout() {
                axios
                    .get('/api/logout')
                    .then(response => {
                        if (response.data.status) {
                            this.$store.dispatch('access/changeIsLoggedIn', false)
                        } else {
                            this.logout_errors = response.data.errors;
                            this.$bvModal.show('logout-error-modal')
                        }
                    });
            },
        },
        watch:{
            $route() {
                this.showMenu = false;
            }
        },
        computed: {
            ...mapState({
                is_logged_in: state => state.access.is_logged_in
            })
        },
        data() {
            return {
                logout_errors: null,
                showMenu: false
            }
        }
    }
</script>