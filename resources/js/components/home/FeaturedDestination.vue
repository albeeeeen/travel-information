<!-- FeaturedDestinations.vue -->
<template>
  <div class="featured-destinations">
    <h2>Featured Destinations</h2>
    <div class="destination-images">
      <a v-for="destination in destinations" :key="destination.name" :href="'/destinations/' + destination.link" class="destination">
        <img :src="destination.image" :alt="destination.name">
        <h3>{{ destination.name }}</h3>
      </a>
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
  flex-wrap: wrap;
  justify-content: center;
}
.destination {
  margin: 0 10px;
}
.destination img {
  width: 150px;
  height: 150px;
  object-fit: cover;
  border-radius: 50%;
}
.destination h3 {
  margin-top: 10px;
  font-size: 1.2rem;
}

@media (max-width: 767px) {
  .featured-destinations {
    margin-top: 20px;
  }
  .featured-destinations h2 {
    font-size: 1.5rem;
  }
}

</style>