require('./bootstrap');

window.Vue = require('vue');

import router from './routes'

Vue.component('home-component', require('./components/Home.vue').default);

const app = new Vue({
    el: '#app',
    router
});