import Home from '../components/Home.vue'
import ProductList from "../components/ProductList";
import {createRouter, createWebHistory} from 'vue-router'

export default createRouter({
    history: createWebHistory(),
    routes: [
        {
            name: 'home',
            path: '/',
            component: Home
        },
        {
            name: 'product_list',
            path: '/product/list',
            component: ProductList
        }
    ]
})