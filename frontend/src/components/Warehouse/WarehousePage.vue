<template>
  <v-card>
    <v-container fluid>
      <h1>Struktura magazynu</h1>
      <v-row dense class="pb-10 pt-10">
        <v-col v-for="alley in scheme" :key="alley.alleyNum">
          <AlleyComponent :alley="alley"/>
        </v-col>
      </v-row>
      <v-row dense>
        <v-col>
          <AddAlleyComponent/>
        </v-col>
      </v-row>
    </v-container>
  </v-card>
</template>

<script>
import axios from "axios";
import AlleyComponent from "@/components/Warehouse/AlleyComponent";
import AddAlleyComponent from "@/components/Warehouse/AddAlleyComponent";

export default {
  name: "WarehousePage",
  components: {AddAlleyComponent, AlleyComponent},
  data() {
    return {
      config: {
        headers: {
          "Authorization": `Bearer ${JSON.parse(sessionStorage.getItem('token'))}`
        }
      },
      scheme: []
    }
  },
  created() {
    if (null == sessionStorage.getItem('token')) {
      this.$router.push('/login');
    }
  },
  mounted() {
    axios.get(`http://localhost:8082/api/warehouse/scheme`, this.config)
        .then(response => {
          if (response.status !== 200) {
            this.$router.push('/');
          }
          this.scheme = response.data
          console.log(this.scheme[0].alleyNum);
          console.log(JSON.stringify(this.scheme));
        })
        .catch( e => {
          this.errors.push(e)
          this.$router.push('/');
        });
  },
  unmounted() {}
}
</script>
<style></style>

