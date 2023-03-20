import Home from '../components/Home.vue'
import ProductList from "../components/Product/ProductList";
import {createRouter, createWebHistory} from 'vue-router'
import ProductEdit from "../components/Product/ProductEdit";
import Login from "../components/Login/Login";
import Registration from "../components/Login/Registration";

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
        },
        {
            name: 'product_edit',
            path: '/product/edit/:id',
            component: ProductEdit
        },
        {
            name: 'login',
            path: '/login',
            component: Login
        },
        {
            name: 'registration',
            path: '/register',
            component: Registration
        }
    ]
})