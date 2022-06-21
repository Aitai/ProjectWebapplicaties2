import { graphService } from "@/services/graph.service.js";

const state = {
  daily_temperatures: {},
  daily_wind_speed: {},
};

const actions = {
  getExport() {
    graphService.getExport();
  },
  getGraphData({state, commit, dispatch}) {

    graphService.getGraphTemperatures().then(data => {
      commit("setTemperatures", data);
    })
    graphService.getGraphWindSpeed().then(data => {
      commit("setWindSpeed", data);
    })
  }
};

const mutations = {
  setTemperatures(state, data) {
    state.daily_temperatures = data;
  },
  setWindSpeed(state, data) {
    state.daily_wind_speed = data;
  },
}

export const graph = {
  namespaced: true,
  state,
  mutations,
  actions,
};
