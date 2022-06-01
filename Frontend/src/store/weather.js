import { weatherService } from "@/services/weather.service.js";

const state = {
    status: {},
    dates: {},
    temps: {}
};

const actions = {
    getPeaks({ state, commit, dispatch } ) {
        commit("startProgress")
        weatherService.getPeaks()
            .then((peaks) => {
                commit("setPeakData", peaks)
            })
            .catch((error) => {
                console.log(1234)
            })
    }
};

const mutations = {
    startProgress(state) {
        state.status = {
            inProgress: true,
        };
    },
    setPeakData(state, peaks) {
        state.status = {
            finished: true,
        };

        state.dates = peaks['dates']
        state.temps = peaks['temps']
    }
};

export const weather = {
    namespaced: true,
    state,
    actions,
    mutations,
};
