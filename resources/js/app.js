/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

import Snotify, { SnotifyPosition } from 'vue-snotify'
import Form from 'vform'

window.Form = Form
const SnotifyOptions = {
    toast: {
        position: SnotifyPosition.rightTop
    }
};
Vue.use(Snotify, SnotifyOptions)

Vue.config.productionTip = false
Vue.component('pagination', require('./components/pagination/PaginationComponent.vue').default);

//Lecturer Manage
Vue.component('lecturer-manage-component', require('./components/admin/lecturer/LecturerManageComponent.vue').default);
Vue.component('update-lecturer-info-component', require('./components/admin/lecturer/UpdateLecturerInfoComponent.vue').default);

const app = new Vue({
    el: '#app',
});
