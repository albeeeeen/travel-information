import {defineStore} from "pinia";
import moment from 'moment';

export const useWeatherStore = defineStore('WeatherStore', {
    state: () => {
        return {
            currentLocation: '',
            locationName: 'Tokyo',
            temperature: '25°C',
            weatherIconUrl: import.meta.env.VITE_WEATHER_ICON_URL,
            weatherIcon: '',
            weatherDetails: [],
            forecastTimes: ['Morning', 'Noon', 'Midday', 'Evening'],
            todayForecast: {
                Morning: { temperature: '20°C', icon: 'fa-solid fa-cloud-sun fa-xl', condition: 'Sunny' },
                Noon: { temperature: '25°C', icon: 'fa-solid fa-sun fa-xl', condition: 'Partly Cloudy' },
                Midday: { temperature: '28°C', icon: 'fa-solid fa-cloud fa-xl', condition: 'Cloudy' },
                Evening: { temperature: '22°C', icon: 'fa-solid fa-moon fa-xl', condition: 'Rainy' }
            },
            forecastDays: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
            fiveDayForecast: [],
            fiveDayForecastTimezone: 0
        }
    },
    actions: {
        async fetchCurrentWeather() {
            console.log(this.currentLocation);
            await axios.get('/api/weather/' + this.currentLocation)
                    .then(response => {
                        let weatherData = response.data['data'];
                        this.locationName = weatherData['name'];
                        this.temperature = weatherData['main']['temp'] + '°C';
                        this.weatherIcon = weatherData['weather'][0]['icon'];
                        
                        this.weatherDetails = [ 
                            { name: 'Condition', icon: 'fa-solid fa-sun', value: weatherData['weather'][0]['main'] },
                            { name: 'Wind Speed', icon: 'fa-solid fa-wind', value: weatherData['wind']['speed'] + ' m/s' },
                            { name: 'Humidity', icon: 'fa-solid fa-cloud-sun', value: weatherData['main']['humidity'] + '%' },
                            { name: 'Visibility', icon: 'fa-solid fa-eye', value: (weatherData['visibility'] / 1000).toFixed(2) + ' km' },
                            { name: 'Feels Like', icon: 'fa-solid fa-temperature-high', value: weatherData['main']['feels_like'] + '°C' },
                            { name: 'Pressure', icon: 'fa-solid fa-gauge', value: weatherData['main']['pressure'] + ' hPa' },
                            { name: 'Sunrise', icon: 'fa-solid fa-cloud-sun', value: this.convertToLocalDateTime(weatherData['sys']['sunrise'], weatherData['timezone']).format('hh:mm A') },
                            { name: 'Sunset', icon: 'fa-solid fa-cloud-sun', value: this.convertToLocalDateTime(weatherData['sys']['sunset'], weatherData['timezone']).format('hh:mm A') }
                        ]
                    })
                    .catch(error => {
                        console.log(error);
                    })
        },
        convertToLocalDateTime(timestamp, timezone) {
            let utcDateTime = moment.unix(timestamp);
            return utcDateTime.utcOffset(timezone / 60);
        },
        convertToDayTime(localDateTime) {
            return localDateTime.format('dddd - hh:mm A');
        },
        async fetch5DayForecast() {
            await axios.get('/api/forecast/' + this.currentLocation)
                    .then(response => {
                        this.fiveDayForecastTimezone = response.data['data']['city']['timezone'];
                        this.fiveDayForecast = response.data['data']['list'];
                    })
                    .catch(error => {
                        console.log(error);
                    }) 
        }
    }
});