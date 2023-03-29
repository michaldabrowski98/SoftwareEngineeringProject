<template>
  <v-app>
    <Header/>
    <br/>
    <br/>
    <v-container class="ma-16"><router-view/></v-container>
    <Footer/>
  </v-app>
</template>

<script>
import Header from "./components/Header";
import Footer from "./components/Footer";
export default {
  name: "App",
  components: {Footer, Header},
};
</script>

<style>
</style>