<template>
  <v-card>
    <v-container fluid>
      <v-row dense>
        <v-col v-for="page in pages" :key="page.title">
          <v-hover
              v-slot="{ isHovering, props }"
              open-delay="200"
          >
            <router-link :to="page.link" style="text-decoration: none; color: inherit;">
              <v-card :elevation="isHovering ? 24 : 1" :class="{ 'on-hover': isHovering }"  v-bind="props">
                <v-img :src="page.image" class="align-end"
                       gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"
                       height="400px"
                       cover
                >
                  <v-card-title class="text-white" v-text="page.title"></v-card-title>
                </v-img>
              </v-card>
            </router-link>
          </v-hover>
        </v-col>
      </v-row>
      <v-row dense>
        <v-col>
            <v-hover
                v-slot="{ isHovering, props }"
                open-delay="200"
            >
              <v-card
                  :elevation="isHovering ? 24 : 1"
                  :class="{ 'on-hover': isHovering }"
                  v-bind="props"
                  style="background: #ee5a32; text-align: center"
              >
                <router-link to="/user" style="text-decoration: none; color: inherit;">
                  <v-card-text>ZALOGOWANY UŻYTKOWNIK: {{username}}</v-card-text>
                </router-link>
              </v-card>
            </v-hover>
        </v-col>
      </v-row>
    </v-container>
  </v-card>
</template>

<script>
import axios from "axios";

export default {
  name: "HomePage",
  data() {
    return {
      username: "Magazynier1",
      pages: [
        {title: "UŻYTKOWNIK", link: "/user", image: "https://lh3.googleusercontent.com/orTN6U5yXoSTgVzGfPNTmpzsVcP8TkDHGBEp2w__RuouDNosrT_S5D3MuAhSYkwsZG8=w2400"},
        {title: "DOSTAWY", link: "/public", image: "https://lh4.googleusercontent.com/QJ08cX9JdI1gvw_fSXgwzc8G7HxBw3-xgstJk_ObtTt6GOU1okaaFKp06KBO6QblZhY=w2400"},
        {title: "PRODUKTY", link: "/product/list", image: "https://lh5.googleusercontent.com/Ld-cSP6jh1hDLD43iqijBxKd9O-23UPVGu4mS8VCW0a9HV8SrZDA5gJO6mCvLc0dFtA=w2400"},
        {title: "WYSYŁKI", link: "/public", image: "https://lh3.googleusercontent.com/_Y5SDND28aBII8s2zVcgL9r1OwaK50wtklIewc8boL5FCLhGEWWz6O2RRSVTUm-j6js=w2400"},
        {title: "MAGAZYN", link: "/warehouse/scheme", image: "https://lh3.googleusercontent.com/_Y5SDND28aBII8s2zVcgL9r1OwaK50wtklIewc8boL5FCLhGEWWz6O2RRSVTUm-j6js=w2400"},
      ]
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

<style lang="sass" scoped>
.v-card.on-hover.v-theme--dark
  background-color: rgba(#FFF, 0.8)
  >.v-card__text
    color: #000
</style>