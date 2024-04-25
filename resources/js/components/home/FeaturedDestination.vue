<!-- FeaturedDestinations.vue -->
<template>
  <div class="featured-destinations">
    <h2>Featured Destinations</h2>
    <div class="destination-images">
      <ul class="destination-list">
        <li v-for="destination in destinations" :key="destination.name" class="destination">
          <div class="destination-info">
            <router-link :to="'/destinations?loc=' + destination.name">
              <img :src="destination.image" :alt="destination.name">
              <p class="destination-name"> {{ destination.name }} </p>
            </router-link>
          </div>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  name: 'FeaturedDestinations',
  data() {
    return {
      destinations: [
        { name: 'Tokyo', image: '/img/tokyo-image.jpg', link: 'tokyo' },
        { name: 'Yokohama', image: '/img/yokohama-image.jpg', link: 'yokohama'  },
        { name: 'Kyoto', image: '/img/kyoto-image.jpg', link: 'kyoto'  },
        { name: 'Osaka', image: '/img/osaka-image.jpg', link: 'osaka'  },
        { name: 'Sapporo', image: '/img/sapporo-image.jpg', link: 'sapporo'  },
        { name: 'Nagoya', image: '/img/nagoya-image.jpg', link: 'nagoya'  }
      ]
    };
  }
}
</script>

<style scoped>
.featured-destinations {
  margin-top: 50px;
  text-align: center;
}

.featured-destinations h2 {
  font-size: 2rem;
  margin-bottom: 20px;
}

.destination-images {
  display: flex;
  justify-content: center;
}

.destination-list {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  padding: 0;
  list-style: none;
}

.destination {
  margin: 0 10px;
}

.destination-info {
  text-align: center;
}

.destination-info img {
  width: 150px;
  height: 150px;
  object-fit: cover;
  border-radius: 50%;
}

.destination-name {
  display: block;
  margin-top: 5px;
  font-size: 1.1rem;
  font-weight: bold;
}

@media (max-width: 767px) {
  .featured-destinations {
    margin-top: 20px;
  }
  .featured-destinations h2 {
    font-size: 1.5rem;
  }
  .destination {
    margin: 5px;
  }
  .destination-info img {
    width: 100px;
    height: 100px;
  }
  .destination-name {
    font-size: .8rem;
    font-weight: bold;
  }
}

</style>