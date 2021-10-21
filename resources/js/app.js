/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

Vue.component('pagination', require('./components/pagination/PaginationComponent.vue').default);
Vue.component('lecturer-manage-component', require('./components/admin/LecturerManageComponent.vue').default);

const app = new Vue({
    el: '#app',
});
