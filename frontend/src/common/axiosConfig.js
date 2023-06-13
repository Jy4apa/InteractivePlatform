//Import Axios Library and Auth0
import axios from 'axios';
import {STORAGE_KEYS} from "@/common/const/config";

//Create instance of axios
const instance = axios.create({
    baseURL: import.meta.env.VITE_APP_API_URL
});

// Create a request interceptor for my instance and get accessToken on the fly
instance.interceptors.request.use(async (config) => {
    config.headers['Authorization'] = `Bearer ${localStorage.getItem(STORAGE_KEYS.ACCESS)}`;
    return config;
}, (error) => {
    return Promise.reject(error)
});

instance.interceptors.response.use(async (config) => {
    config.headers = {
            'Origin': '*',
            'Access-Control-Allow-Origin': '*',
            'Access-Control-Allow-Headers': 'Origin, Content-Type, Authorization',
            'Access-Control-Allow-Credentials': true
    }
    return config;
}, (error) => {
    if (error.response.status === 401) {
        this.store.dispatch('auth/signOut')
        return Promise.reject(error);
    }
    return Promise.reject(error)
});

export default instance;