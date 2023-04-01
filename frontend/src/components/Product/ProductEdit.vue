<template>
  <div class="rectangle">
    <form @submit.prevent="saveEditProduct">
      <label for="productId">Id: </label> {{ this.$route.params.id }}<br>
      <p>Nazwa: </p><br>
      <input v-model="name" :placeholder= " name "><br>
      <p>Opis: </p><br>
      <input v-model="description" :placeholder= " description "><br>
      <p>Waga: </p><br>
      <input v-model="weight" :placeholder= " weight "><br>
      <p>Cena: </p><br>
      <input v-model="price" :placeholder= " price "><br>
      <button type="submit">Zapisz</button>
    </form>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "ProductEdit",
  data() {
    return {
      name: "",
      description: "",
      weight: 0,
      price: 0,
      errors: []
    }
  },
  created() {
    if (null == sessionStorage.getItem('token')) {
      this.$router.push('/login');
    }

    const config = {
      headers: {
        "Authorization": `Bearer ${JSON.parse(sessionStorage.getItem('token'))}`
      }
    };

    axios.get(`http://localhost:8082/api/product/edit/`+ this.$route.params.id, config)
        .then(response => {
          if (response.status !== 200) {
            this.$router.push('/');
          }
          this.product = response.data
        })
        .catch( e => {
          this.errors.push(e)
          this.$router.push('/');
        });
  },
  methods: {
    saveEditProduct() {
      const postData = {
        name: this.name,
        description: this.description,
        weight: this.weight,
        price: this.price
    };
      axios.post(`http://localhost:8082/api/product/edit/` + this.$route.params.id + `/save`, postData);
    },
  }
}
</script>

<style scoped>
</style>