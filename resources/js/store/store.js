import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios'

Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        products: []
    },
    getters: {
        getProduts: state => {
            return state.products
        }
    },
    mutations: {
        saveProduct(state, payload) {
            state.products = payload
        }
    },
    actions: {
        products({commit}, params) {
           axios.get('http://localhost:8000/api/products', {params: params})
                .then(response => {
                    commit('saveProduct', response.data.products)
                })
        }
    }
})

export default store;