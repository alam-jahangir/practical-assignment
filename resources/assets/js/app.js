
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.VueRouter = require('vue-router').default;
window.vueBreadcrumbs = require('vue-breadcrumbs');

Vue.use(VueRouter);
//Vue.use(vueBreadcrumbs);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//const categories = Vue.component('categories', require('./components/Categories.vue'));
Vue.component('autocomplete', require('./components/Autocomplete.vue'));
Vue.component('navigation', require('./components/Navigation.vue'));
Vue.component('override_breadcrumbs', require('./components/OverrideBreadcrumbs.vue'));


const router = new VueRouter({
    //hashbang: false,
    mode: 'history',
    linkActiveClass: 'active',
    routes:[
        {
            path: '/categories',
            component: require('./components/Categories.vue'),
            meta: {
                breadcrumb: 'Categories',
            },
        },
        {
            path: '/login',
            component: require('./components/Login.vue'),
            meta: {
                breadcrumb: 'Login',
            },
        },
        {
            path: '/register',
            component: require('./components/Register.vue'),
            meta: {
                breadcrumb: 'Registration',
            },
        },
        {
            path:'/',
            component: require('./components/Home.vue'),
            meta: {
                breadcrumb: 'Home',
            },
        },
        {
            path:'*',
            component: require('./components/Error_404.vue'),
            meta: {
                breadcrumb: '404 Not Found',
            },
        }
    ]
});


Vue.use(vueBreadcrumbs, {
    template: '<override_breadcrumbs :breadcrumbs="$breadcrumbs"></override_breadcrumbs>'
    /*template: '<nav class="breadcrumb" v-if="$breadcrumbs.length"> ' +
    '<router-link class="breadcrumb-item" v-for="(crumb, key) in $breadcrumbs" :to="linkProp(crumb)" :key="key">{{ crumb | crumbText }}</router-link> ' +
    '</nav>'*/
});

const app = new Vue({
    el: '#app',
    router:router
});
