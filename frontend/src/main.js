import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from "./store";
import './assets/styles/tailwind.css';
import './assets/styles/theme.scss'

import 'virtual:svg-icons-register';
import {maska} from "maska";
import Toast from "vue-toastification";
import YmapPlugin from 'vue-yandex-maps'
const options = {}

const settings = {
    apiKey: import.meta.env.VITE_APP_MAP_KEY || '',
    lang: 'ru_RU',
    coordorder: 'longlat',
    version: '2.1'
}

createApp(App).use(router).use(store).use(YmapPlugin, settings).directive('maska', maska).use(Toast, options).mount('#app')
