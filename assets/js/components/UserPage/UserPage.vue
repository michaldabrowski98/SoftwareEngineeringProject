<template>
  <div class="rectangle">
    <h1>Konto użytkownika</h1>
    <h3>Użytkownik: <i>{{this.name}}</i></h3>
    <h3>Adres e-mail: <i>{{this.email}}</i></h3>
    <h3>Data utworzenia konta: <i>{{this.createdDate}}</i></h3>
  </div>
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
      axios.get(`http://localhost:8080/api/user/data`, config)
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
.rectangle {
  width: 75%;
  margin: auto;
  text-align: left;
  background: #666B85;
  padding: 30px;
}
</style>