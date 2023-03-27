<template>
  <div class="rectangle">
    <h1>LOGIN</h1>
    <p v-show="displayError" class="error">Nieprawidłowy email lub hasło!</p>
    <form @submit.prevent="login">
      <input v-model="username" placeholder="email" />
      <br />
      <br />
      <input v-model="password" placeholder="hasło" type="password" />
      <br />
      <br />
      <button type="submit">Login</button>
    </form>
    <p><router-link to="/register">Załóż konto</router-link></p>
  </div>
</template>

<script>
import axios from "axios";
export default {
  name: "Login",
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
        axios.post("http://localhost:8082/api/login_check", {
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
button {
  width: 50%;
  margin-top: 10px;
  padding: 10px;
  text-align: center;
}
p.error {
  color: red;
}
</style>