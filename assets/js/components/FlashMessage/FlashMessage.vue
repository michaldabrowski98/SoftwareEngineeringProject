<template>
  <div class="rectangle" :class="type" v-show="displayMessage">
    <div class="message">{{ message }}</div><div class="close" @click="hideFlashMessage()">x</div>
  </div>
</template>

<script>
export default {
  name: "FlashMessage",
  props: ['message', 'type'],
  data() {
    return {
      displayMessage: true
    }
  },
  methods: {
    hideFlashMessage() {
      this.displayMessage = false;
    }
  }
}
</script>

<style scoped>
.rectangle {
  width: 75%;
  margin: auto;
  text-align: left;
  height: 10%;
  border: 1px solid white;
}
div.message {
  width: 75%;
}
div.close {
  width: 25%;
}
div.success {
  background: lawngreen;
}

div.error {
  background: red;
}
</style>
