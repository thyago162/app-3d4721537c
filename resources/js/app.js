require('./bootstrap');

import Vue from 'vue';
import axios from 'axios';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import store from './store/store';
import router from './routes/router'
import VueSimpleAlert from "vue-simple-alert";
import {
    ValidationObserver,
    ValidationProvider,
    extend,
    localize
} from "vee-validate";

//Importa bibliotecas extras do vee-validate
import en from "vee-validate/dist/locale/en.json";
import * as rules from "vee-validate/dist/rules";

//Importa os arquivos css do Bootstrap
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

import App from './App';

Vue.component("ValidationObserver", ValidationObserver);
Vue.component("ValidationProvider", ValidationProvider);

Object.keys(rules).forEach(rule => {
    extend(rule, rules[rule]);
});

localize("pt-br", en);

Vue.use(BootstrapVue);
Vue.use(IconsPlugin);
Vue.use(VueSimpleAlert);

//Configurações do axios
Vue.prototype.$axios = axios;

new Vue({
    el: '#app',
    template: '<app/>',
    router,
    store,
    components: {App}
})
