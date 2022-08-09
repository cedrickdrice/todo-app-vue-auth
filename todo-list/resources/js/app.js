import axios from "axios";

/**
 * Boostrap
 */
require('./bootstrap');
import "bootstrap";
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import 'sweetalert2/dist/sweetalert2.min.css';

/**
 * Plugin
 */
import VueSweetalert2 from 'vue-sweetalert2';
import { createApp } from 'vue'
import { createStore } from 'vuex'

/**
 * Files
 */
import App from "./components/App.vue";
import VueRouter from './router.js';
import stateStore from './store.js';
import Auth from './Auth.js';

const VueStore = createStore(stateStore);

/**
 * Fa Icons
 */
import { library } from "@fortawesome/fontawesome-svg-core";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { fas } from '@fortawesome/free-solid-svg-icons'
import { fab } from '@fortawesome/free-brands-svg-icons'
import { far } from '@fortawesome/free-regular-svg-icons'
library.add(fas, fab, far);

/**
 * Vue
 */
const app = createApp(App)
    .use(VueStore)
    .use(VueRouter)
    .use(VueSweetalert2)
    .component('fa', FontAwesomeIcon)

app.config.globalProperties.$auth = Auth;

app.mount("#app");
