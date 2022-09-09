import {createRouter, createWebHistory} from "vue-router";
import Dashboard from "../views/Dashboard.vue";
import Login from "../views/Login.vue";
import Register from "../views/Register.vue";
import DefaultLayout from '../components/DefaultLayout.vue';
import AuthLayout from "../components/AuthLayout.vue";
import store from "../store";

const routes = [
    // {
    //     path: '/',
    //     name: 'Home',
    //     component: Home,
    //     meta: {requiresAuth: false}
    // },
    {
        path:'/',
        redirect: '/dashboard',
        component: DefaultLayout,
        children: [
            {
                path: '/dashboard',
                name: 'Dashboard',
                component: Dashboard,
                meta: {requiresAuth: true}
            }
        ]
    },
    {
        path: '/auth',
        redirect: '/login',
        name: 'Auth',
        component: AuthLayout,
        meta: {isGuest: true},
        children: [
            {
                path:'/login',
                name:'Login',
                component: Login
            },
            {
                path:'/register',
                name:'Register',
                component: Register
            },
        ]
    },

];

const router = createRouter({
    history: createWebHistory(),
    routes
});

router.beforeEach((to, from, next) => {

    // check if the route requires authentication and user is not logged in
    if (to.matched.some(route => route.meta.requiresAuth) && !store.state.user.token) {
        next({ name: 'Login' });
    }  else if(store.state.user.token && (to.name === 'Login' || to.name === 'Register')) {
        next({ name: 'Dashboard' })
    }  else {
        next();
    }
});

export default router;
