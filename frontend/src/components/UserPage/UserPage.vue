<template>
  <v-card class="mx-auto"
          max-width="75vw">
    <v-img
        class="align-end text-white"
        height="300"
        src="https://images.unsplash.com/photo-1587293852726-70cdb56c2866?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxzZWFyY2h8NHx8d2FyZWhvdXNlfGVufDB8fDB8fA%3D%3D&w=1000&q=80"
        cover
    >
      <v-card-title>Konto użytkownika</v-card-title>
    </v-img>
    <v-card-subtitle class="pt-4">
      Dane osobowe
    </v-card-subtitle>
    <v-card-text>
      <div>Użytkownik: <i>{{this.name}}</i></div><br/>
      <div>Adres e-mail: <i>{{this.email}}</i></div><br/>
      <div>Data utworzenia konta: <i>{{this.createdDate}}</i></div>
    </v-card-text>
    <v-card-actions>
      <v-btn color="white" style="background:#ee5a32" @click="logout">
        Wyloguj
      </v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
import axios from "axios";

export default {
  name: "UserPage",
  data() {
    return {
      name: "",
      email: "",
      createdDate: null
    }
  },
  methods: {
    logout() {
      sessionStorage.removeItem('token');
      this.$router.push('/login');
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

    if (null == sessionStorage.getItem('userData')) {
      axios.get(`http://localhost:8082/api/user/data`, config)
          .then(response => {
            if (response.status !== 200) {
              this.$router.push('/login');
            }
            sessionStorage.setItem('userData',  JSON.stringify(response.data));
            this.name = response.data.name;
            this.email = response.data.email;
            this.createdDate = response.data.createdAt.date;
          })
          .catch( e => {
            this.errors.push(e)
            this.$router.push('/login');
          });
    } else {
      const userData = JSON.parse(sessionStorage.getItem('userData'));
      this.name = userData.name;
      this.email = userData.email;
      this.createdDate = userData.createdAt.date;
    }
  }
}
</script>

<style scoped>
</style>