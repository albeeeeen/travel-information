<template>
<div class="container">
  <!-- Main container -->
  <div class="row">
    <!-- Left container for current weather -->
    <div class="col-md-6">
      <div class="current-weather">
          <div class="weather-header">
              <div class="location-info">
                  <h1>{{ useWeather.locationName }}</h1>
                  <div class="temperature">{{ useWeather.temperature }}</div>
              </div>
              <img class="weather-icon" :src="this.useWeather.weatherIconUrl + '/' + this.useWeather.weatherIcon + '.png'"></img>
          </div>
          <div class="row">
              <div class="col-6">
                  <div class="weather-details">
                      <!-- First column of weather details -->
                      <div v-for="(detail, index) in this.useWeather.weatherDetails.slice(0, Math.ceil(this.useWeather.weatherDetails.length / 2))" :key="index" class="weather-detail">
                          <div class="detail-text">
                              <h6>
                                  <i :class="detail.icon"></i>
                                  {{ detail.name }}
                              </h6>
                              <h5 class="detail-value">{{ detail.value }}</h5>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="col-6">
                  <div class="weather-details">
                      <!-- Second column of weather details -->
                      <div v-for="(detail, index) in this.useWeather.weatherDetails.slice(Math.ceil(this.useWeather.weatherDetails.length / 2))" :key="index" class="weather-detail">
                          <div class="detail-text">
                              <h6>
                                  <i :class="detail.icon"></i>
                                  {{ detail.name }}
                              </h6>
                              <h5 class="detail-value">{{ detail.value }}</h5>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
    </div>
    <!-- Right container for forecast -->
    <div class="col-md-6">
      <div class="forecast">
        <!-- 5-day forecast -->
        <div class="five-day-forecast">
          <FiveDayForecast :forecasts="this.useWeather.fiveDayForecast" :timezone="this.useWeather.fiveDayForecastTimezone" />
        </div>
      </div>
    </div>
  </div>
</div>
</template>

<script>
import TodaysForecast from './TodaysForecast.vue';
import FiveDayForecast from './FiveDayForecast.vue';
import {useWeatherStore} from "../../stores/WeatherStore";

export default {
  name: 'WeatherInfo',
  components: {
    TodaysForecast,
    FiveDayForecast
  },
  data() {
    return {
      useWeather: useWeatherStore()
    };
  },
  watch: {
    'useWeather.currentLocation'() {
      this.handleChangeLocation();
    }
  },
  methods: {
    async handleChangeLocation() {
      await this.useWeather.fetchCurrentWeather();
      await this.useWeather.fetch5DayForecast();
    }
  },
  mounted() {
    this.handleChangeLocation();
  }
}
</script>

<style scoped>

.container {
    margin-top: 1rem;
}

.weather-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 10px 0 0 20px;
  border-radius: .5rem;
  background: #cfe3ff;
}

.location-info {
  display: flex;
  flex-direction: column;
}

.temperature {
  margin-bottom: 5px;
}

.temperature {
  font-size: 5rem;
  font-weight: bold;
}

.weather-icon {
  width: 200px;
  height: 200px;
  object-fit: contain;
}

.weather-details {
  margin-top: 20px;
}

.weather-detail {
  display: flex;
  align-items: center;
  margin-bottom: 10px;
  background: #cfe3ff;
  border-radius: 5px;
}

.detail-text {
  padding: 10px 0 0 20px;
}

.detail-value {
  padding-left: 30px;
}

.forecast h3 {
  margin-bottom: 10px;
}

.forecast-time,
.forecast-day {
  margin-bottom: 20px;
}

/* Adjustments for small devices */
@media (max-width: 767px) {
  .weather-info {
    flex-direction: column;
    align-items: flex-start;
  }
  .weather-icon {
    width: 100px;
    height: 100px;
    object-fit: contain;
  }
  .temperature {
    font-size: 3rem;
    font-weight: bold;
  }
}
</style>