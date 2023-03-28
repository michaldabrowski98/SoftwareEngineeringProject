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
</style>
