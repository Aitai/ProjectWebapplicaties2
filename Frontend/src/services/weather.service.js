import { axios } from "@/helpers/axios";

export const weatherService = {
    getPeaks
};

function getPeaks() {
    return axios.
        get('/stations/getPeaks')
        .then(handleResponse)
        .then((peaks) => peaks)
}

function handleResponse(response) {
    if (response.status >= 300) {
        const error =
            (response.data && response.data.message) || response.statusText;
        return Promise.reject(error);
    }
    return response.data;
}