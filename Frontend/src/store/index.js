import { createStore } from "vuex";
import { station } from "@/store/station";
import { weather } from "@/store/weather";

const store = createStore({
    modules: {
        station,
        weather
    },
});

export default store;
