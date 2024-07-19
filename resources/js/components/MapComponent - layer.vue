<template>
    <div id="map" ref="mapContainer" style="width: 100%; height: 100vh"></div>
</template>

<script>
import mapboxgl from "mapbox-gl";

export default {
    name: "MapboxMap",
    data() {
        return {
            map: null,
        };
    },
    mounted() {
        this.initializeMap();
    },
    methods: {
        initializeMap() {
            mapboxgl.accessToken = import.meta.env.VITE_MAPBOX_ACCESS_TOKEN;
            this.map = new mapboxgl.Map({
                container: this.$refs.mapContainer,
                style: "https://maptiler.meeyatlas.com/styles/basemap-light/style.json",
                //center: [105.8544441, 21.028511], // Tọa độ trung tâm (Hà Nội)
                center: [106.707458, 10.760461], // Tọa độ Hồ Chí Minh

                zoom: 12,
            });

            this.map.on("load", () => {
                // Thêm source và layer khi map đã load
                this.addMapLayers();
            });

            this.map.on("error", (e) => {
                console.error("Mapbox GL error: ", e.error.message);
            });
        },
        addMapLayers() {
            this.map.addSource("hcm", {
                id: "s_HOCHIMINH",
                type: "vector",
                maxzoom: 16,
                tiles: [
                    "https://maptiler.meeyatlas.com/data/HT_HOCHIMINH/{z}/{x}/{y}.pbf",
                ],
            });
            //reference: https://maptiler.meeyatlas.com/styles/basemap-hcm/style.json
            this.map.addLayer({
                id: "HT_HOCHIMINH",
                type: "fill",
                source: "hcm",
                "source-layer": "HT_HOCHIMINH",
                minzoom: 14,
                maxzoom: 23,
                isCreatePopup: true,
                paint: {
                    "fill-color": "#FFFFFF",
                    "fill-opacity": 0.1,
                    "fill-antialias": false,
                    "fill-outline-color": "#ff0",
                },
            });

            this.map.addLayer({
                id: "HT_HOCHIMINH_LINE",
                type: "line",
                source: "hcm",
                "source-layer": "HT_HOCHIMINH",
                minzoom: 14,
                maxzoom: 23,
                layout: { "line-join": "round", "line-cap": "round" },
                paint: {
                    "line-color": "#FFA700",
                    "line-width": 2,
                    "line-opacity": 0.3, // Blur line
                },
                isCreatePopup: true,
            });
        },
    },
};
</script>

<style>
#map {
    position: absolute;
    top: 0;
    bottom: 0;
    width: 100%;
}
</style>
