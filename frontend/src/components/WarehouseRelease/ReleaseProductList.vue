<template>
  <v-container fluid style="height: 70vh">
    <v-table width="80%" class="mx-auto pa-12" rounded="true">
      <thead>
      <tr>
        <th class="text-left">Id</th>
        <th class="text-left">Nazwa</th>
      </tr>
      </thead>
      <tbody class="table-hover">
      <tr  v-for="(product,i) in products" :key="i">
        <td class="text-left">{{ product.id }}</td>
        <td class="text-left">{{ product.name }}</td>
        <td class="text-left">
          <v-text-field v-model="" placeholder="quantity" />
        </td>
      </tr>
      </tbody>
    </v-table>
  </v-container>
</template>

<script>
import axios from 'axios';

export default {
  name: "ProductList",
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

    axios.get(`http://localhost:8082/api/product/list/simplified`, this.config)
        .then(response => {
          if (response.status !== 200) {
            this.$router.push('/');
          }
          this.products = response.data
        })
        .catch(e => {
          this.errors.push(e)
          this.$router.push('/');
        });
  },
}
</script>

<style>
</style>