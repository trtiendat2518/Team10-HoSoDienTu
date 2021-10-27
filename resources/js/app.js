/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Snotify, { SnotifyPosition } from 'vue-snotify'
import Form from 'vform'

window.Form = Form
window.Vue = require('vue').default;


const SnotifyOptions = {
    toast: {
        position: SnotifyPosition.rightTop
    }
};
Vue.use(Snotify, SnotifyOptions)

Vue.config.productionTip = false

//Dashboard
Vue.component('dashboard-component', require('./components/admin/pages/DashboardComponent.vue').default);

//Pagination
Vue.component('pagination', require('./components/pagination/PaginationComponent.vue').default);

//Information
Vue.component('update-info-component', require('./components/admin/pages/info/UpdateInfoComponent.vue').default);

//Lecturer Manage
Vue.component('lecturer-manage-component', require('./components/admin/pages/lecturer/LecturerManageComponent.vue').default);

const app = new Vue({
    el: '#app',
});
