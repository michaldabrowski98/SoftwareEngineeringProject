<template>
  <div class="rectangle">
    <div class="nav1"><a href="/user" class="tilelink">UŻYTKOWNIK<img src="../../images/BUT_UZY.jpg" width="220" height="200"></a></div>
    <div class="nav1"><a href="/" class="tilelink">DOSTAWY<img src="../../images/BUT_DOST.jpg" width="220" height="200"></a></div>
    <div class="nav1"><a href="/product/list" class="tilelink">MAGAZYN<img src="../../images/BUT_MAG.jpg" width="220" height="200"></a></div>
    <div class="nav1"><a href="/" class="tilelink">WYSYŁKI<img src="../../images/BUT_WYS.jpg" width="220" height="200"></a></div>
    <div style="clear: both;"></div>
    <div class="nav2"><a href="/login" class="tilelink1">LOGOWANIE UŻYTKOWNIKA / ZALOGOWANY UŻYTKOWNIK: {{username}}</a></div>
    <div style="clear: both;"></div>
  </div>

  <div class="rectangle">
    <div class="tilecontent"></div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "Home",
  data() {
    return {
      username: "Magazynier1"
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
            this.username = response.data.name;
          })
          .catch( e => {
            this.errors.push(e)
            this.$router.push('/login');
          });
    } else {
      const userData = JSON.parse(sessionStorage.getItem('userData'));
      this.username = userData.name;
    }
  }
};
</script>

<style>
.rectangle {
  width: 75%;
  margin: auto;
  text-align: center;
}
.nav1
{
  margin: 10px;
  width: 220px;
  height: 220px;
  background-color: #3095d3;
  float: left;
  font-size: 20px;
}

.nav1:hover
{
  background-color: #2084c2;
  font-size: 23px;
}

.nav2
{
  margin: 10px;
  width: 940px;
  height: 30px;
  background-color: #3095d3;
  float: center;
  font-size: 20px;
}

.nav2:hover
{
  background-color: #2084c2;
  font-size: 23px;
}

a.tilelink
{
  color: #ffffff;
  text-decoration: none;
  display: block;
  width: 220px;
  height: 30px;
}

a.tilelink1
{
  color: #ffffff;
  text-decoration: none;
  display: block;
  width: 940px;
  height: 30px;
}

a.tilelinklogo
{
  color: #ffffff;
  text-decoration: none;
}

.tilecontent
{
  margin: 10px;
  width: 75%;
  height: 110px;
  background-color: #303030;
  text-align: justify;
  padding: 30px;
  font-family: arial;
}
</style>