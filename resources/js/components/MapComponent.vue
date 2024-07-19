<template>
    <div id="map" style="width: 100%; height: 100vh"></div>
</template>

<script>
import mapboxgl from "mapbox-gl";
import MapboxDraw from "@mapbox/mapbox-gl-draw";
import * as turf from "@turf/turf";
import "mapbox-gl/dist/mapbox-gl.css";
import "@mapbox/mapbox-gl-draw/dist/mapbox-gl-draw.css";

export default {
    name: "MapboxDraw",
    data() {
        return {
            isDrawing: false,
            startPoint: null,
            currentCircle: null,
        };
    },
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

        this.map.on("mousedown", this.startDrawing);
        this.map.on("mousemove", this.updateDrawing);
        this.map.on("mouseup", this.endDrawing);
    },
    methods: {
        startDrawing(e) {
            this.isDrawing = true;
            this.startPoint = [e.lngLat.lng, e.lngLat.lat];
            this.map.getCanvas().style.cursor = "crosshair";
            this.map.dragPan.disable(); // Vô hiệu hóa kéo bản đồ
        },
        updateDrawing(e) {
            if (!this.isDrawing) return;

            const endPoint = [e.lngLat.lng, e.lngLat.lat];
            const radius = turf.distance(this.startPoint, endPoint, {
                units: "kilometers",
            });

            if (this.currentCircle) {
                this.draw.delete(this.currentCircle.id);
            }

            if (radius > 0) {
                // Chỉ vẽ vòng tròn nếu bán kính lớn hơn 0
                const options = { steps: 64, units: "kilometers" };
                const circle = turf.circle(this.startPoint, radius, options);

                this.currentCircle = this.draw.add({
                    type: "Feature",
                    geometry: {
                        type: "Polygon",
                        coordinates: circle.geometry.coordinates,
                    },
                });
            }
        },
        endDrawing() {
            this.isDrawing = false;
            this.map.getCanvas().style.cursor = "";
            this.map.dragPan.enable(); // Kích hoạt lại kéo bản đồ
            this.startPoint = null;
            this.currentCircle = null;
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
