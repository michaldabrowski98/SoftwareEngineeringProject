<template>
  <v-container fluid style="height: 70vh">
    <v-form @submit.prevent="findShelf">
      <v-table width="80%" class="mx-auto pa-12" rounded="true">
        <thead>
        <tr>
          <th class="text-left">Id</th>
          <th class="text-left">Nazwa</th>
          <th class="text-left">Ilość</th>
        </tr>
        </thead>
        <tbody class="table-hover">
        <tr  v-for="(product,i) in x" :key="i">
          <td><v-text-field disabled v-model="changedProducts[i].id"></v-text-field></td>
          <td><v-text-field disabled v-model="changedProducts[i].name"></v-text-field></td>
          <td><v-text-field v-model="changedProducts[i].quantity" label="Ilość"/></td>
        </tr>
        </tbody>
      </v-table>
      <v-btn type="submit" block class="mt-2" style="background:#ee5a32">Sprawdź dostępność</v-btn>
    </v-form>
  </v-container>
</template>

<script>
import axios from 'axios';
import ProductAvailabilityCheck from "@/components/WarehouseRelease/ProductAvailabilityCheck.vue";

export default {
  name: "ProductListSimplified",
  components: {ProductAvailabilityCheck},
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
      },
      changedProducts: [],
    }
  },
  created() {
    if (null == sessionStorage.getItem('token')) {
      // this.$router.push('/login');
    }

    axios.get(`http://localhost:8082/api/product/list/simplified`, this.config)
        .then(response => {
          if (response.status !== 200) {
            this.$router.push('/');
          }
          for (let i = 0; i < response.data.length; i++) {
            this.x[i] = {id: response.data[i].id, name: response.data[i].name, quantity: 0};
            this.changedProducts[i] = {id: response.data[i].id, name: response.data[i].name, quantity: 0};
          }
        })
        .catch(e => {
          this.errors.push(e)
          this.$router.push('/');
        });
  },
  methods: {
    findShelf() {
      console.log(JSON.stringify(this.changedProducts));
      let j = 0;
      for (let i = 0; i < this.changedProducts.length; i++) {
        if (this.changedProducts[i].quantity > 0)
        {
          console.log(this.changedProducts[i].quantity);
          this.ProductList[j] = {id: this.changedProducts[i].id, quantity: this.changedProducts[i].quantity};
          ++j;
        }
      }
      axios.get(`http://localhost:8082/api/shelf/find/position` + '?products=' + JSON.stringify(this.ProductList), this.config)
          .then(response => {
            if (response.status !== 200) {
              this.$router.push('/');
            }
            this.availability = response.data
          })
          .catch( e => {
            this.errors.push(e)
            this.$router.push('/');

          });
    },
    toggle() {
      this.display = !this.display;
    }
  }
}




</script>

<style>
</style>