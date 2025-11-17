import { createRouter, createWebHistory } from 'vue-router';
import Home from '../views/Home.vue';
import Auth from '../views/auth/Auth.vue';
import AuthLogin from '../views/auth/AuthLogin.vue';
import AuthRegistration from '../views/auth/AuthRegistration.vue';
import About from '../views/About.vue';
import E404 from '../views/errors/E404.vue';
import auth from '../auth';
import Messenger from '../views/messenger/Messenger.vue';
import ChatBars from '../views/messenger/ChatBars.vue'; 
import Chat from '../views/messenger/Chat.vue';
import E403 from '../views/errors/E403.vue';


const p = [
    {
        path: '/',
        name: 'home',
        component: Home,
    },
    {
        path: '/about',
        name: 'about',
        component: E403,
    },
    {
        path: '/auth',
        component: Auth,
        meta: {
            middleware: ['guest'],
        },
        children: [
            {
                path: 'login',
                name: 'auth.login',
                component: AuthLogin,
            },
            {
                path: 'registration',
                name: 'auth.registration',
                component: AuthRegistration,
            },
        ],
    },
    {
        path: '/messenger',
        component: Messenger,
        meta: {
            middleware: ['auth'],
        },
        children: [
            {
                path: 'chats',
                name: 'messenger',
                component: ChatBars,
            },
            {
                path: 'chats/:id',
                name: 'messenger.chat',
                props: true,
                component: Chat,
            }
        ],
    },
    {
      path: '/access-denied',
      name: 'error.403',
      component: E403,
    },
    {
      path: '/not-found',
      name: 'error.404',
      component: E404,
    },
    {
      path: '/:pathMatch(.*)*',
      component: E404,
    },
];

const router = createRouter({
    routes: p,
    history: createWebHistory(),
});


router.beforeEach((to, from, next) => {
    if(Object.keys(to.meta).length > 0) {

        if(to.meta.middleware) {
        
            // Auth middleware

            if(to.meta.middleware.includes('auth')) {
                let s = auth.request_auth_status()
                .then(() => {next()})
                .catch(() => {next({name: 'auth.login'})});
            }

            // Guest middleware

            if(to.meta.middleware.includes('guest')) {
                let s = auth.request_auth_status()
                .then(() => next({name: 'messenger'}))
                .catch(() => next());
            }
        } 

    } else {
        next();
    }
});


export default router;