<template>
    <div id="search">
        <input
            type="text"
            v-model="inputSearch"
            @keyup.enter="searchLocation"
            placeholder="Enter location"
        />
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "SearchComponent",
    data() {
        return {
            inputSearch: "",
        };
    },
    methods: {
        async searchLocation() {
            try {
                const response = await axios.get(
                    `https://api.mapbox.com/geocoding/v5/mapbox.places/${
                        this.inputSearch
                    }.json?access_token=${
                        import.meta.env.VITE_MAPBOX_ACCESS_TOKEN
                    }`
                );

                console.log(response);
                const [longitude, latitude] = response.data.features[0].center;
                this.$emit("search-address", { longitude, latitude });
            } catch (error) {
                console.error("Error fetching location data: ", error);
            }
        },
    },
};
</script>

<style>
#search {
    position: absolute;
    top: 10px;
    left: 10px;
    z-index: 1;
}
</style>
