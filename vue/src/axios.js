import axios from "axios";
import store from "./store";

const axiosClient = axios.create({
    baseURL:"http://localhost:8006/api/v1"
});

axiosClient.interceptors.request.use(config => {
    config.headers.Authorization = `Bearer ${store.state.user.token}`;
    return config;
})

export default axiosClient;
