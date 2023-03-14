<template>
  <div class="header">
    <div id="logo"><h1>FreeWMS</h1></div>
    <div id="motto"><h3>lorem -> ipsum -> sssass</h3></div>
    <div id="clock"><h2>17:00:00</h2></div>
  </div>
</template>

<script>
export default {
  name: "Header"
}
</script>

<style>
  .header {
    background: #282828;
    color: white;
    font-family: Cursor;
    width: 70%;
    margin: auto;
  }
  #logo {
    float:left;
    background:#282828;
    width:25%;
    height:80px;
  }
  #motto{
    float:left;
    background:#282828;
    width:50%;
    height:80px;
  }
  #clock{
    float:right;
    background:#282828;
    width:25%;
    height:80px;
  }
</style>