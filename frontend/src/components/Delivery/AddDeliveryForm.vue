<template>
  <v-container fluid style="height: 70vh">
    <v-sheet width="80%" class="mx-auto pa-12" rounded="true">
      <v-form @submit.prevent="addProductToShelf">
        <h1>ID PRODUKTU:  {{ this.$route.params.id }}</h1>
        <v-text-field v-model="name" label="Nazwa"/> //dodać blokadę edycji
        <v-text-field v-model="description" label="Opis"/> //dodać blokadę edycji
        <v-text-field v-model="quantity" label="Ilość"/>
        <v-btn type="submit" block class="mt-2" style="background:#ee5a32">Dodaj na półkę</v-btn>
      </v-form>
    </v-sheet>
  </v-container>
</template>

<script>
import axios from "axios";

export default {
  name: "AddDeliveryForm",
  data() {
    return {
      name: "",
      description: "",
      quantity: 0,
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
            this.$router.push('/')
          }
          this.product = response.data;
          this.name = this.product.name;
          this.description = this.product.description;
          this.weight = this.product.weight;
        })
        .catch( e => {
          this.errors.push(e)
          this.$router.push('/');
        });
  },
  methods: {
    addProductToShelf() {
      const postData = {
        id: this.$route.params.id,
        quantity: this.quantity,
        weight: this.weight,
        totalWeight: this.quantity * this.weight
      };
      axios.post(`http://localhost:8082/api/shelf/addProduct`, postData);
    },
  }
}
</script>

<style scoped>
</style>