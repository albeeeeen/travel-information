<template>
  <div class="container">
    <h3>{{ useDestination.currentLocation }} Destinations</h3>
    <div class="content-wrapper">
      <div class="filter-section">
        <div class="autocomplete-container" ref="autocompleteContainer">
          <input type="text" v-model="searchQuery" @input="filterCategories" @click="toggleDropdown" @blur="handleBlur" placeholder="Search categories">
          <div class="category-dropdown" v-if="showDropdown" @mousedown="preventBlur">
            <div v-for="(category, value) in filteredCategories" :key="value" @click="selectCategory(value)">
              {{ category }}
            </div>
          </div>
          <div class="selected-categories">
            <div v-for="(category, index) in this.useDestination.selectedCategories" :key="index">
              <span>{{ useDestination.categories[category] }}</span>
              <span class="remove-category" @click="removeCategory(index)">&times</span>
            </div>
          </div>
        </div>
        <button @click="search">Search</button>
      </div>
      <div class="map-container" ref="myMap">

      </div>
    </div>
  </div>
  <!-- Modal -->
  <div class="modal" v-if="showModal">
    <div class="modal-content">
      <span class="close" @click="closeModal">&times;</span>
      <h2>Location Details</h2>
      <div class="details">
        <!-- Location Name and Image -->
        <div class="location-name">
          <span>{{ this.getDestinationName(useDestination.placeDetailData.formatted ?? useDestination.placeDetailData.name) }}</span>
          <img v-if="useDestination.placeDetailData?.wiki_and_media?.image" :src="useDestination.placeDetailData.wiki_and_media.image" alt="Location Image" />
        </div>
        <!-- Address -->
        <div class="address">
          <strong>Address:</strong> {{ this.getDestinationAddress(useDestination.placeDetailData.formatted ?? useDestination.placeDetailData.address_line2 ?? 'N/A') }}
        </div>
        <!-- Description -->
        <div class="description">
          <strong>Description:</strong> {{ useDestination.placeDetailData.description ?? 'N/A' }}
        </div>
        <!-- Opening Hours -->
        <div class="opening-hours" v-if="useDestination.placeDetailData?.opening_hours">
          <strong>Opening Hours:</strong> {{ useDestination.placeDetailData.opening_hours ?? 'N/A' }}
        </div>
        <!-- Contact -->
        <div class="contact" v-if="useDestination.placeDetailData?.contact">
          <strong>Contact:</strong> {{ useDestination.placeDetailData.contact.phone ?? 'N/A' }}
        </div>
        <!-- Fee -->
        <div class="amenities" v-if="useDestination.placeDetailData.datasource.raw?.fee === 'yes'">
          <strong>Fee:</strong>
          <span class="check-icon">&#10004;</span>
        </div>
        <!-- Amenities -->
        <div class="amenities" v-if="useDestination.placeDetailData?.facilities">
          <strong>Facilities:</strong>
          <ul>
            <li v-for="amenity in filteredFacilities" :key="amenity">
              <span class="check-icon">&#10004;</span> {{ this.facilities[amenity] }}
            </li>
          </ul>
        </div>
        <!-- Rating -->
        <div class="rating" v-if="useDestination.placeDetailData?.accommodation">
          <strong>Rating:</strong> {{ useDestination.placeDetailData.accommodation.stars }}
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import maplibregl from 'maplibre-gl';
import {useDestinationStore} from "../../stores/DestinationStore";
import { Map, NavigationControl, Popup, Marker } from 'https://cdn.skypack.dev/maplibre-gl';

export default {
  name: 'Destination',
  data() {
    return {
      searchQuery: '',
      showDropdown: false,
      useDestination: useDestinationStore(),
      markers: [],
      myAPIKey: import.meta.env.VITE_PLACES_API_KEY,
      map: null,
      showModal: false,
      facilities: {
        'wheelchair': 'Wheelchair',
        'internet_access': 'Has Internet Connection',
        'smoking': 'Smoking permitted',
        'toilets': 'Toilets available',
        'swimming_pool': 'Swimming pool',
        'dogs': 'Dogs allowed',
        'air_conditioning': 'Air-conditioned',
        'changing_table': 'Changing table for babies',
        'outdoor_seating': 'Outdoor seating area',
        'takeaway': 'Takeaway available',
        'takeaway_covid19': 'Takeaway available',
        'delivery': 'Location available for delivery',
        'delivery_covid19': 'Location available for delivery'
      }
    };
  },
  computed: {
    filteredCategories() {
      const filtered = {};
      for (const [key, value] of Object.entries(this.useDestination.categories)) {
        if (key.includes(this.searchQuery)) {
          filtered[key] = value;
        }
      }
      return filtered;
    },
    filteredFacilities() {
      return Object.keys(this.useDestination.placeDetailData.facilities).filter(key => typeof this.useDestination.placeDetailData.facilities[key] === 'boolean');
    }
  },
  mounted() {
    this.useDestination.selectedCategories = [];
    this.getUrlParameter('loc');
    this.handleMap();
    document.addEventListener('click', this.handleClick);
  },
  beforeUnmount() {
    document.removeEventListener('click', this.handleClick);
  },
  methods: {
    filterCategories() {
      this.showDropdown = true;
    },
    selectCategory(category) {
      if (!this.useDestination.selectedCategories.includes(category)) {
        this.useDestination.selectedCategories.push(category);
      }
      this.searchQuery = '';
      this.showDropdown = false;
    },
    removeCategory(index) {
      this.useDestination.selectedCategories.splice(index, 1);
    },
    search() {
      if (this.useDestination.selectedCategories.length === 0) {
        alert('Please select category first');
      } else {
        this.requestPlaceGeoPoints();
      }
    },
    toggleDropdown() {
      this.showDropdown = true;
    },
    getUrlParameter() {
      this.useDestination.currentLocation = this.$route.query.loc;
    },
    handleBlur() {
      setTimeout(() => {
        if (!this.$refs.autocompleteContainer.contains(document.activeElement)) {
          this.showDropdown = false;
        }
      }, 200);
    },
    preventBlur(event) {
      event.preventDefault();
    },
    initializeMap() {
      const mapStyle = 'https://maps.geoapify.com/v1/styles/osm-carto/style.json';

      this.map = new maplibregl.Map({
        container: this.$refs.myMap,
        style: `${mapStyle}?apiKey=${this.myAPIKey}`,
        center: [this.useDestination.initialLong, this.useDestination.initialLat],
        zoom: 11
      });

      const markerPopup = new maplibregl.Popup().setHTML(this.createInitialPopup(this.useDestination.geocodeData));
      const marker = new maplibregl.Marker().setLngLat([this.useDestination.initialLong, this.useDestination.initialLat]).setPopup(markerPopup).addTo(this.map);
      const newMap = this.map;
      marker.getElement().addEventListener('mouseenter', function() {
        newMap.getCanvasContainer().style.cursor = 'pointer';
      });

      marker.getElement().addEventListener('mouseleave', function() {
        newMap.getCanvasContainer().style.cursor = '';
      });
    },
    async handleMap() {
      await this.useDestination.fetchGeoCode();
      await this.initializeMap();
    },
    createInitialPopup(geocode) {
      return '<div style="font-size: 14px; font-weight: bold">' + geocode.city + '</div>' +
        '<div>' + geocode.country + '</div>' +
        '<div> <span style="font-size: 14px; font-weight: bold">Location Type: </span> <span>' + geocode.result_type.charAt(0).toUpperCase() + geocode.result_type.slice(1) + '</span></div> ' +
        '<div> <span style="font-size: 14px; font-weight: bold">Confidence: </span> <span>' + (geocode.rank.confidence * 100 ) + '%' + '</span> </div>';
    },
    createDestinationsPopup(destination) {
      let html = '<div style="font-size: 14px; font-weight: bold">' + this.getDestinationName(destination.formatted ?? destination.name) + '</div>' +
         '<div style="font-size: 12px; font-weight: 400;font-family: Roboto, sans-serif; color: #0009">' + this.getDestinationAddress(destination.formatted ?? destination.address_line2 ?? 'N/A') + '</div>' +
         '<ul style="margin-top: 10px">';
      destination.categories.forEach(item => {
          if (this.useDestination.categories[item]) {
              html += '<li>' + this.useDestination.categories[item] + '</li>';
          }
      });
      html += '</ul>' + 
              '<a class="learn-more" data-place-id=' + destination.place_id + ' style="cursor: pointer; color: blue; text-decoration: underline;">Learn More</a>';
      return html;
    },
    getDestinationName(formatted) {
      return formatted.split(',')[0].trim();
    },
    getDestinationAddress(formatted) {
      return formatted.split(',').slice(1).join(',').trim();
    },
    showGeoJSONPoints(geojson) {
      if (this.markers.length) {
        this.markers.forEach(marker => marker.remove());
        this.markers = [];
      }

      // each feature contains 1 place
      if (!geojson.error) {
        geojson.features.forEach((feature, index) => {
          var markerIcon = document.createElement('div');
          markerIcon.classList.add("my-marker");
          // Icon size: 31 x 46px, shadow adds: 4px
          markerIcon.style.backgroundImage = `url(https://api.geoapify.com/v1/icon/?type=material&color=%23f30606&iconType=awesome&apiKey=${this.myAPIKey})`;

          var popup = new Popup({
              anchor: 'bottom',
              offset: [0, -42] // height - shadow
            })
            .setHTML(this.createDestinationsPopup(feature.properties));

          var marker = new Marker(markerIcon, {
              anchor: 'bottom',
              offset: [0, 4] // shadow
            })
            .setLngLat(feature.geometry.coordinates)
            .setPopup(popup)
            .addTo(this.map);
          const newMap = this.map;
          marker.getElement().addEventListener('mouseenter', function() {
            newMap.getCanvasContainer().style.cursor = 'pointer';
          });

          marker.getElement().addEventListener('mouseleave', function() {
            newMap.getCanvasContainer().style.cursor = '';
          });

          this.markers.push(marker);
        });
      }
    },
    requestPlaceGeoPoints() {
      let placesUrl = import.meta.env.VITE_PLACES_API_URL_V2 + '/places';
      let queryParameter = {
        'categories': this.useDestination.selectedCategories,
        'filter': 'place:' + this.useDestination.placeId,
        'limit': import.meta.env.VITE_PLACES_API_LIMIT,
        'apiKey': import.meta.env.VITE_PLACES_API_KEY
      }

      fetch(placesUrl + '?' + this.convertToQueryParam(queryParameter)).then(response => response.json()).then(places => {
        this.showGeoJSONPoints(places);
      });
      
    },
    convertToQueryParam(obj) {
      return Object.entries(obj)
        .map(([key, value]) => {
          if (Array.isArray(value)) {
            return `${encodeURIComponent(key)}=${value.map(v => encodeURIComponent(v)).join(',')}`;
          } else {
            return `${encodeURIComponent(key)}=${encodeURIComponent(value)}`;
          }
        })
        .join('&');
    },
    async handleClick(event) {

      if (event.target.classList.contains('learn-more')) {
        this.showModal = true;
        this.useDestination.placeId = event.target.getAttribute('data-place-id');
        await this.useDestination.fetchPlaceDetails();
      }

    },
    closeModal() {
      this.showModal = false;
    }
  }
};
</script>

<style scoped>

.container {
  display: flex;
  flex-direction: column;
  height: 90vh;
}
h3 {
  padding: 10px;
}
.content-wrapper {
  display: flex;
  flex-direction: row;
  flex-grow: 1;
}
.filter-section {
  width: 400px;
  padding: 0 10px 10px 10px;
}
.autocomplete-container {
  position: relative;
}
input[type="text"] {
  width: 100%;
  padding: 8px;
}
.category-dropdown {
  position: absolute;
  left: 0;
  width: 100%;
  background-color: #fff;
  border: 1px solid #ccc;
  z-index: 10;
  max-height: 50vh;
  overflow-y: scroll;
}
.category-dropdown div {
  padding: 8px;
  cursor: pointer;
}
.selected-categories {
  display: flex;
  flex-wrap: wrap;
  margin-top: 5px;
}
.selected-categories div {
  background-color: #f2f2f2;
  padding: 5px 8px;
  margin-right: 5px;
  margin-bottom: 5px;
  display: flex;
  align-items: center;
}
.remove-category {
  margin-left: 5px;
  cursor: pointer;
}
button {
  margin-top: 10px;
  padding: 8px 16px;
  background-color: #007bff;
  color: #fff;
  border: none;
  cursor: pointer;
}
.map-container {
  flex-grow: 1; /* Allow the map container to grow and fill the remaining space */
  width: 100%;
}

.modal {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent black overlay */
  z-index: 1000; /* Ensure the modal appears above other elements */
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  height: 100%;
}

.modal-content {
  background-color: #fefefe;
  margin: 5% auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
  max-width: 600px; 
}

.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
  position: absolute;
  top: 8px; /* Adjust top and right values as needed */
  right: 11px; /* Align close button to the top-right corner */
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}

.details {
  margin-top: 20px;
}

.location-name {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.location-name span {
  font-size: 17px;
  font-weight: 500;
}

.location-name img {
  max-width: 100px; /* Adjust image size as needed */
}

.amenities ul {
  list-style-type: none;
  padding-left: 0;
}

.check-icon {
  margin-left: 5px;
  margin-right: 5px;
}

@media (max-width: 767px) {
  .content-wrapper {
    flex-direction: column;
  }

  .filter-section {
    order: 1;
    width: 100%;
  }

  .map-container {
    order: 2;
    height: 70vh;
  }
  
  button, .selected-categories div, .autocomplete-container {
    font-size: .7rem;
  }
  .modal-content {
    width: 90%;
    margin: 10% auto;
  }
}
</style>
