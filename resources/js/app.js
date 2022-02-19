/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap')

import Vue from 'vue'
import Form from 'vform'
import notify from './notify.js'
import formatDatetime from './format-datetime.js'
import formatNumber from './format-number.js'
import compo from './component.js'
import router from './routes.js'
import VueSweetalert2 from 'vue-sweetalert2'

window.Form = Form
window.Vue = require('vue').default

Vue.config.productionTip = false
Vue.use(VueSweetalert2)

if (document.querySelector("meta[name='admin-fullname']")) {
    Vue.prototype.$adminId = document.querySelector("meta[name='admin-fullname']").getAttribute('content')
} else if (document.querySelector("meta[name='deanfaculty-id']")) {
    Vue.prototype.$facultyId = document.querySelector("meta[name='deanfaculty-id']").getAttribute('content')
} else if (document.querySelector("meta[name='formteacher-id']")) {
    Vue.prototype.$teacherId = document.querySelector("meta[name='formteacher-id']").getAttribute('content')
} else if (document.querySelector("meta[name='student-id']")) {
    Vue.prototype.$studentId = document.querySelector("meta[name='student-id']").getAttribute('content')
}

export const eventBus = new Vue({
    methods: {
        changeAvatar(avatar) {
            this.$emit('wasAvatar', avatar)
        }
    }
})

const app = new Vue({
    router
}).$mount('#app')
