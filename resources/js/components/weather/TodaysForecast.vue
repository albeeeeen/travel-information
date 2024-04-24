<template>
  <div class="today-forecast">
    <h3>Today's Forecast</h3>
    <div class="forecast-cards">
      <div v-for="time in forecastTimes" :key="time" class="forecast-card">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">
              {{ time }}
              <i :class="forecasts[time].icon"></i>
            </h5>
            <p class="card-text">
              Temperature: {{ forecasts[time].temperature }}
            </p>
            <p class="card-text">Condition: {{ forecasts[time].condition }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'TodaysForecast',
  props: {
    forecastTimes: Array,
    forecasts: Object
  }
}
</script>

<style scoped>
/* Add custom styles */
.today-forecast {
  margin-bottom: 20px;
}

.forecast-cards {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
}

.forecast-card {
  flex: 0 0 calc(50% - 10px);
  margin-bottom: 10px;
}

.card {
  border: none;
  background: #f2f2f2;
}

.card-title {
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.weather-icon {
  width: 50px;
  height: 50px;
  margin-left: auto;
}

@media (max-width: 768px) {
  .forecast-card {
    flex: 0 0 100%; /* Set card width to full width on smaller screens */
  }
}
</style>