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
        <tr  v-for="(product,i) in changedProducts" :key="i">
          <td><v-text-field disabled v-model="changedProducts[i].id"/></td>
          <td><v-text-field disabled v-model="changedProducts[i].name"/></td>
          <td><v-text-field v-model="changedProducts[i].quantity" label="Ilość"/></td>
        </tr>
        </tbody>
      </v-table>
      <v-dialog
          v-model="dialog"
          fullscreen
          :scrim="false"
          transition="dialog-bottom-transition"
      >
        <template v-slot:activator="{ props }">
      <v-btn type="submit" block class="mt-2" style="background:#ee5a32 " @click="dialog = true" v-bind="props">Sprawdź dostępność</v-btn>
        </template>
        <v-card>
          <v-toolbar
              dark
              color="#ee5a32"
          >
            <v-btn
                icon
                dark
                @click="dialog = false"
            >
              <v-icon>mdi-close</v-icon>
            </v-btn>
            <v-toolbar-title>Szczegóły pobrania</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-list>
              <v-list-item v-for="alert in alerts" :key="alert.id">
                <v-alert :type="alert.type"
                         :title="alert.title"
                         style="width: 80vw;"
                ></v-alert>
              </v-list-item>
            </v-list>
            <v-toolbar-items>
              <v-btn
                  variant="text"
                  @click="save"
              >
                Zapisz
              </v-btn>
            </v-toolbar-items>
          </v-toolbar>
          <v-list
              lines="two"
              subheader
          >

            <v-form fast-fail @submit.prevent="register">
              <v-table width="80%" class="mx-auto pa-12" rounded="true">
                <thead>
                <tr>
                  <th class="text-left">ID</th>
                  <th class="text-left">Ilość</th>
                  <th class="text-left">ID Półki</th>
                  <th class="text-left">Półka</th>
                  <th class="text-left">Regał</th>
                  <th class="text-left">Alejka</th>
                </tr>
                </thead>
                <tbody class="table-hover">
                <tr v-for="(product,i) in availability" :key="i">
                  <td><v-text-field disabled v-model="availability[i].productId"/></td>
                  <td><v-text-field disabled v-model="availability[i].quantity"/></td>
                  <td><v-text-field disabled v-model="availability[i].shelfId"/></td>
                  <td><v-text-field disabled v-model="availability[i].shelf"/></td>
                  <td><v-text-field disabled v-model="availability[i].column"/></td>
                  <td><v-text-field disabled v-model="availability[i].alley"/></td>
                </tr>
                </tbody>
              </v-table>
            </v-form>
          </v-list>
          <v-divider></v-divider>
        </v-card>
      </v-dialog>
    </v-form>
  </v-container>
</template>

<script>
import axios from 'axios';

export default {
  name: "ProductListSimplified",
  data() {
    return {
      x: [],
      ProductList: [],
      availability: [],
      products: null,
      quantity: 0,
      display: false,
      errors: [],
      dialogm1: '',
      dialog: false,
      alerts: [],
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
      this.$router.push('/login');
    }

    axios.get(`http://localhost:8082/api/product/list/simplified`, this.config)
        .then(response => {
          if (response.status !== 200) {
            this.$router.push('/');
          }
          for (let i = 0; i < response.data.length; i++) {
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
            for (let i = 0; i < response.data.length; i++) {
              this.availability[i] = {productId: response.data[i].productId, quantity: response.data[i].quantity,
                                      shelfId: response.data[i].shelfId, shelf: response.data[i].shelf,
                                      column: response.data[i].column, alley: response.data[i].alley};
            }
          })
          .catch( e => {
            this.errors.push(e)
            this.$router.push('/');

          });
    },
      save() {
        for (let i = 0; i < this.availability.length; i++) {
          this.ProductList[i] = {shelfId: this.availability[i].shelfId, quantity: this.availability[i].quantity};
        }
        let putRequest = {shelfs: this.ProductList};
        axios.post(`http://localhost:8082/api/shelf/remove`, putRequest, this.config)
            .then(
                (res) => {
                  if (res.status !== 200) {
                    this.alerts.push({
                      type: 'error',
                      title: 'Nie udało się wydać przedmiotów, spróbuj ponownie później.'
                    });
                  } else {
                    this.alerts.push({
                      type: 'success',
                      title: 'Wydano przedmioty.'
                    });
                  }
                }
            )
            .catch(
                () => {
                  this.alerts.push({
                    type: 'error',
                    title: 'Nie udało się wydać przedmiotów, spróbuj ponownie później'
                  });
                }
            )
        ;
      }
  }
}




</script>

<style>
</style>