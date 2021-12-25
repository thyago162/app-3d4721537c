require('./bootstrap');

import Vue from 'vue';
import axios from 'axios';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import store from './store/store';
import router from './routes/router'

import App from './App';

//Importa os arquivos css do Bootstrap
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

Vue.use(BootstrapVue);
Vue.use(IconsPlugin);

//Configurações do axios
Vue.prototype.$axios = axios;

new Vue({
    el: '#app',
    template: '<app/>',
    router,
    store,
    components: {App}
})
