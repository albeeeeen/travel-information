import { createRouter, createWebHashHistory } from "vue-router";


import home from './components/Home.vue';
import weather from './components/weather/Weather.vue';
import destination from './components/destination/Destination.vue';

const router = createRouter({
    history: createWebHashHistory(),
    routes: [
        { path: '/', name: 'Home', component: home },
        { path: '/weather', name: 'Weather', component: weather },
        { path: '/destinations', name: 'Destination', component: destination }
    ]
});

export default router;