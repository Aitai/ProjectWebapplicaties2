import axiosProvider from "axios";

export const axios = axiosProvider.create();

let user = JSON.parse(localStorage.getItem("user"));
const cookieToken = document.cookie.replace(
    /(?:(?:^|.*;\s*)api_token\s*=\s*([^;]*).*$)|^.*$/,
    "$1"
);

let apiToken = null;
if (user) {
    apiToken = user.api_token;
} else if (cookieToken) {
    apiToken = cookieToken;
}

if (apiToken) {
    axios.defaults.headers.common["Authorization"] = "Bearer " + apiToken;
} else {
    axios.defaults.headers.common = {};
}

axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
