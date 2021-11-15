import Vue from 'vue';
import Snotify, { SnotifyPosition } from 'vue-snotify';

const SnotifyOptions = {
    toast: {
        position: SnotifyPosition.rightTop
    }
};
Vue.use(Snotify, SnotifyOptions)