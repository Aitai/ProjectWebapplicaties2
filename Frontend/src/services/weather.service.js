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
    // this.for
    // console.log(new Blob(response.data))
    //
    // const link = document.createElement('a');
    // link.href = window.URL.createObjectURL(new Blob([response.data]));;
    // link.setAttribute('download', 'export.xml'); //or any other extension
    // document.body.appendChild(link);
    // link.click();
    // document.body.removeChild(link)
    // // console.log(new Blob([response.data]))
    // return response.data;
}