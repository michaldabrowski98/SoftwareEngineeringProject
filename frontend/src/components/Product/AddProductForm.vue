<template>
  <div class="rectangle" v-show="displayForm">
    <div class="close_button" @click="toggleView()">[x]</div>
    <p>Nazwa produktu</p>
    <input v-model="name" placeholder="nazwa..." />
    <p>Opis produktu</p>
    <input v-model="description" placeholder="opis..." />
    <p>Waga</p>
    <input v-model="weight" placeholder="waga..." />
    <p>Cena</p>
    <input v-model="price" placeholder="cena..." />
    <br/>
    <button @click.prevent="addProduct()">Dodaj produkt</button>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "AddProductForm",
  data() {
    return {
      name: "",
      description: "",
      weight: 0,
      price: 0,
      requestSuccess: false,
      displayForm: true
    };
  },
  methods: {
    addProduct() {
      const postData = {
        name: this.name,
        description: this.description,
        weight: this.weight,
        price: this.price
      };
      axios.post(`http://localhost:8082/api/product/new`, postData);
    },
    toggleView() {
      this.displayForm = false;
    }
  }
}
</script>

<style scoped>
</style>