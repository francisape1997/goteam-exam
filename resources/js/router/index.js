import { createRouter, createWebHistory } from 'vue-router';

import { authRequired } from '@/helpers/index.js';

// Views
import MainLayout from '@/layouts/MainLayout.vue';

const guestRoutes = [
    {
        path: 'login',
        component: () => import('@/views/auth/index.vue'), meta: { page: 'login' },
    },
    {
        path: 'register',
        component: () => import('@/views/register/index.vue'), meta: { page: 'register' },
    }
];

const authRoutes = [
    {
        path: 'pokemons',
        component: () => import('@/views/pokemons/index.vue'),
    },
    {
        path: 'profile',
        component: () => import('@/views/profile/index.vue'),
    },
    {
        path: 'users',
        component: () => import('@/views/users/index.vue'),
    }
];

const routes = [
    { path: '/:pathMatch(.*)*', name: 'Not Found', component: () => import('@/views/error/404/index.vue') },

    {
        path: '/',
        component: MainLayout,
        children:
            [
                ...guestRoutes,
                ...authRoutes,
            ],
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) =>
{
    const hasAccessToken = localStorage.getItem('token') !== null;

    if (authRequired(to.meta.page) && !hasAccessToken)
    {
        return next('/login');
    }

    if (hasAccessToken && !authRequired(to.meta.page))
    {
        return next('/pokemons');
    }

    if (to.path === '/') return next('/pokemons');

    return next();
});

export default router;
