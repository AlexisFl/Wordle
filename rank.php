<?php 
include_once('menu.php'); 

session_start();
/*$getJoueurs = $mysqlConnection->prepare('SELECT DISTINCT pseudo FROM compte JOIN participation ON compte.id = participation.id_user');
$getJoueurs->execute() or die(print_r($mysqlConnection->errorInfo()));
$joueurs = $getJoueurs->fetchAll();
//var_dump($joueurs);*/
$getScores = $mysqlConnection->prepare('SELECT AVG(score_obtenu), id_user, pseudo FROM participation JOIN compte ON participation.id_user = compte.id GROUP BY id_user ORDER BY AVG(score_obtenu) DESC LIMIT 10');
$getScores->execute() or die(print_r($mysqlConnection->errorInfo()));
$s = $getScores->fetchAll();
//var_dump($s);

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Wordle</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="home.css">
        <link rel="stylesheet" href="game.css">
        <link rel="stylesheet" href="rank.css">
        <script src="squi.js" defer></script>
        
    </head>
    <body> 
        <?php
        include_once('popup.php'); 
        ?>

        <div class="table-title">
            <h1>Classement</h1>
        </div>
        <table class="table-fill">
            <thead>
                <tr>
                    <th class="text-left">Joueur</th>
                    <th class="text-left">Score moyen</th>
                </tr>
            </thead>
            <tbody class="table-hover">
                <?php 
                for ($i = 0; $i < count($s); $i++){
                    echo '<tr><td class="text-left">'.$s[$i]['pseudo'].'</td><td class="text-left">'.(int)$s[$i]['AVG(score_obtenu)'].'</td></tr>';
                } 
                ?>
            </tbody>
        </table>
    </div>
      

    </body>
</html>
