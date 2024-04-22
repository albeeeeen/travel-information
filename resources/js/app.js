import './bootstrap';
import { createApp } from 'vue';
import router from './router.js';
import appVue from './components/App.vue';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import { createPinia } from "pinia";

const app = createApp(appVue);

app.use(router);
app.use(createPinia());

app.mount('#app');