import { createApp } from 'vue';
import App from './App.vue';
import router from './router/index.js';
import '../css/app.css';
import axios from 'axios';

const app = createApp(App);

const hasBearerToken = axios.defaults.headers.common.Authorization !== undefined;

const hasLocalToken = localStorage.getItem('token') !== null;

if (!hasBearerToken && hasLocalToken)
{
    axios.defaults.headers.common.Authorization = `Bearer ${localStorage.getItem('token')}`;
}

app.use(router);

app.mount('#app');
