<!-- Navbar.vue -->
<template>
  <nav class="navbar navbar-expand-lg" style="background: #f5f5dc">
    <div class="container">
      <a class="navbar-brand" href="#">Travel Information</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Weather</a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <li v-for="(locWeather, index) in weatherList" 
                    :key="index"
                    @click.prevent="this.verifySelected(locWeather)">
                <router-link :class="{active: this.selected === locWeather.loc }" class="dropdown-item" :to="'/weather?loc=' + locWeather.loc">{{ locWeather.label }}</router-link>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/">Destinations</router-link>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script>
import {useWeatherStore} from "../stores/WeatherStore";

export default {
    data() {
        return {
            selected: '/',
            useWeather: useWeatherStore(),
            weatherList: [
                {
                    label: 'Tokyo',
                    loc: 'tokyo'
                },
                {
                    label: 'Yokohama',
                    loc: 'yokohama'
                },
                {
                    label: 'Kyoto',
                    loc: 'kyoto'
                },
                {
                    label: 'Osaka',
                    loc: 'osaka'
                },
                {
                    label: 'Sapporo',
                    loc: 'sapporo'
                },
                {
                    label: 'Nagoya',
                    loc: 'nagoya'
                },
            ]
        };
    },
    methods: {
        verifySelected(locWeather) {
            this.selected = locWeather.loc;
        }
    },
    watch: {
        $route: {
            handler: function (routeValue) {
                this.selected = (routeValue.query.loc !== null || routeValue.query.loc !== undefined) ? routeValue.query.loc : '';
                this.useWeather.currentLocation = this.selected;
            }
        }
    }
}
</script>