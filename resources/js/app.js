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

window.Form = Form
window.Vue = require('vue').default;

Vue.config.productionTip = false

const app = new Vue({
    el: '#app',
});
