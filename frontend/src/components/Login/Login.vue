<template>
  <v-container fluid style="height: 70vh">
    <v-sheet width="50%" class="mx-auto pa-12" rounded="true">
      <h1>LOGIN</h1>
      <v-form fast-fail @submit.prevent="login">
        <v-text-field v-model="username" placeholder="email" :rules="usernameRules" />
        <v-text-field v-model="password" placeholder="hasło" type="password" :rules="passwordRules" />
        <v-btn type="submit" block class="mt-2" style="background:#ee5a32">Login</v-btn>
      </v-form>

      <v-btn type="submit" block class="mt-2" style="background:#ee5a32">
        <router-link to="/register">Załóż konto</router-link></v-btn>

      <v-alert
          color="info"
          icon="$warning"
          title="Sprawdzam dane..."
          v-model="zaczekaj"
      ></v-alert>

      <v-alert
          color="error"
          icon="$error"
          title="Błąd."
          text="Logowanie nie powiodło się. Sprawdź poprawność danych."
          v-model="displayError"
      ></v-alert>

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
      usernameRules: [
        v => !!v || 'Pole email jest wymagane',
        v => /.+@.+\..+/.test(v) || 'Adres email musi być poprawny',
      ],
      passwordRules: [
        v => !!v || 'Pole hasło jest wymagane',
        v => v.length >= 6 || 'Hasło musi mieć przynajmniej 6 znaków',
      ],
      displayError: false,
      zaczekaj: false,
    };
  },
  methods: {
    login(e) {
      e.preventDefault();
      if (this.username.length === 0 || this.password.length === 0) {
        this.displayError = true;
      } else {
        this.zaczekaj = true;
        axios.post("http://localhost:8082/api/login_check", {
          username: this.username,
          password: this.password,


          headers: {
            "Content-Type": "application/json",

          },
        }).then(
            (res) => {
              this.displaySuccess = true;
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