import './bootstrap'

import Vue from "vue";
import VueModal from 'vue-js-modal'
import VueRouter from 'vue-router'
import BeMoApp from './core/BeMoApp';
import router from "./router";
import "./components"
import store from "./store";

window.Vue = Vue;
Vue.router = router

Vue.use(VueModal, { dialog: true })
Vue.use(VueRouter)

const app = new Vue({
    el: '#kanban-app',
    store,
    router: router,
    render: h => h(BeMoApp),
});
