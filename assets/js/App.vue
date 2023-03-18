<template>
  <div>
    <Header/>
    <br/>
    <div id="container"><router-view/></div>
    <Footer/>
  </div>
</template>

<script>
import Header from "./components/Header";
import Footer from "./components/Footer";
export default {
  name: "App",
  components: {Footer, Header},
  created() {
    if (null == localStorage.getItem('token')) {
      this.$router.push('/login');
    }
  },
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