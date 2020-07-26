import Vue from 'vue'
import router from './routes.js'
import store from './store'
import CurrencyPlugin from './plugins/CurrencyPlugin'

window.axios = require('axios');

Vue.component('App', require('./components/App').default)
Vue.component('DropdownMenu', require('./components/DropdownMenu').default)
Vue.component('Footer', require('./components/Footer').default)
Vue.component('Slider', require('./components/Slider').default)
Vue.component('Products', require('./components/Products').default)
Vue.component('ProductModal', require('./components/ProductModal').default)
Vue.component('CartTable', require('./components/CartTable').default)
Vue.component('OrderForm', require('./components/OrderForm').default)
Vue.component('FormInput', require('./components/FormInput').default)
Vue.component('FormSelect', require('./components/FormSelect').default)
Vue.component('OrderModal', require('./components/OrderModal').default)
Vue.component('HistoryTable', require('./components/HistoryTable').default)
Vue.use(CurrencyPlugin)

new Vue({
    el: '#app',
    router,
    store,
    data: {

    },
    created () {
        axios.defaults.headers.common = {
            'X-Requested-With': 'XMLHttpRequest',
        }

        axios.interceptors.request.use(config => {
            config.headers['Authorization'] = `Bearer ${this.$store.getters["access/getAccessToken"]}`
            return config;
        }, function (error) {
            return Promise.reject(error);
        });
    }
});