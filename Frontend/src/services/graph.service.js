import { axios } from "@/helpers/axios";

export const graphService = {
    getExport
};

function getExport() {
    axios.get('/stations/getExport')
        .then(handleResponse)
}

function handleResponse(response) {
    if (response.status >= 300) {
        const error =
            (response.data && response.data.message) || response.statusText;
        return Promise.reject(error);
    }

    const link = document.createElement('a');
    link.href = window.URL.createObjectURL(new Blob([response.data]));;
    link.setAttribute('download', 'export.xml'); //or any other extension
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}