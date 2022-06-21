import { createApp } from "vue";
import App from "./App.vue";
import Vuex from "vuex";
import store from "./store/index";
import router from "./router";
import "./index.css";

import { axios } from "@/helpers/axios.js";
import "./registerServiceWorker";

const app = createApp(App);

axios.defaults.baseURL = import.meta.env.VITE_API_URL
  ? import.meta.env.VITE_API_URL
  : "http://127.0.0.1:8000"; // Default php artisan serve api url
app.config.globalProperties.$axios = axios;

app.use(Vuex);
app.use(store);

app.use(router);

app.mount("#app");
