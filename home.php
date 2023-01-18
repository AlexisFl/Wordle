<?php
session_start(); 
include_once('menu.php'); 

/*
try
{
  	$oldWStatement = $mysqlConnection->prepare('SELECT * FROM tirage WHERE date_t >= date_sub(now(), interval 180 day)');
 	$oldWStatement->execute() or die(print_r($mysqlConnection->errorInfo()));
  	$infos = $oldWStatement->fetchAll();
}
catch (Exception $e)
{
    die('Erreur : ' . $e->getMessage());
}*/


?>

<!DOCTYPE html>
<html>
    <head>
        <title>Wordle</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="home.css">
        <link rel="stylesheet" href="game.css">
        <script src="squi.js" defer></script>
        
    </head>

    <body > 
    <?php 
    include_once('popup.php');
    ?>
        <div class="menu">
          <a href="play.php?score=0"><button id="mdj">Mot du jour</button></a>
          <br><br>
          <h3> Ou choisir une difficulté </h3>
          <a href="play.php?level=1&score=0"><button id="facile">Facile</button></a>
          <a href="play.php?level=2&score=0"><button id="moyen">Moyen</button></a>
          <a href="play.php?level=3&score=0"><button id="difficile">Difficile</button></a>
        </div>
    </body>
</html>