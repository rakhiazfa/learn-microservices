import axios, { AxiosInstance } from "axios";
import Cookies from "js-cookie";

const api: AxiosInstance = axios.create({
    baseURL: import.meta.env.VITE_API_GATEWAY,
    headers: {
        Accept: "application/json",
    },
});

api.interceptors.request.use((config) => {
    const accessToken = Cookies.get("ACCESS_TOKEN") ?? null;

    if (accessToken) {
        config.headers.Authorization = `Bearer ${accessToken}`;
    }

    return config;
});

export default api;
