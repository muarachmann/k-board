import Vue from "vue";
import Vuex from "vuex";
import router from '../router';

Vue.use(Vuex);
export default new Vuex.Store({
    state: {
        authenticated: false,
        user: {},
        access_token: null
    },
    getters: {
        authenticated(state) {
            return localStorage.authenticated ? localStorage.authenticated : state.authenticated;
        },
        user(state) {
            return Object.keys(localStorage.user).length > 0 ? JSON.parse(localStorage.user) : state.user
        },
        access_token(state) {
            return localStorage.access_token ? localStorage.access_token : state.access_token;
        }
    },
    mutations: {
        SET_AUTHENTICATED (state, authenticated) {
            state.authenticated = authenticated
            localStorage.authenticated = authenticated
        },
        SET_USER (state, user) {
            state.user = user
            localStorage.user = JSON.stringify(user);
        },
        SET_ACCESS_TOKEN (state, access_token) {
            state.access_token = access_token
            axios.defaults.headers.common.Authorization = `Bearer ${access_token}`
            localStorage.access_token = access_token
        },
        CLEAR_ALL(state) {
            localStorage.removeItem('user')
            localStorage.removeItem('access_token')
            localStorage.removeItem('authenticated')
        }
    },
    actions:{
        login({ commit }, data) {
            commit('SET_USER', data.user)
            commit('SET_ACCESS_TOKEN', data.access_token)
            commit('SET_AUTHENTICATED', true)
            router.push({ name: 'board' })
        },
        logout({ commit }) {
            commit('SET_USER', {})
            commit('SET_ACCESS_TOKEN', null)
            commit('SET_AUTHENTICATED', false)
            commit('CLEAR_ALL')
            router.push({ name: 'home' })
        }
    },
});
