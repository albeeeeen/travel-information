<template>
  <div class="five-day-forecast">
    <h3>5-Day Forecast</h3>
    <div class="table-wrapper">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">Day and Time</th>
            <th scope="col">Temperature</th>
            <th scope="col">Condition</th>
            <th scope="col">Wind Speed</th>
            <th scope="col">Rain Probability</th>
            <th scope="col">Visibility</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(forecast, index) in forecasts" :key="index">
            <td>{{ useWeather.convertToDayTime(useWeather.convertToLocalDateTime(forecast.dt, timezone)) }}</td>
            <td>
              <div class="temperature-wrapper">
                <img :src="this.useWeather.weatherIconUrl + '/' + forecast.weather[0].icon + '.png'"></img>
                {{ forecast.main.temp + '°C' }}
              </div>
            </td>
            <td>{{ forecast.weather[0].main }}</td>
            <td>{{ forecast.wind.speed + 'm/s'}}</td>
            <td>{{ (forecast.pop * 100).toFixed(2) + '%' }}</td>
            <td>{{ (forecast.visibility / 1000).toFixed(2) + ' km' }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import {useWeatherStore} from "../../stores/WeatherStore";

export default {
  name: 'FiveDateForecast',
  data() {
    return {
      useWeather: useWeatherStore()
    }
  },
  props: {
    forecasts: Array,
    timezone: Number
  }
}
</script>

<style scoped>

.table-wrapper {
  max-height: 600px;
  overflow-y: auto;
}

.table {
  --bs-table-bg: #cfe3ff !important;
  border-radius: 5px !important;
  width: 100%;
}

.five-day-forecast {
  margin-bottom: 20px;
}

.temperature-icon {
  width: 20px;
  height: 20px;
  margin-right: 5px;
}

.table th,
.table td {
  vertical-align: middle;
  text-align: center;
}

.temperature-wrapper {
  display: flex;
  align-items: center;
}

@media (max-width: 767px) {
  .table th,
  .table td {
    font-size: 14px;
  }
  .table-wrapper {
    overflow-x: auto;
  }
}

</style>