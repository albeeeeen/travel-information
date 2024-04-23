import { createRouter, createWebHashHistory } from "vue-router";


import home from './components/Home.vue';
import weather from './components/weather/Weather.vue';

const router = createRouter({
    history: createWebHashHistory(),
    routes: [
        { path: '/', name: 'Home', component: home },
        { path: '/weather', name: 'Weather', component: weather }
    ]
});

export default router;