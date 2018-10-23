import axios from "axios/index";

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// Global Vue and events
window.Vue = require('vue');
window.Event = new Vue();

// Vue Router
import router from './routes';
import VueRouter from 'vue-router';

// Mixins/utilities
import api from './mixins/api'
import auth from './mixins/auth'
import constants from './constants'

// Vue injections
Vue.use(api);
Vue.use(auth);
Vue.use(VueRouter);

// Vue components
Vue.component('confirm', require('./components/dialogs/Confirm'));
Vue.component('loading', require('./components/dialogs/Loading'));
Vue.component('modal', require('./components/dialogs/Modal'));
Vue.component('nav-bar', require('./components/navigation/NavBar'));
Vue.component('paginator', require('./components/navigation/Paginator'));

// Vue Prototype override
Vue.prototype.CONSTANTS = constants;

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',


    router,

    created() {
        this.getAdminCopies();
    },

    methods: {
        getAdminCopies(){
            this.api.get('/copies/admin?lang=' + constants.language).then(response => {
                constants.setCopies(response.data);
            });
        }
    }
});
