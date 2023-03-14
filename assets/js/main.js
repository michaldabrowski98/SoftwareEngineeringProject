import '../styles/app.css';
import {createApp} from 'vue';
import App from './App';
import router from './router/router';
import store from './store/index';


createApp(App)
    .use(router)
    .use(store)
    .mount('#app')