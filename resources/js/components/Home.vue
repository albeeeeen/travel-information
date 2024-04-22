<template>
    <div class="container">
        <HeroSection />
        <FeaturedDestination />
    </div>
</template>

<script>
import HeroSection from './home/HeroSection.vue';
import FeaturedDestination from './home/FeaturedDestination.vue';

export default {
    name: 'Home',
    components: {
        HeroSection,
        FeaturedDestination
    }
}

</script>