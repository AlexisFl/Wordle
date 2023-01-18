<?php
//include_once('get_mot.php');
//include_once('header.html');

if (!isset($_COOKIE["theme"])){
  setcookie("theme", "light", time()+30*24*3600, "/");
  //echo '<h1>if pas set</h1>';
}
if (isset($_COOKIE["theme"])){
  //echo '<h1>if set</h1>';
  if ($_COOKIE["theme"] == "dark"){
      echo '<h1></h1>
      <script>
      var element = document.body;
      element.classList.toggle("dark-mode");
      </script>';
  }
}

try
{
  $mysqlConnection = new PDO('mysql:host=localhost;dbname=Wordle;charset=utf8', 'root', 'M587$2HPk!', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
  $oldWStatement = $mysqlConnection->prepare('SELECT * FROM tirage WHERE date_t >= date_sub(now(), interval 180 day) ORDER BY date_t DESC');
  $oldWStatement->execute() or die(print_r($mysqlConnection->errorInfo()));
  $infos = $oldWStatement->fetchAll();
}
catch (Exception $e)
{
    die('Erreur : ' . $e->getMessage());
}
?>
<style>
  a:link { text-decoration: none; }
  a:active { text-decoration: none; }
  a:focus { text-decoration: none; }
  a:visited { text-decoration: none; }
</style>

<header>
    <nav class="side-nav">
      <div class="wrapper">
        <div class="nav-bloc n-1">
        <img src="images/calendar.png" alt="Photo de calendrier">
          <div class="sub-nav">
            <h2>Anciens MDJ</h2>
            <ul>
              <?php 
              foreach ($infos as $info) {
                echo '<a href="play.php?score=0&date='.$info['date_t'].'"><li>'.$info['date_t'].'</li></a>';
              }
              ?>
            </ul>
          </div>
        </div>

        <div class="nav-bloc n-2">
        <img src="images/user.png" alt="Photo de user">
          <div class="sub-nav">
            <?php 
            if (isset($_SESSION['LOGGED_USER'])){
              echo '<h2>'.$_SESSION['LOGGED_USER'].'</h2>';
              
            }
            else {
              echo '<h2>Compte</h2>
              <ul>
              <a href="#divTwo">
              <li>
              Connexion
              </li></a>
              <a href="#divOne">
              <li>
                Inscription
              </li></a>
              </ul>';
            }
            ?>
            
          </div>
        </div>
        <a href="rank.php">
        <div class="nav-bloc n-4">
          <img src="images/rank.png" alt="Photo de rank"> 
        </div>
        </a>
        <a href="#divThree">
        <div class="nav-bloc n-3">
          <img src="images/help1.png" alt="Photo de ?"> 
        </div>
        </a>
        <?php
        if (isset($_SESSION['ID'])){
          echo '<a href="logout.php">
          <div class="nav-bloc n-4">
            <img src="images/logout.png" alt="Photo de logout"> 
          </div>
          </a>';
        }?>
        <a onclick="darkMode()" href="#">
        <div class="nav-bloc n-3">
          <img src="images/theme.png" alt="Photo de theme"> 
        </div>
        </a>
    </div>
    </nav>
</header>

<a href="index.php"><h1 id="title">Wordle</h1></a>

<br><br>
