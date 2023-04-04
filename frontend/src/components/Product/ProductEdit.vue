<template>
  <v-container fluid style="height: 70vh">
    <v-sheet width="80%" class="mx-auto pa-12" rounded="true">
      <v-form @submit.prevent="saveEditProduct">
        <h1>ID PRODUKTU:  {{ this.$route.params.id }}</h1>
        <v-text-field v-model="name" label="Nazwa"/>
        <v-text-field v-model="description" label="Opis"/>
        <v-text-field v-model="weight" label="Waga"/>
        <v-text-field v-model="price" label="Cena"/>
        <v-btn type="submit" block class="mt-2" style="background:#ee5a32">Zapisz</v-btn>
      </v-form>
    </v-sheet>
  </v-container>
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
            this.$router.push('/')
          }
          this.product = response.data;
          this.name = this.product.name;
          this.description = this.product.description;
          this.weight = this.product.weight;
          this.price = this.product.price;
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