/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Form from 'vform'
import notify from './notify.js'
import formatDatetime from './format-datetime.js'
import compo from './component.js'
import router from './routes.js'

window.Form = Form
window.Vue = require('vue').default;

Vue.config.productionTip = false

if (document.querySelector("meta[name='admin-fullname']")) {
    Vue.prototype.$adminId = document.querySelector("meta[name='admin-fullname']").getAttribute('content');
} else if (document.querySelector("meta[name='deanfaculty-id']")) {
    Vue.prototype.$facultyId = document.querySelector("meta[name='deanfaculty-id']").getAttribute('content');
} else if (document.querySelector("meta[name='formteacher-id']")) {
    Vue.prototype.$teacherId = document.querySelector("meta[name='formteacher-id']").getAttribute('content');
}

const app = new Vue({
    el: '#app',
    router
});
