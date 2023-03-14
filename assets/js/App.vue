<template>
  <div>
    <router-view>
    </router-view>
  </div>
</template>

<script>
import Home from "./components/Home.vue";
import ProductList from "./components/ProductList";
export default {
  name: "App",
  components: {
    Home,
    ProductList
  }
};
</script>