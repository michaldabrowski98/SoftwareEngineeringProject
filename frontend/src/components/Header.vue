<template>
  <v-app-bar>
    <v-app-bar-title>
      <a href="/public" style="text-decoration: none; color: inherit;">FreeWMS</a>
    </v-app-bar-title>
    <v-app-bar-title>Dostawy --> Magazynowanie --> Wysyłki</v-app-bar-title>
    <v-app-bar-title>{{ currentDate }}</v-app-bar-title>
  </v-app-bar>
</template>
<script>
export default {
  name: "HeaderComponent",
  data() {
    return {
      currentDate: this.getCurrentDateTime()
    }
  },
  created() {
    setInterval(() => {
      this.currentDate = this.getCurrentDateTime();
    }, 1000);
  },
  methods: {
    getCurrentDateTime() {
      const now = new Date();
      return now.toLocaleString();
    }
  }
}
</script>

<style>
</style>