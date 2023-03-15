<template>
  <div class="rectangle">
    <div class="nav1"><a href="/user" class="tilelink">UŻYTKOWNICY<img src="../../images/BUT_UZY.jpg" width="220" height="200"></a></div>
    <div class="nav1"><a href="/" class="tilelink">DOSTAWY<img src="../../images/BUT_DOST.jpg" width="220" height="200"></a></div>
    <div class="nav1"><a href="/product/list" class="tilelink">MAGAZYN<img src="../../images/BUT_MAG.jpg" width="220" height="200"></a></div>
    <div class="nav1"><a href="/" class="tilelink">WYSYŁKI<img src="../../images/BUT_WYS.jpg" width="220" height="200"></a></div>
    <div style="clear: both;"></div>
    <div class="nav2"><a href="/" class="tilelink1">LOGOWANIE UŻYTKOWNIKA / ZALOGOWANY UŻYTKOWNIK: MAGAZYNIER 1</a></div>
    <div style="clear: both;"></div>
  </div>

  <div class="rectangle">
    <div class="tilecontent"></div>
  </div>
</template>

<script>
export default {
  name: "Home"
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

.nav3
{
  margin: 10px;
  width: 940px;
  height: 200px;
  background-color: #666666;
  float: left;
  font-size: 20px;
  text-indent: 10px;
  text-align: left;
}

.nav4
{
  margin: 10px;
  width: 940px;
  height: 30px;
  background-color: #666666;
  float: left;
  font-size: 20px;
  text-indent: 10px;
  text-align: left;
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