<template>
  <v-container fluid style="height: 70vh">
    <v-sheet width="50%" class="mx-auto pa-12" rounded="true">
      <h1>Rejestracja</h1>
    <v-form fast-fail @submit.prevent="register">
      <v-text-field v-model="email" placeholder="email" />
      <v-text-field v-model="password" placeholder="hasło" type="password" />
      <v-text-field v-model="firstName" placeholder="imię" type="text" />
      <v-text-field v-model="lastName" placeholder="nazwisko" type="text" />
      <v-select v-model="roles" label="Stanowisko"
        :items="['Administrator', 'Kierownik', 'Magazynier']"
        >
      </v-select>
      <v-btn type="submit" block class="mt-2" style="background:#ee5a32">Załóż konto</v-btn>
    </v-form>
    </v-sheet>
  </v-container>
</template>

<script>
import axios from "axios";

export default {
  name: "RegistrationPage",
  data() {
    return {
      email: "",
      password: "",
      firstName: "",
      lastName: "",
      roles: [],
      displayError: false,
      displaySuccess: false,
      message: ""
    }
  },
  methods: {
    register(e) {
      e.preventDefault();
      if (
          this.email.length === 0
          || this.password.length === 0
          || this.firstName.length === 0
          || this.lastName.length === 0
      ) {
        this.displayError = true;
      } else {
        axios.post("http://localhost:8082/api/register", {
          email: this.email,
          password: this.password,
          firstName: this.firstName,
          lastName: this.lastName,
          roles: [
              this.roles
          ],
          headers: {
            "Content-Type": "application/json",
          },
        }).then(
            () => {
              this.displaySuccess = true;
            }
        ).catch(
            () => {
              this.displayError = true;
            }
        );
      }
    }
  }
}
</script>

<style scoped>
</style>
