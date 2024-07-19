import "../bootstrap";
// import app from "../bootstrap.js";
import { createApp } from "vue";
import TopPageComponent from "../components/TopPageComponent.vue";

const app = createApp({});

app.component("top-page-component", TopPageComponent);
app.mount("#app");
