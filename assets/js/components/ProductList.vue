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
      errors: []
    }
  },
  created() {
    axios.get(`http://localhost:8080/api/product/list`)
        .then(response => {
          this.products = response.data
        })
        .catch( e => {
          this.errors.push(e)
        })
  },
  methods: {
    removeProduct(id) {
      axios.delete(`http://localhost:8080/api/product/delete/` + id);
    },
    toggleAddProductForm() {
      this.display = !this.display;
    }
  }
}
</script>

<style>
@import url(https://fonts.googleapis.com/css?family=Roboto:400,500,700,300,100);
.rectangle {
  width: 75%;
  margin: auto;
}
body {
  background-color: #404040;
  font-size: 16px;
  text-rendering: optimizeLegibility;
}

div.table-title {
  display: block;
  margin: auto;
  max-width: 600px;
  padding:5px;
  width: 100%;
}

.table-title h3 {
  color: #fafafa;
  font-size: 30px;
  font-style:normal;
  text-shadow: -1px -1px 1px rgba(0, 0, 0, 0.1);
  text-transform:uppercase;
}


/*** Table Styles **/

.table-fill {
  background: white;
  border-radius:3px;
  border-collapse: collapse;
  height: 320px;
  margin: auto;
  max-width: 600px;
  padding:5px;
  width: 100%;
  box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
  animation: float 5s infinite;
}

th {
  color:#D5DDE5;;
  background:#1b1e24;
  border-bottom:4px solid #9ea7af;
  border-right: 1px solid #343a45;
  font-size:23px;
  padding:24px;
  text-align:left;
  text-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
  vertical-align:middle;
}

th:first-child {
  border-top-left-radius:3px;
}

th:last-child {
  border-top-right-radius:3px;
  border-right:none;
}

tr {
  border-top: 1px solid #C1C3D1;
  border-bottom: 1px solid #C1C3D1;
  color:#666B85;
  font-size:16px;
  text-shadow: 0 1px 1px rgba(256, 256, 256, 0.1);
}

tr:hover td {
  background:#4E5066;
  color:#FFFFFF;
  border-top: 1px solid #22262e;
}

tr:first-child {
  border-top:none;
}

tr:last-child {
  border-bottom:none;
}

tr:nth-child(odd) td {
  background:#EBEBEB;
}

tr:nth-child(odd):hover td {
  background:#4E5066;
}

tr:last-child td:first-child {
  border-bottom-left-radius:3px;
}

tr:last-child td:last-child {
  border-bottom-right-radius:3px;
}

td {
  background:#FFFFFF;
  padding:20px;
  text-align:left;
  vertical-align:middle;
  font-size:18px;
  text-shadow: -1px -1px 1px rgba(0, 0, 0, 0.1);
  border-right: 1px solid #C1C3D1;
}

td:last-child {
  border-right: 0px;
}

th.text-left {
  text-align: left;
}

th.text-center {
  text-align: center;
}

th.text-right {
  text-align: right;
}

td.text-left {
  text-align: left;
}

td.text-center {
  text-align: center;
}

td.text-right {
  text-align: right;
}

button {
  color:#D5DDE5;;
  background:#ee5a32;
  font-size:18px;
  text-align:left;
  vertical-align:middle;
  border-radius:3px;
  width: 80px;
  padding-bottom: 5px;
}

button.edit_button {
  background: #1b1e24;
}

button#add_product {
  width: 50%;
  padding: 20px;
  margin-bottom: 20px;
  text-align: center;
}
</style>