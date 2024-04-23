<template>
  <div class="container">
    <!-- Main container -->
    <div class="row">
      <!-- Left container for current weather -->
      <div class="col-md-6">
        <div class="current-weather">
            <div class="weather-header">
                <div class="location-info">
                    <h1>{{ locationName }}</h1>
                    <div class="temperature">{{ temperature }}</div>
                </div>
                <i class="fa-solid fa-cloud-sun fa-4x"></i>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="weather-details">
                        <!-- First column of weather details -->
                        <div v-for="(detail, index) in weatherDetails.slice(0, Math.ceil(weatherDetails.length / 2))" :key="index" class="weather-detail">
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
                        <div v-for="(detail, index) in weatherDetails.slice(Math.ceil(weatherDetails.length / 2))" :key="index" class="weather-detail">
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
          <!-- Today's forecast -->
          <div class="today-forecast">
            <TodaysForecast :forecastTimes="forecastTimes" :forecasts="todayForecast" />
          </div>
          <!-- 7-day forecast -->
          <div class="seven-day-forecast">
            <SevenDayForecast :forecastDays="forecastDays" :forecasts="sevenDayForecast" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import TodaysForecast from './TodaysForecast.vue';
import SevenDayForecast from './SevenDayForecast.vue';

export default {
  name: 'WeatherInfo',
  components: {
    TodaysForecast,
    SevenDayForecast
  },
  data() {
    return {
      locationName: 'Tokyo',
      temperature: '25°C',
      currentWeather: 'Sunny',
      weatherIcon: 'path/to/sunny-icon.png',
      weatherDetails: [
        { name: 'UV Index', icon: 'fa-solid fa-sun', value: 'High' },
        { name: 'Wind Speed', icon: 'fa-solid fa-wind', value: '10 km/h' },
        { name: 'Humidity', icon: 'fa-solid fa-cloud-sun', value: '50%' },
        { name: 'Visibility', icon: 'fa-solid fa-eye', value: '10 km' },
        { name: 'Feels Like', icon: 'fa-solid fa-temperature-high', value: '28°C' },
        { name: 'Chance of Rain', icon: 'fa-solid fa-cloud-rain', value: '20%' },
        { name: 'Pressure', icon: 'fa-solid fa-gauge', value: '1013 hPa' },
        { name: 'Sunset', icon: 'fa-solid fa-cloud-sun', value: '6:30 PM' }
      ],
      forecastTimes: ['Morning', 'Noon', 'Midday', 'Evening'],
      todayForecast: {
        Morning: { temperature: '20°C', icon: 'fa-solid fa-cloud-sun fa-xl', condition: 'Sunny' },
        Noon: { temperature: '25°C', icon: 'fa-solid fa-sun fa-xl', condition: 'Partly Cloudy' },
        Midday: { temperature: '28°C', icon: 'fa-solid fa-cloud fa-xl', condition: 'Cloudy' },
        Evening: { temperature: '22°C', icon: 'fa-solid fa-moon fa-xl', condition: 'Rainy' }
      },
      forecastDays: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
      sevenDayForecast: {
        Monday: { temperature: '25°C', icon: 'fa-solid fa-cloud-sun', condition: 'Sunny' },
        Tuesday: { temperature: '23°C', icon: 'fa-solid fa-smog', condition: 'Partly Cloudy' },
        Wednesday: { temperature: '22°C', icon: 'fa-solid fa-cloud', condition: 'Cloudy' },
        Thursday: { temperature: '24°C', icon: 'fa-solid fa-cloud-showers-heavy', condition: 'Rainy' },
        Friday: { temperature: '26°C', icon: 'fa-solid fa-cloud-sun', condition: 'Sunny' },
        Saturday: { temperature: '28°C', icon: 'fa-solid fa-smog', condition: 'Partly Cloudy' },
        Sunday: { temperature: '27°C', icon: 'fa-solid fa-cloud', condition: 'Cloudy' }
      }
    };
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

.weather-details {
  margin-top: 20px;
}

.weather-detail {
  display: flex;
  align-items: center;
  margin-bottom: 10px;
  background: #f2f2f2;
  border-radius: 5px;
}

.detail-text {
  padding: 10px 0 0 20px;
}

.detail-value {
  padding-left: 30px;
}

.forecast {
  margin-top: 20px;
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
}
</style>