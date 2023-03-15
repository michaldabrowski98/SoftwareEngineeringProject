<template>
  <div>
    <Header/>
    <br/>
    <div id="container"><router-view/></div>
    <Footer/>
  </div>
</template>

<script>
import Home from "./components/Home.vue";
import ProductList from "./components/ProductList";
import Header from "./components/Header";
import Footer from "./components/Footer";
import ProductEdit from "./components/ProductEdit";
export default {
  name: "App",
  components: {Footer, Header}
};
</script>

<style>
body {
  background-color: #303030;
  color: #ffffff;
  font-family: 'Lato', sans-serif;
  font-size: 20px;
}
#container {
  margin-left: auto;
  margin-right: auto;
}
</style>