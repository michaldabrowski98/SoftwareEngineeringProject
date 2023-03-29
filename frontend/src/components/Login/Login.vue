<template>
  <v-container fluid style="height: 70vh">
    <v-sheet width="50%" class="mx-auto pa-12" rounded="true">
      <h1>LOGIN</h1>
      <v-form fast-fail @submit.prevent="login">
        <v-text-field v-model="username" placeholder="email" />
        <v-text-field v-model="password" placeholder="hasło" type="password"/>
        <v-btn type="submit" block class="mt-2" style="background:#ee5a32">Login</v-btn>
      </v-form>
      <router-link to="/register">Załóż konto</router-link>
    </v-sheet>
  </v-container>
</template>

<script>
import axios from "axios";
export default {
  name: "LoginPage",
  data: () => {
    return {
      username: "",
      password: "",
      displayError: false,
    };
  },
  methods: {
    login(e) {
      e.preventDefault();
      if (this.username.length === 0 || this.password.length === 0) {
        this.displayError = true;
      } else {
        axios.post("http://localhost:8080/api/login_check", {
          username: this.username,
          password: this.password,
          headers: {
            "Content-Type": "application/json",
          },
        }).then(
            (res) => {
              sessionStorage.setItem('token', JSON.stringify(res.data.token));
              this.$router.push('/');
            }
        ).catch(
            () => {
              this.displayError = true;
            }
        );
      }
    },
  },
  created() {
    if (null != sessionStorage.getItem('token')) {
      this.$router.push('/');
    }
  }
}
</script>

<style scoped>
</style>