import {defineStore} from "pinia";
import categories from "../categories.js";

export const useDestinationStore = defineStore('DestinationStore', {
    state: () => {
        return {
            destinationData: null,
            currentLocation: '',
            placeId: '',
            initialLat: 0,
            initialLong: 0,
            categories: categories,
            selectedCategories: [],
            geocodeData: null,
            placeDetailData: null
        }
    },
    actions: {
        async fetchGeoCode() {
            await axios.get('/api/geocode/' + this.currentLocation)
                .then(response => {
                    this.geocodeData = response.data['data'][0];
                    this.initialLat = this.geocodeData.lat;
                    this.initialLong = this.geocodeData.lon;
                    this.placeId = this.geocodeData.place_id;
                })
                .catch(error => {
                    console.log(error);
                })
        },
        async fetchPlaceDetails() {
            await axios.get('/api/place/' + this.placeId)
                .then(response => {
                    this.placeDetailData = response.data.data.features[0].properties;
                })
                .catch(error => {
                    console.log(error);
                })
        }
    }
});