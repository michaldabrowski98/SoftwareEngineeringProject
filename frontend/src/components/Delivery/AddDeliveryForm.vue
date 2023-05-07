<template>
  <v-container fluid style="height: 70vh">
      <v-list>
          <v-list-item v-for="alert in alerts" :key="alert.id">
              <v-alert :type="alert.type"
                       :title="alert.title"
                       style="width: 80vw;"
              ></v-alert>
          </v-list-item>
      </v-list>
    <v-sheet width="80%" class="mx-auto pa-12" rounded="true">
      <v-form @submit.prevent="findShelfsForProduct">
        <h1>ID PRODUKTU:  {{ this.$route.params.id }}</h1>
        <v-text-field v-model="name" label="Nazwa" readonly/>
        <v-text-field v-model="description" label="Opis" readonly/>
        <v-text-field v-model="quantity" label="Ilość"/>
        <v-btn type="submit" block class="mt-2" style="background:#ee5a32">Dodaj na półkę</v-btn>
      </v-form>
    </v-sheet>
      <v-banner-text>Dostępne półki</v-banner-text>
      <v-table theme="dark">
          <template v-slot:default>
              <thead>
              <tr>
                  <th class="text-left">Id</th>
                  <th class="text-left">Alejka</th>
                  <th class="text-left">Kolumna</th>
                  <th class="text-left">Półka</th>
                  <th class="text-left">Id produktu</th>
                  <th class="text-left">Dostępne miejsce</th>
                  <th class="text-left">Dodawana ilość</th>
                  <th class="text-left">Akcje</th>
              </tr>
              </thead>
              <tbody class="table-hover">
              <tr v-for="(shelf,i) in shelfs" :key="i">
                  <td class="text-left">{{ shelf.shelfId }}</td>
                  <td class="text-left">{{ shelf.alley }}</td>
                  <td class="text-left">{{ shelf.column }}</td>
                  <td class="text-left">{{ shelf.shelf }}</td>
                  <td class="text-left">{{ shelf.productId }}</td>
                  <td class="text-left">{{ shelf.quantity }}</td>
                  <td class="text-left"><v-text-field v-model="newQuantity"></v-text-field></td>
                  <td class="text-left"><v-btn style="background:#ee5a32" @click="chooseShelf(shelf.shelfId, this.$route.params.id, newQuantity, shelf.alley, shelf.column, shelf.shelf)">Wybierz</v-btn></td>
              </tr>
              </tbody>
          </template>
      </v-table>
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
      errors: [],
      shelfs: [],
      alerts: [],
      newQuantity: 0
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
    findShelfsForProduct() {
      const postData = {
        productId: parseInt(this.$route.params.id),
        quantity: parseInt(this.quantity),
      };

      axios.post(`http://localhost:8082/api/shelf/find`, postData, {
        headers: {
          "Authorization": `Bearer ${JSON.parse(sessionStorage.getItem('token'))}`
        }
      }).then(
          (res) => {
              if (res.status !== 200) {
                  this.alerts.push({
                      type: 'error',
                      title: 'Nie udało się znaleźć półki'
                  });
              }
              this.shelfs = res.data;
          }
      ).catch(

      );
    },
    chooseShelf(shelfId, productId, quantity, alley, column, shelf) {
        const postData = {
            data: [
                {
                    productId: productId,
                    shelfId: shelfId,
                    quantity: quantity,
                }
            ]
        };

        axios.post(`http://localhost:8082/api/shelf/save`, postData, {
            headers: {
                "Authorization": `Bearer ${JSON.parse(sessionStorage.getItem('token'))}`
            }
        }).then(
            (res) => {
                if (res.status !== 200) {
                    this.alerts.push({
                        type: 'error',
                        title: 'Nie udało się znaleźć półki'
                    });
                } else {
                    this.alerts.push(
                        {
                            type: 'success',
                            title: 'Dodano produkt na półkę w systemie, teraz połóż go w wybranym miejscu\nAlejka: '
                                + alley + ' \nKolumna: ' + column + '\n Półka: ' + shelf + '\n Ilość: ' + quantity
                        }
                    )
                    this.newQuantity = 0;
                }
            }
        ).catch(

        );
    }
  }
}
</script>

<style scoped>
</style>