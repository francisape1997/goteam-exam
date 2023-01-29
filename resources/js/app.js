import { createApp } from 'vue';
import App from './App.vue';
import router from './router/index.js';
import '../css/app.css';
import axios from 'axios';

import { library } from '@fortawesome/fontawesome-svg-core';
import { fas } from '@fortawesome/free-solid-svg-icons';
import { far } from '@fortawesome/free-regular-svg-icons';
import { fab } from '@fortawesome/free-brands-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

library.add(fas, far, fab)

const app = createApp(App);

const hasBearerToken = axios.defaults.headers.common.Authorization !== undefined;

const hasLocalToken = localStorage.getItem('token') !== null;

if (!hasBearerToken && hasLocalToken)
{
    axios.defaults.headers.common.Authorization = `Bearer ${localStorage.getItem('token')}`;
}

app.use(router);

app.component('font-awesome-icon', FontAwesomeIcon);

app.mount('#app');
