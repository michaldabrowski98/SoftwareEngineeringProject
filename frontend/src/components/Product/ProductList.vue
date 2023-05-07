<template>
  <v-container class="rectangle">
    <v-btn v-show="!display" @click="toggleAddProductForm()" id="add_product" style="background:#ee5a32">Dodaj produkt</v-btn>
    <v-alert
        color="info"
        icon="$success"
        title="Usunięto produkt."
        text="Odświeżam dane..."
        v-model="rmproduct"
    ></v-alert>
    <v-container v-show="display"><AddProductForm/></v-container>
    <v-simple-table class="table-fill">
      <template v-slot:default>
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
        <tr v-for="(product,i) in products" :key="i">
          <td class="text-left">{{ product.id }}</td>
          <td class="text-left">{{ product.name }}</td>
          <td class="text-left">{{ product.description }}</td>
          <td class="text-left">{{ product.weight }}</td>
          <td class="text-left">{{ product.price }}</td>
          <td class="text-left">
            <router-link :to="'/product/edit/' + product.id">
              <v-btn class="edit_button">Edytuj</v-btn>
            </router-link>
            <v-btn @click.prevent="removeProduct(product.id)">Usuń</v-btn>
          </td>
        </tr>
        </tbody>
      </template>
    </v-simple-table>
  </v-container>
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
      rmproduct: false,
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
      this.rmproduct = true;
      axios.delete(`http://localhost:8082/api/product/delete/` + id, this.config)
          .then(() => {
            this.rmproduct = false;
            this.refreshProducts();
          });
    },
    refreshProducts() {
      axios.get(`http://localhost:8082/api/product/list`, this.config)
          .then(response => {
            if (response.status !== 200) {
              this.$router.push('/');
            }
            this.products = response.data;
          })
          .catch( e => {
            this.errors.push(e)
            this.$router.push('/');
          });
    },
    toggleAddProductForm() {
      this.display = !this.display;
    }
  }
}
</script>

<style scoped>
</style>