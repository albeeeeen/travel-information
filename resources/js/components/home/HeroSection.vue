<template>
  <div class="hero">
    <img class="hero-image" src="/public/img/japan-image.jpg" alt="Captivating image of Japan">
    <div class="hero-content">
      <h1>Welcome to Japan</h1>
      <p>Discover the beauty of Japan's featured destinations</p>
    </div>
  </div>
</template>

<script>
export default {
  name: 'HeroSection'
}
</script>

<style scoped>
.hero {
  position: relative;
  text-align: center;
}
.hero-image {
  width: 100%;
  height: auto;
}
.hero-content {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  color: white;
}
.hero-content h1 {
  font-size: 2.5rem;
  margin-bottom: 10px;
}
.hero-content p {
  font-size: 1.2rem;
}

@media (max-width: 767px) {
  .hero-image {
    /* Adjust image size for smaller screens */
    max-width: 100%;
    height: auto;
  }
  .hero-content h1 {
    font-size: 1.2rem; /* Adjust font size for smaller screens */
  }

  .hero-content p {
    font-size: .7rem; /* Adjust font size for smaller screens */
  }
}

</style>