<template>
  <div class="rectangle">
    <div id="logo"><a href="/" class="tilelinklogo">FreeWMS</a></div>
    <div id="opis">Dostawy --> Magazynowanie --> Wysyłki</div>
    <div id="zegar">15/03/2023 | 05:55:55</div>
    <div style="clear: both;"></div>
  </div>
</template>

<script>
export default {
  name: "Header"
}
</script>

<style>
.rectangle
{
  width: 75%;
  margin: auto;
  text-align: center;
}
#logo {
  float: left;
  font-family: 'Josefin Sans', sans-serif;
  font-size: 65px;
  margin-top: 10px;
  margin-bottom: 0px;
  text-align: center;
}

a {
  color: white;
}

a:link {
  text-decoration: none;
}

a:visited {
  text-decoration: none;
}

a:hover {
  text-decoration: none;
}

a:active {
  text-decoration: none;
}

#opis {
  float: left;
  font-family: 'Josefin Sans', sans-serif;
  font-size: 18px;
  margin-top: 25px;
  margin-left: 40px;
  text-align: left;
  margin-bottom: 0px;
}

#zegar {
  float: left;
  font-family: 'Josefin Sans', sans-serif;
  font-size: 20px;
  margin-top: 0px;
  margin-bottom: 0px;
  text-align: left;
  padding: 22px;
}
</style>