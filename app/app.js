import Vue from 'vue'
import router from './routes.js'
import store from './store'
import UserPlugin from './plugins/user-plugin.js'

require('./bootstrap');

Vue.component('App', require('./components/App').default)
Vue.component('DropdownMenu', require('./components/DropdownMenu').default)
Vue.component('Footer', require('./components/Footer').default)
Vue.component('Slider', require('./components/Slider').default)
Vue.component('Products', require('./components/Products').default)
Vue.component('ProductModal', require('./components/ProductModal').default)
Vue.use(UserPlugin)

new Vue({
    el: '#app',
    router,
    store,
    data: {

    },
    methods: {
        isActiveMenu(path) {
            return window.location.pathname == path;
        },
        hideMenu: function() {
            this.$refs.dropdownMenu.showMenu = false
        }
    }
});

Vue.config.devtools = true;