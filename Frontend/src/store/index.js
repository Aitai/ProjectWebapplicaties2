import { createStore } from "vuex";
import { station } from "@/store/station";
import { weather } from "@/store/weather";
import { graph } from "@/store/graph";

const store = createStore({
    modules: {
        station,
        weather,
        graph
    },
});

export default store;
