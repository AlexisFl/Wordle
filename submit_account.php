<?php
session_start();

include_once('menu.php');
include_once('popup.php');
$postData = $_POST;

if (!isset($postData['password']) || !isset($postData['pseudo']))
{
	echo('Remplissez correctement.');
    return;
}	

$pseudo = $postData['pseudo'];
$pw = hash("sha256", $postData['password']);
//echo "<h1>",$pw,"</h1>";
try
{
    $userStatement = $mysqlConnection->prepare('SELECT pseudo FROM compte');
    $userStatement->execute();
    $utilisateurs = $userStatement->fetchAll();
    $continue = true;
    $pwsize = true;

    if (strlen($pw) < 8){
        $pwsize = false;
        $continue = false;
    }

    foreach ($utilisateurs as $user) {
        if ($user['pseudo'] === $pseudo){
            $continue = false;
        }
    }

    if ($continue === true){
        $newuserStatement = $mysqlConnection->prepare('INSERT INTO compte (pseudo, password) VALUES (:ps, :pw)');
        $newuserStatement->execute([
            'ps' => $pseudo,
            'pw' => $pw,
        ]);
    } 
}
catch (Exception $e)
{
    die('Erreur : ' . $e->getMessage());
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wordle - Creer un compte</title>
    <link rel="stylesheet" href="home.css">
        <link rel="stylesheet" href="game.css">
        <link rel="stylesheet" href="rank.css">
        <link rel="stylesheet" href="home.css">
        <script src="squi.js" defer></script>
</head>
<body>
    <div class="container">

    <?php 
    if ($continue){
        echo '<h1>Votre compte a été créé !<br><br>Bienvenue '.$pseudo.' !</h1><br><br>
        <a href="home.php">Retourner au menu</a><br><br>
        <a href="submit_account.php#divTwo">Se connecter</a>';
    }
    elseif (!$pwsize) {
        echo '<h1>Le mot de passe doit faire au moins 8 caractères !</h1>
        <a href="home.php">Retourner au menu</a>';
    }
    elseif (!$continue) {
        echo "<h1>Ce nom d'utilisateur est déjà utilisé...</h1>
        <a href='home.php'>Retourner au menu</a>";
    }
    ?>
        
        
</body>
</html>