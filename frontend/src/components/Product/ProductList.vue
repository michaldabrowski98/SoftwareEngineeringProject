<template>
<div class="rectangle">
  <button v-show="!display" @click="toggleAddProductForm()" id="add_product">Dodaj produkt</button>
  <div v-show="display"><AddProductForm/></div>
  <table class="table-fill">
    <thead>
    <tr>
      <th class="text-left">Id</th>
      <th class="text-left">Nazwa</th>
      <th class="text-left">Opis</th>
      <th class="text-left">Waga</th>
      <th class="text-left">Cena</th>
      <th class="text-left">Akcje</th>
    </tr>
    </thead>
    <tbody class="table-hover">
    <tr  v-for="(product,i) in products" :key="i">
      <td class="text-left">{{ product.id }}</td>
      <td class="text-left">{{ product.name }}</td>
      <td class="text-left">{{ product.description }}</td>
      <td class="text-left">{{ product.weight }}</td>
      <td class="text-left">{{ product.price }}</td>
      <td class="text-left">
        <router-link :to="'/product/edit/' + product.id"><button class="edit_button">Edytuj</button></router-link>
        <button @click.prevent="removeProduct(product.id)">Usuń</button>
      </td>
    </tr>
    </tbody>
  </table>
</div>
</template>

<script>
import axios from 'axios';
import AddProductForm from "./AddProductForm";

export default {
  name: "ProductList",
  components: {AddProductForm},
  data() {
    return {
      products: null,
      display: false,
      errors: [],
      config: {
        headers: {
          "Authorization": `Bearer ${JSON.parse(sessionStorage.getItem('token'))}`
        }
      }
    }
  },
  created() {
    if (null == sessionStorage.getItem('token')) {
      this.$router.push('/login');
    }

    axios.get(`http://localhost:8082/api/product/list`, this.config)
        .then(response => {
          if (response.status !== 200) {
            this.$router.push('/');
          }
          this.products = response.data
        })
        .catch( e => {
          this.errors.push(e)
          this.$router.push('/');
        });
  },
  methods: {
    removeProduct(id) {
      axios.delete(`http://localhost:8082/api/product/delete/` + id, this.config);
    },
    toggleAddProductForm() {
      this.display = !this.display;
    }
  }
}
</script>

<style>
</style>