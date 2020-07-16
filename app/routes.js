import VueRouter from 'vue-router'

let LandingPage = require('./pages/LandingPage.vue');
let AboutPage = require('./pages/AboutPage.vue');
let LoginPage = require('./pages/LoginPage.vue');
let SignupPage = require('./pages/SignupPage.vue');

let routes = [
    { path: '/', component: LandingPage, name: 'landing'},
    { path: '/about', component: AboutPage, name: 'about'},
    { path: '/login', component: LoginPage, name: 'login', meta: {
            title: 'Login',
        }
    },
    { path: '/signup', component: SignupPage, name: 'signup', meta: {
            title: 'Signup',
        }
    },
];

let router = new VueRouter({
    mode: 'history',
    routes,
/*    beforeEach: ((to, from, next) => {
        document.title = to.meta.title
        next()
    })*/
});
router.beforeEach((to, from, next) => {
    document.title = (to.meta.title ? to.meta.title : 'Pizza task')
    next()
})

export default router;
