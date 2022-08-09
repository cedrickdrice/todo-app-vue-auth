import { createRouter, createWebHistory } from "vue-router";

//components
import Auth from './components/auth/Auth'
import Todo from './components/todo/Todo'
import $auth from './Auth.js';

const routes = [,
    {
        path: '/',
        name: 'Home',
        component: Todo,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/login',
        name: 'Login',
        component: Auth,
        meta: {
            requiresAuth: false,
            onlyGuest: true
        }
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    if(to.matched.some(record => record.meta.requiresAuth)) {
        if ($auth.check() === true) {
            next()
            return
        }
    }
    if(to.matched.some(record => record.meta.onlyGuest)) {
        if ($auth.check() === true) {
            next('/')
            return
        }
    }

    next('/login')
})

export default router

