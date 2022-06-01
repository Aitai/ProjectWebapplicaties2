import { axios } from "@/helpers/axios";

export const stationService = {
    getStationData,
    getStationsData,
};

function getStationData(stationName) {
    return axios
        .get(`/stations/getWeatherData/${stationName}`)
        .then(handleResponse)
        .then((station) => station);
}

function getStationsData(pageNum, orderField, orderBy) {
    return axios
        .get(
            `/stations/getStations?page=${pageNum}&ordered_row=${orderField}&order_by=${orderBy}`
        )
        .then(handleResponse)
        .then((stations) => stations);
}

function handleResponse(response) {
    if (response.status >= 300) {
        // if (response.status === 401) {
        //     // auto logout if 401 response returned from api
        //     localStorage.removeItem('user')
        //     delete axios.defaults.headers.common['Authorization']
        //     // location.reload()
        // }
        // TODO: add alert message
        const error =
            (response.data && response.data.message) || response.statusText;
        return Promise.reject(error);
    }
    return response.data;
}
