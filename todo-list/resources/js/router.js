import { createRouter, createWebHistory } from "vue-router";

//components
import Auth from './components/auth/Auth'
import Todo from './components/todo/Todo'
import $auth from './Auth.js';

const routes = [
    {
        path: '/login',
        name: 'Login',
        component: Auth,
        meta: {
            requiresAuth: false,
            onlyGuest: true
        }
    },
    {
        path: '/',
        name: 'Home',
        component: Todo,
        meta: {
            requiresAuth: true
        }
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from) => {
    if (to.meta.requiresAuth === true && $auth.check() === false) {
        return {
            path: '/login'
        }
    }
    if(to.meta.onlyGuest === true && $auth.check() === true) {
        return {
            path: from.fullPath ?? '/'
        }
    }
})

export default router

