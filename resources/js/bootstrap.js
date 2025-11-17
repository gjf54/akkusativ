import axios from 'axios';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
import App from './App.vue';
import router from './router';
import { createApp } from 'vue';
import components from './components';
import auth from './auth';
import { configureEcho } from '@laravel/echo-vue';

window.axios = axios;
window.axios.defaults.baseURL = 'https://akkusativ.ru';
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common['Accept'] = 'application/json';
window.axios.defaults.withCredentials = true;
window.axios.defaults.withXSRFToken = true;

window.axios.interceptors.response.use(
    response => {
        return Promise.resolve(response);
    },
    error => {
        const { status, data } = error.response;

        if(status == 401) {
            auth.unset_auth_status();
        }

        if (status === 403) {
            router.push({name: 'error.403'});
        }
        if (status === 404) {
            router.push({name: 'error.404'});
        }
        return Promise.reject(error);
    }
);

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    auth: {
        headers: {
            // Authorization: 'Bearer 8|ZDjlEm3PBBKufcsV3iwrT1VfihmUkC9hXKyG2uwj03966de4',
            Accept: 'application/json',
        },
    },
});


// configureEcho({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
//     auth: {
//         headers: {
//             Authorization: 'Bearer ' + YourTokenLogin
//         },
//     },
// })


let app = createApp(App);
app.use(router);

components.forEach(c => {
    app.component(c.name, c);
});

app.mount('#app');
