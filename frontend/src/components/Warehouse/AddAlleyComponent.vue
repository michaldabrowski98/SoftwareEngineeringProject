<template>
  <v-row justify="center">
    <v-dialog
        v-model="dialog"
        fullscreen
        :scrim="false"
        transition="dialog-bottom-transition"
    >
      <template v-slot:activator="{ props }">
        <v-btn
            color="#ee5a32"
            v-bind="props"
            style="width: 100vw; font-size: 30px"
        >
          +
        </v-btn>
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
          <v-toolbar-title>Dodaj alejkę</v-toolbar-title>
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
          <v-list-subheader>Nowa alejka</v-list-subheader>
          <v-form fast-fail @submit.prevent="register">

          </v-form>
          <v-list-item title="Ilość regałów" subtitle="Całkowita ilość regałów z których będzie składała się alejka">
            <v-slider
                v-model="columns"
                track-color="#ee5a32"
                class="ml-4"
                max="50"
                min="0"
                step=1
            >
              <template v-slot:append>
                <v-text-field
                    v-model="columns"
                    hide-details
                    single-line
                    density="compact"
                    type="number"
                    style="width: 70px"
                ></v-text-field>
              </template>
            </v-slider>
          </v-list-item>
          <v-list-item title="Ilość półek" subtitle="Ilość półek z ilu będzie składał się regał">
            <v-slider
                v-model="shelfs"
                track-color="#ee5a32"
                class="ml-4"
                max="20"
                min="0"
                step=1
            >
              <template v-slot:append>
                <v-text-field
                    v-model="shelfs"
                    hide-details
                    single-line
                    density="compact"
                    type="number"
                    style="width: 70px"
                ></v-text-field>
              </template>
            </v-slider>
          </v-list-item>
          <v-list-item title="Maksymalne obciążenie" subtitle="Maksymalne obciążenie pojedynczej półki">
            <v-slider
                v-model="maxWeight"
                track-color="#ee5a32"
                class="ml-4"
                max="5000"
                min="0"
                step=1
            >
              <template v-slot:append>
                <v-text-field
                    v-model="maxWeight"
                    hide-details
                    single-line
                    density="compact"
                    type="number"
                    style="width: 70px"
                ></v-text-field>
              </template>
            </v-slider>
          </v-list-item>
        </v-list>
        <v-divider></v-divider>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>
import axios from "axios";

export default {
  name: "AddAlleyComponent",
  methods: {
    save() {
      let requestData = {
        colNum: this.columns,
        shelfNum: this.shelfs,
        maxWeight: this.maxWeight,
        headers: {
          "Authorization": `Bearer ${JSON.parse(sessionStorage.getItem('token'))}`
        }
      }
      axios.put(`http://localhost:8082/api/warehouse/new/alley`, requestData)
          .then(
              (res) => {
                if (res.status !== 200) {
                  this.alerts.push({
                    type: 'error',
                    title: 'Nie udało się dodać alejki, spróbuj ponownie później'
                  });
                } else {
                  this.alerts.push({
                    type: 'success',
                    title: 'Dodano nową alejkę'
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
      dialog: false,
      notifications: false,
      sound: true,
      widgets: false,
      columns: 0,
      shelfs: 0,
      maxWeight: 0,
      alerts: []
    }
  },
}
</script>

<style>
</style>