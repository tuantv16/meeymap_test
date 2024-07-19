<template>
    <div id="app">
        <search-component @search-address="updateMap" />
        <map-component ref="mapComponent" />
    </div>
</template>

<script>
import MapComponent from "./MapComponent.vue";
import SearchComponent from "./SearchComponent.vue";

export default {
    name: "App",
    components: {
        MapComponent,
        SearchComponent,
    },
    methods: {
        updateMap(coordinates) {
            this.$refs.mapComponent.resultSearch(coordinates);
        },
    },
};
</script>

<style>
#app {
    font-family: Avenir, Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    text-align: center;
    color: #2c3e50;
    margin-top: 60px;
}
</style>
