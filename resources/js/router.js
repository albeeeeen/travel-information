import { createRouter, createWebHistory } from "vue-router";


import home from './components/Home.vue';
import weather from './components/weather/Weather.vue';

const routes = [
    { path: '/', name: 'Home', component: home },
    { path: '/weather', name: 'Weather', component: weather }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;