<template>
  <div class="rectangle">
    <form action="\App\Controller\ProductController::saveAction">
      <label for="productId">Id: </label><br>
      <input type="number" id="productId" name="productId">{{ product.id }}<br>
      <label for="productName">Nazwa: </label><br>
      <input type="text" id="productName" name="productName">{{ product.name }}<br>
      <label for="productDescription">Opis: </label><br>
      <input type="text" id="productDescription" name="productDescription">{{ product.description }}<br>
      <label for="productWeight">Waga: </label><br>
      <input type="number" id="productWeight" name="productWeight">{{ product.weight }}<br>
      <label for="productPrice">Cena: </label><br>
      <input type="number" id="productPrice" name="productPrice">{{ product.price }}<br>
      <input type="submit" value="Submit">
    </form>
<!--    Id: {{ product.id }} <br/>
    Nazwa: {{ product.name }}<br/>
    Opis: {{ product.description }}<br/>
    Waga: {{ product.weight }}<br/>
    Cena: {{ product.price }}<br/>
    Ilość sztuk w magazynie: 1234<br/>
    Lista lokalizacji:<br/>-->
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