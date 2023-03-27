<template>
  <div class="rectangle">
    <h1>Rejestracja</h1>
    <div v-show="displaySuccess"><FlashMessage message="Konto zostało utworzone!" type="success"/></div>
    <div v-show="displayError"><FlashMessage message="Wystąpił błąd! Sprawdź poprawność podanych danych." type="error"/></div>
    <form @submit.prevent="register">
      <input v-model="email" placeholder="email" />
      <br />
      <br />
      <input v-model="password" placeholder="hasło" type="password" />
      <br />
      <br />
      <input v-model="firstName" placeholder="imię" type="text" />
      <br />
      <br />
      <input v-model="lastName" placeholder="nazwisko" type="text" />
      <br />
      <br />
      <select v-model="roles">
        <option value="ROLE_USER_ADMIN">Administrator</option>
        <option value="ROLES_USER_MANAGER">Kierownik</option>
        <option value="ROLE_USER_REGULAR_WORKER">Magazynier</option>
      </select>
      <br />
      <br />
      <button type="submit">Załóż konto</button>
    </form>
  </div>
</template>

<script>
import axios from "axios";
import FlashMessage from "../FlashMessage/FlashMessage";

export default {
  name: "Registration",
  components: {FlashMessage},
  data() {
    return {
      email: "",
      password: "",
      firstName: "",
      lastName: "",
      roles: [],
      displayError: false,
      displaySuccess: false,
      flashMessageText: "",
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
.rectangle {
  width: 75%;
  margin: auto;
  text-align: left;
  background: #666B85;
  padding: 30px;
}
input {
  width: 80%;
  padding: 10px;
}
select {
  width: 80%;
  padding: 10px;
}
button {
  width: 50%;
  margin-top: 10px;
  padding: 10px;
  text-align: center;
}
</style>
