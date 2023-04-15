<template>
  <v-card class="rectangle" v-show="displayForm">
    <v-btn class="close_button" @click="toggleView()" style="background:#ee5a32">ANULUJ</v-btn>
    <p>Nazwa produktu</p>
    <v-text-field v-model="name" placeholder="nazwa..." :rules="nameRules"/>
    <p>Opis produktu</p>
    <v-text-field v-model="description" placeholder="opis..." :rules="descriptionRules" />
    <p>Waga</p>
    <v-text-field v-model="weight" placeholder="waga..." :rules="weightRules" />
    <p>Cena</p>
    <v-text-field v-model="price" placeholder="cena..." :rules="priceRules" />
    <br/>
    <v-btn @click.prevent="addProduct()" style="background:#ee5a32">Dodaj produkt</v-btn>
  </v-card>

  <v-alert
      color="succes"
      icon="$succes"
      title="Dodano produkt."
      v-model="requestSuccess"
  ></v-alert>

  <v-alert
      color="error"
      icon="$error"
      title="Błąd. Nie dodano produktu."
      v-model="requestFail"
  ></v-alert>

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
      requestFail: false,
      displayForm: true,
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
      axios.post(`http://localhost:8082/api/product/new`, postData)
          .then(() => {
        this.requestSuccess = true;
      })
          .catch(() => {
            this.requestFail = true;
          });
    },
    toggleView() {
      this.displayForm = false;
    }
  }
}
</script>

<style scoped>
</style>