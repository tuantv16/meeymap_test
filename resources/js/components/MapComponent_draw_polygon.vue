<template>
    <div id="map" style="width: 100%; height: 100vh"></div>
</template>

<script>
import mapboxgl from "mapbox-gl";
import MapboxDraw from "@mapbox/mapbox-gl-draw";
import "mapbox-gl/dist/mapbox-gl.css";
import "@mapbox/mapbox-gl-draw/dist/mapbox-gl-draw.css";

export default {
    name: "MapboxDraw",
    mounted() {
        mapboxgl.accessToken = import.meta.env.VITE_MAPBOX_ACCESS_TOKEN;

        this.map = new mapboxgl.Map({
            container: "map",
            style: "mapbox://styles/mapbox/streets-v11",
            center: [-74.5, 40], // Tọa độ trung tâm bản đồ
            zoom: 9,
        });

        this.draw = new MapboxDraw({
            displayControlsDefault: false,
            controls: {
                polygon: true,
                trash: true,
            },
            styles: [
                {
                    id: "gl-draw-polygon-fill",
                    type: "fill",
                    paint: {
                        "fill-color": "#D20C0C",
                        "fill-opacity": 0.5,
                    },
                },
                {
                    id: "gl-draw-polygon-stroke-active",
                    type: "line",
                    paint: {
                        "line-color": "#D20C0C",
                        "line-width": 2,
                    },
                },
            ],
        });

        this.map.addControl(this.draw);

        this.map.on("draw.create", this.updateArea);
        this.map.on("draw.update", this.updateArea);
    },
    methods: {
        updateArea(e) {
            const data = this.draw.getAll();
            if (data.features.length > 0) {
                console.log("Polygon drawn:", data.features[0]);
                // Ở đây bạn có thể xử lý dữ liệu của polygon đã vẽ
            }
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
