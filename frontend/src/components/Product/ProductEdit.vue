<template>
  <v-container fluid style="height: 70vh">
    <v-sheet width="80%" class="mx-auto pa-12" rounded="true">
      <v-form @submit.prevent="saveEditProduct">
        <h1>ID PRODUKTU:  {{ this.$route.params.id }}</h1>
        <v-text-field v-model="name" label="Nazwa" :rules="nameRules"/>
        <v-text-field v-model="description" label="Opis" :rules="descriptionRules"/>
        <v-text-field v-model="weight" label="Waga" :rules="weightRules"/>
        <v-text-field v-model="price" label="Cena" :rules="priceRules"/>
        <v-btn type="submit" block class="mt-2" style="background:#ee5a32">Zapisz</v-btn>
      </v-form>
    </v-sheet>
  </v-container>
  <v-alert
      color="succes"
      icon="$succes"
      title="Edycja zakończona sukcesem."
      v-model="changeSucces"
  ></v-alert>

  <v-alert
      color="error"
      icon="$error"
      title="Edycja się nie powiodła."
      v-model="changeErr"
  ></v-alert>

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
      errors: [],
      changeSucces: false,
      changeErr: false,
      nameRules: [
        v => !!v || 'Nazwa produktu jest wymagana',
        v => (v && v.length <= 50) || 'Nazwa produktu nie może mieć więcej niż 50 znaków',
      ],
      descriptionRules: [
        v => !!v || 'Opis produktu jest wymagany',
        v => (v && v.length <= 500) || 'Opis produktu nie może mieć więcej niż 500 znaków',
      ],
      weightRules: [
        v => !!v || 'Waga produktu jest wymagana',
        v => (v && !isNaN(v)) || 'Waga produktu musi być liczbą',
        v => (v && v >= 0) || 'Waga produktu nie może być ujemna',
      ],
      priceRules: [
        v => !!v || 'Cena produktu jest wymagana',
        v => (v && !isNaN(v)) || 'Cena produktu musi być liczbą',
        v => (v && v >= 0) || 'Cena produktu nie może być ujemna',
      ],
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
      axios.post(`http://localhost:8082/api/product/edit/` + this.$route.params.id + `/save`, postData)
          .then(() => {
            this.changeSucces = true;
          })
          .catch(() => {
            this.changeErr = true;
          });
    },
  }
}
</script>

<style scoped>
</style>