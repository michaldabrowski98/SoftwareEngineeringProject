<template>
  <v-container fluid style="height: 70vh">
    <v-sheet width="50%" class="mx-auto pa-12" rounded="true">
      <h1>Rejestracja</h1>
      <v-form fast-fail @submit.prevent="register">
        <v-text-field v-model="email" placeholder="email" :rules="emailRules" />
        <v-text-field v-model="password" placeholder="hasło" type="password" :rules="passwordRules" />
        <v-text-field v-model="firstName" placeholder="imię" type="text" :rules="nameRules" />
        <v-text-field v-model="lastName" placeholder="nazwisko" type="text" :rules="nameRules" />
        <v-select v-model="roles" label="Stanowisko"
                  :items="['Administrator', 'Kierownik', 'Magazynier']"
                  :rules="roleRules"
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
      emailRules: [
        v => !!v || 'Pole email jest wymagane',
        v => /.+@.+\..+/.test(v) || 'Adres email musi być poprawny',
      ],
      passwordRules: [
        v => !!v || 'Pole hasło jest wymagane',
        v => v.length >= 6 || 'Hasło musi mieć przynajmniej 6 znaków',
      ],
      nameRules: [
        v => !!v || 'Pole imię/nazwisko jest wymagane',
        v => /^[a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ ]+$/.test(v) || 'Pole imię/nazwisko może zawierać tylko litery',
      ],
      roleRules: [
        v => !!v.length || 'Stanowisko jest wymagane',
      ],
      displayError: false,
      displaySuccess: false,
      message: "",


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
        axios.post("http://localhost:8080/api/register", {
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
