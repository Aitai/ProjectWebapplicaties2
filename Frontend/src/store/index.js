import { createStore } from "vuex";
import { station } from "@/store/station";

const store = createStore({
    modules: {
        station,
    },
});

export default store;
