<template>
  <div>
    <Header/>
    <br/>
    <div id="page"><router-view/></div>
    <Footer/>
  </div>
</template>

<script>
import Home from "./components/Home.vue";
import ProductList from "./components/ProductList";
import Header from "./components/Header";
import Footer from "./components/Footer";
export default {
  name: "App",
  components: {Footer, Header}
};
</script>

<style>
  #page {
    width: 70%;
    margin: auto;
  }
</style>