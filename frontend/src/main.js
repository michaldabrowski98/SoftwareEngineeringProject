import '@fontsource/roboto/index.css'
import '@mdi/font/css/materialdesignicons.css'

import { createApp } from 'vue'
import App from './App.vue'

import { createRouter, createWebHashHistory } from 'vue-router'
import HomePage from './components/HomePage'
import ProductList from "./components/Product/ProductList";
import ProductEdit from "./components/Product/ProductEdit";
import Login from "./components/Login/Login";
import Registration from "./components/Login/Registration";
import UserPage from "./components/UserPage/UserPage";
import DeliveryList from "./components/Delivery/DeliveryList";
import AddDeliveryForm from "./components/Delivery/AddDeliveryForm";

const router = createRouter({
    history: createWebHashHistory(),
    routes: [
        { path: '/', component: HomePage },
        { path: '/product/list', component: ProductList },
        { path: '/product/edit/:id', component: ProductEdit },
        { path: '/login', component: Login },
        { path: '/register', component: Registration },
        { path: '/user', component: UserPage },
        { path: '/warehouse/scheme', component: WarehousePage },
        { path: '/delivery/list', component: DeliveryList },
        { path: '/shelf/addProduct/:id', component: AddDeliveryForm },
    ]
})

import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import WarehousePage from "@/components/Warehouse/WarehousePage";

const vuetify = createVuetify({
    ssr: true,
    components,
    directives,
    icons: { iconfont: 'mdi' },
    theme: {
        defaultTheme: 'dark'
    }
})

createApp(App).use(vuetify).use(router).mount('#app')