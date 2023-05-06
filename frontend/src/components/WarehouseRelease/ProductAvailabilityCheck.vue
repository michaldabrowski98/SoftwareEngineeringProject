<template>
  <v-container fluid style="height: 70vh">
    <v-form @submit.prevent="ReleaseProduct">
      <v-table width="80%" class="mx-auto pa-12" rounded="true">
        <thead>
        <tr>
          <th class="text-left">Id</th>
          <th class="text-left">Nazwa</th>
          <th class="text-left">Ilość</th>
        </tr>
        </thead>
        <tbody class="table-hover">
        <tr  v-for="(product,i) in Availability" :key="i">
          <td class="text-left">{{ product.productId }}</td>
          <td class="text-left">{{ product.quantity }}</td>
          <td class="text-left">{{ product.shelfId }}</td>
          <td class="text-left">{{ product.alley }}</td>
          <td class="text-left">{{ product.column }}</td>
          <td class="text-left">{{ product.shelf }}</td>
        </tr>
        </tbody>
      </v-table>
      <v-btn type="submit" block class="mt-2" style="background:#ee5a32">Stwórz wydanie</v-btn>
    </v-form>
  </v-container>
</template>

<script>

//import axios from 'axios';

import axios from "axios";

export default {
  name: "ProductAvailabilityCheck",
  data() {
    return {
      x: [],
      ProductList: [],
      availability: [],
      products: null,
      quantity: 0,
      display: false,
      errors: [],
      config: {
        headers: {
          "Authorization": `Bearer ${JSON.parse(sessionStorage.getItem('token'))}`
        }
      }
    }
  },

    methods: {
      ReleaseProduct() {
        const putData = {
          name: this.name,
          description: this.description,
          weight: this.weight,
          price: this.price
        };
        axios.put(`http://localhost:8082/api/product/new`, putData);
      },
      toggleView() {
        this.displayForm = false;
      }
    }
  }

</script>

<style scoped>

</style>