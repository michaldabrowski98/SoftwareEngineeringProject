<template>
  <v-row justify="center">
      <v-list>
          <v-list-item v-for="alert in alerts" :key="alert.id">
              <v-alert :type="alert.type"
                       :title="alert.title"
                       style="width: 80vw;"
              ></v-alert>
          </v-list-item>
      </v-list>
    <v-dialog
        v-model="dialog"
        scrollable
        width="auto"
    >
      <template v-slot:activator="{ props }">
          <v-card v-bind="props" style="height: 400px; width: 20vw;" class="mt-6">
            <v-card-title class="text-white" v-text="`Alejka: ` + alley.alleyNum"></v-card-title>
            <v-card-title class="text-white" v-text="`Ilość regałów: ` + alley.columnCount"></v-card-title>
            <v-card-title class="text-white" v-text="`Ilość półek: ` + alley.shelfCount"></v-card-title>
          </v-card>
      </template>
      <v-card>
        <v-card-title>Alejka {{alley.alleyNum}}</v-card-title>
        <v-divider></v-divider>
        <v-card-text style="height: 300px; width: 50vw">
          <v-list v-for="column in alley.columns" :key="column.colNumber" >
            <v-list-subheader>Regał {{ column.colNumber }}</v-list-subheader>
              <v-list-item
                  v-for="shelf in column.shelfs"
                  :key="shelf.shelfNumber"
                  active-color="primary"
                  rounded="shaped"
              >
                <template v-slot:prepend>
                  <v-card>
                    <v-card-text>Maksymalne obciążenie: {{ shelf.maxWeight }}kg</v-card-text>
                    <v-card-text>Ilość produktów: {{ shelf.quantity ?? 0 }}</v-card-text>
                    <v-card-actions>
                      <v-btn color="#ee5a32">Edytuj</v-btn>
                    <v-btn v-if="shelf.quantity == NULL" color="#ee5a32">Usuń</v-btn>
                    </v-card-actions>
                  </v-card>
                </template>

                <v-list-item-title :v-text="`Półka` + shelf.shelfNumber"></v-list-item-title>
              </v-list-item>
              <v-list-item>
                <v-btn color="#ee5a32" class="mr-4">Usuń regał</v-btn>
                <v-btn color="#ee5a32">Dodaj półkę</v-btn>
              </v-list-item>
          </v-list>
        </v-card-text>
        <v-divider></v-divider>
        <v-card-actions>
          <v-btn
              color="#ee5a32"
              variant="text"
              @click="deleteAlley(alley.alleyNum)"
          >
            Usuń
          </v-btn>
          <v-btn
              color="#ee5a32"
              variant="text"
              @click="dialog = false"
          >
            Zapisz
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>
import axios from "axios";

export default {
  name: "AlleyComponent",
  props: ['alley'],
  methods: {
      deleteAlley(alleyNum) {
          let requestData = {
              headers: {
                  "Authorization": `Bearer ${JSON.parse(sessionStorage.getItem('token'))}`
              },
              alley: alleyNum
          }
          console.log(JSON.stringify(requestData));
          axios.post(`http://localhost:8082/api/warehouse/remove/alley`, requestData)
              .then(
                  (res) => {
                      if (res.status !== 200) {
                          this.alerts.push({
                              type: 'error',
                              title: 'Nie udało się usunąć alejki, spróbuj ponownie później'
                          });
                      } else {
                          this.alerts.push({
                              type: 'success',
                              title: 'Usunięto alejkę'
                          });
                      }
                  }
              )
              .catch(
                  () => {
                      this.alerts.push({
                          type: 'error',
                          title: 'Nie udało się dodać alejki, spróbuj ponownie później'
                      });
                  }
              )
          ;
      }
  },
  data () {
    return {
      dialogm1: '',
      dialog: false,
      alerts: []
    }
  }
}
</script>

<style scoped>

</style>