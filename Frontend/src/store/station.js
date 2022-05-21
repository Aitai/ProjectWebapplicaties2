import { stationService } from "@/services/station.service.js";

const state = {
    status: {},
    station: {},
    pagination: {},
    measurements: [],
};

const actions = {
    getData({ state, commit, dispatch }, stationName) {
        commit("startProgress");

        stationService
            .getStationData(stationName)
            .then((data) => {
                let station = data.station;
                station.measurements = data.measurements;
                commit("setStationData", station);
            })
            .catch((error) => {
                // Show error message on fail and redirect back to overview
                // commit('createFailure')
                let errors = ["Er is iets misgegaan, probeer het opnieuw."];
                if (error.response) {
                    if (
                        typeof error.response.data === "object" &&
                        typeof error.response.data.errors === "object"
                    ) {
                        errors = error.response.data.errors;
                    }
                }
                // dispatch('alert/error', errors, { root: true })
                // router.push({ name: 'stations' })
            });
    },
    getAll({ state, commit, dispatch }, data) {
        commit("startProgress");
        let pageNum = data[0];
        let orderField = data[1];
        let orderBy = data[2];

        stationService
            .getStationsData(pageNum, orderField, orderBy)
            .then((data) => {
                let stations = data.data;
                let pagination = {
                    current_page: data.current_page,
                    total_pages: data.last_page,
                };
                commit("setStationsData", stations);
                commit("setPaginationData", pagination);
            })
            .catch((error) => {
                let errors = ["Er is iets misgegaan, probeer het opnieuw."];
                if (error.response) {
                    if (
                        typeof error.response.data === "object" &&
                        typeof error.response.data.errors === "object"
                    ) {
                        errors = flatten(toArray(error.response.data.errors));
                    }
                }
            });
    },
};

const mutations = {
    startProgress(state) {
        state.status = {
            inProgress: true,
        };
    },
    setStationData(state, station, measurements) {
        state.status = {
            finished: true,
        };
        state.station = station;
    },
    setStationsData(state, stations) {
        state.status = {
            finished: true,
        };
        state.all = stations;
    },
    setPaginationData(state, pagination) {
        state.pagination = pagination;
    },
};

export const station = {
    namespaced: true,
    state,
    actions,
    mutations,
};
