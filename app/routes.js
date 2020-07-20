import VueRouter from 'vue-router'

let LandingPage = require('./pages/LandingPage.vue').default;
let AboutPage = require('./pages/AboutPage.vue').default;
let LoginPage = require('./pages/LoginPage.vue').default;
let SignupPage = require('./pages/SignupPage.vue').default;
let CartPage = require('./pages/CartPage.vue').default;

let routes = [
    { path: '/', component: LandingPage, name: 'landing', meta: {
            title: 'Pizza task',
        }
    },
    { path: '/about', component: AboutPage, name: 'about', meta: {
            title: 'About',
        }},
    { path: '/login', component: LoginPage, name: 'login', meta: {
            title: 'Login',
        }
    },
    { path: '/signup', component: SignupPage, name: 'signup', meta: {
            title: 'Signup',
        }
    },
    { path: '/cart', component: CartPage, name: 'cart', meta: {
            title: 'Cart',
        }
    },
];

let router = new VueRouter({
    mode: 'history',
    routes
});

// Shows page title
router.beforeEach((to, from, next) => {
    document.title = (to.meta.title ? to.meta.title : 'Pizza task')
    next()
})

export default router;