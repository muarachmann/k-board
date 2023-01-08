import Vue from 'vue'
import VueRouter from 'vue-router'
import store from "./store";

Vue.use(VueRouter)

const routeList = [
    {
        path: '/',
        name: 'home',
        component: 'Home',
        meta: {
            title: 'Welcome'
        },
    },
    {
        path: '/board',
        name: 'board',
        component: 'KanbanBoard',
        meta: {
            middleware: 'auth',
            title: 'Dashboard'
        },
    },
    {
        path: '/board/create',
        name: 'create-board',
        component: 'KanbanBoardCreate',
        meta: {
            middleware: 'auth',
            title: 'Create | Columns'
        },
    },
    {
        path: '*',
        name: 'error',
        component: 'NotFound',
        meta: {
            title: 'Oops Error'
        },
    },
]

export const routes = routeList.map(route => {
    return {
        ...route,
        component: () => import(`./pages/${route.component}.vue`)
    }
})

const router = new VueRouter({
    mode: 'history',
    routes: routes
});

router.beforeEach((to, from, next) => {
    document.title = `${to.meta.title} | ${process.env.MIX_APP_NAME}`
    if (to.matched.some(link => link.meta.middleware)) {
        if (localStorage.getItem('access_token')) {
            axios.defaults.headers.common.Authorization = `Bearer ${localStorage.access_token}`
        }
        axios.get('/api/user').then((data) => {
            next()
        }).catch((response) => {
            console.log(response)
            return next({ name: 'home'})
        })
    } else {
        next()
    }
});

export default router
