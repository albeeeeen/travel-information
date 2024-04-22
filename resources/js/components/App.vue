<template>
    <div>
        <NavBar></NavBar>
        <RouterView/>
    </div>
</template>

<script>
import NavBar from "./NavBar.vue";

export default {
    name: 'App',
    components: {NavBar}
}
</script>