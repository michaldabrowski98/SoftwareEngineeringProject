<template>
  <v-row justify="center">
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
              @click="dialog = false"
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
export default {
  name: "AlleyComponent",
  props: ['alley'],
  data () {
    return {
      dialogm1: '',
      dialog: false,
    }
  },
}
</script>

<style scoped>

</style>