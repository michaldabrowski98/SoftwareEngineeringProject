<template>
  <div class="rectangle">
    Id: {{ product.id }} <br/>
    Nazwa: {{ product.name }}<br/>
    Opis: {{ product.description }}<br/>
    Waga: {{ product.weight }}<br/>
    Cena: {{ product.price }}<br/>
    Ilość sztuk w magazynie: 1234<br/>
    Lista lokalizacji:<br/>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "ProductEdit",
  data() {
    return {
      product: null,
      errors: []
    }
  },
  created() {
    if (null == localStorage.getItem('token')) {
      this.$router.push('/login');
    }
    axios.get(`http://localhost:8082/api/product/edit/`+ this.$route.params.id)
        .then(response => {
          this.product = response.data
        })
        .catch( e => {
          this.errors.push(e)
        });
  }
}
</script>

<style scoped>
.rectangle {
  width: 75%;
  margin: auto;
  text-align: left;
  background: #666B85;
}
</style>