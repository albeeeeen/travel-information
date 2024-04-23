<template>
  <div class="seven-day-forecast">
    <h3>7-Day Forecast</h3>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">Day</th>
          <th scope="col">Temperature</th>
          <th scope="col">Condition</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="day in forecastDays" :key="day">
          <td>{{ day }}</td>
          <td>
            <i :class="forecasts[day].icon"></i>
            {{ forecasts[day].temperature }}
          </td>
          <td>{{ forecasts[day].condition }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  name: 'SevenDayForecast',
  props: {
    forecastDays: Array,
    forecasts: Object
  }
}
</script>

<style scoped>

.table {
  --bs-table-bg: #f2f2f2 !important;
  border-radius: 5px !important;
}

.seven-day-forecast {
  margin-bottom: 20px;
}

.temperature-icon {
  width: 20px;
  height: 20px;
  margin-right: 5px;
}

</style>