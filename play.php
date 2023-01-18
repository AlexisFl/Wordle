<?php
session_start();
include_once('menu.php');
$getData = $_GET;
$action = 0;

//echo '<h1>'.$_SESSION['ID'].$_SESSION['LOGGED_USER'].'</h1>';
if (isset($getData['level'])){
    $action = $getData['level'];
    //echo $action;
}

if (isset($getData['date'])){
    $date_mot = $getData['date'];
    $action = 4;
}

$date = date('y-m-d');
switch ($action){
    case 1:
        //echo "cas 1";
        try
        {
            $continue = false;
            while ($continue === false){
                $getmot = $mysqlConnection->prepare('SELECT mot, nb_lettres, taille FROM mots where id = :id');
                $randid = (random_int(0, 19127));
                $getmot->execute([
                    'id' => $randid,
                ]) or die(print_r($mysqlConnection->errorInfo()));
                $mot = $getmot->fetchAll(); 
                //echo "taille = ".$mot[0]['taille'];
                //echo $mot;
                if ($mot[0]['taille'] === '5' || $mot[0]['taille'] === '6'){
                    //echo "dans le if du while";
                    $continue = true;
                }
            }
        }
        catch (Exception $e)
        {
            die('Erreur : ' . $e->getMessage());
        }
        break;
    
    case 2:
        try
        {
            $continue = false;
            while ($continue === false){
                $getmot = $mysqlConnection->prepare('SELECT mot, nb_lettres, taille FROM mots where id = :id');
                $randid = (random_int(0, 19127));
                $getmot->execute([
                    'id' => $randid,
                ]) or die(print_r($mysqlConnection->errorInfo()));
                $mot = $getmot->fetchAll(); 
                //echo "taille = ".$mot[0]['taille'];
                //echo $mot;
                if ($mot[0]['taille'] === '7' || $mot[0]['taille'] === '8'){
                    //echo "dans le if du while";
                    $continue = true;
                }
            }
        }
        catch (Exception $e)
        {
            die('Erreur : ' . $e->getMessage());
        }
        break;
        
    case 3:
        try
        {
            $continue = false;
            while ($continue === false){
                $getmot = $mysqlConnection->prepare('SELECT mot, nb_lettres, taille FROM mots where id = :id');
                $randid = (random_int(0, 19127));
                $getmot->execute([
                    'id' => $randid,
                ]) or die(print_r($mysqlConnection->errorInfo()));
                $mot = $getmot->fetchAll(); 
                //echo "taille = ".$mot[0]['taille'];
                //echo $mot;
                if ($mot[0]['taille'] > '8'){
                    //echo "dans le if du while";
                    $continue = true;
                }
            }
        }
        catch (Exception $e)
        {
            die('Erreur : ' . $e->getMessage());
        }
        break;

    case 4:
        try
        {
            $getmot = $mysqlConnection->prepare('SELECT id_mot FROM tirage where date_t = :dm');
            $getmot->execute([
                'dm' => $date_mot,
            ]) or die(print_r($mysqlConnection->errorInfo()));
            $infos_mdj = $getmot->fetchAll(); 
            $idOldMot = $infos_mdj[0]['id_mot'];

            $getOldMot = $mysqlConnection->prepare('SELECT mot, nb_lettres FROM mots where id = :id');
            $getOldMot->execute([
                'id' => $idOldMot,
            ]) or die(print_r($mysqlConnection->errorInfo()));
            $mot = $getOldMot->fetchall();
        }
        catch (Exception $e)
        {
            die('Erreur : ' . $e->getMessage());
        }
        break;

    default:
        //echo "cas default";
        try
        {
            //echo '<h1>on rentre dans default</h1>';
            $playable = true;

            if (isset($_SESSION['ID'])){
                $checkPlayable = $mysqlConnection->prepare('SELECT id FROM participation WHERE date = :d AND id_user = :id');
                $checkPlayable->execute([
                    'd' => $date,
                    'id' => $_SESSION['ID'],
                ]) or die(print_r($mysqlConnection->errorInfo()));
                $playbaleinfos = $checkPlayable->fetchAll();

                if (isset($playbaleinfos[0]['id'])){
                    $playable = false;
                    //echo "<h1>Vous avez déjà participé aujourd'hui</h1>";
                }
            }

            if ($playable){
                //echo '<h1>bonjour</h1>';
                $randid = (random_int(0, 19127));
                $checkTirage = $mysqlConnection->prepare('SELECT id_tirage, date_t, id_mot FROM tirage where date_t = :d');
                $checkTirage->execute([
                    'd' => $date,
                ]) or die(print_r($mysqlConnection->errorInfo()));
                $tirage = $checkTirage->fetchAll();
                //echo '<h1>idt = '.$tirage[0]['id_tirage'].' date = '.$tirage[0]['date_t'].' idm = '.$tirage[0]['id_mot']; 

                if (!isset ($tirage[0]['id_tirage']) || !isset ($tirage[0]['date_t']) || !isset ($tirage[0]['id_mot'])){
                    $insertTirage = $mysqlConnection->prepare('INSERT INTO tirage (date_t, id_mot) VALUES (:date, :id_mot)');
                    $insertTirage->execute([
                        'date' => $date,
                        'id_mot' => $randid,
                    ]) or die(print_r($mysqlConnection->errorInfo()));

                    $faireTirage = $mysqlConnection->prepare('SELECT id_mot, id_tirage FROM tirage where date_t = :d');
                    $faireTirage->execute([
                        'd' => $date,
                    ]) or die(print_r($mysqlConnection->errorInfo()));
                    $tirage = $faireTirage->fetchAll();
                }

                $getmot = $mysqlConnection->prepare('SELECT mot, nb_lettres FROM mots where id = :id');
                $getmot->execute([
                    'id' => $tirage[0]['id_mot'],
                ]) or die(print_r($mysqlConnection->errorInfo()));
                $mot = $getmot->fetchAll();    
                $_SESSION['ID_TIRAGE'] = $tirage[0]['id_tirage'];
            }

            else {
                //echo 'Not playable';
            }
        }  
        catch (Exception $e)
        {
            die('Erreur : ' . $e->getMessage());
        }
        break;
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Wordle</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="game.css">
        <link rel="stylesheet" href="home.css">
        
        <script src="squi.js" defer></script>
        
    </head>
    <body>
        <?php
        include_once('popup.php'); 
        ?>
        <br>
        <?php 
        if (!isset($playable) || $playable){
        ?>
            <h2 id="score">Score : <?php echo $getData['score']; ?></h2><?php
        }
        else {
            echo "<h1>Vous avez déjà participé aujourd'hui !</h1>";
            echo "<h1>Revenez demain pour toujours plus de fun !!!</h1>";
        }
        ?>
        <div id="board" name="board">

        </div>
        <br>
        <h1 id="answer"></h1>
        <script> 
            var squid = "<?php echo $mot[0]['mot']; ?>";
            var nb_diff = "<?php echo $mot[0]['nb_lettres']; ?>";
            /*var taille = "<?php //echo $taille; ?>";*/
        </script>
        <?php 
        //echo $_SESSION['ID'];
        
        if (isset($_SESSION['ID'])){
            if ($getData['score'] > 0 && !isset($getData['level']) && $playable){
                $createParticipation = $mysqlConnection->prepare('INSERT INTO participation (id_tirage, id_user, date, score_obtenu) VALUES (:idt, :idu, :date, :score)');
                $createParticipation->execute([
                    'idt' => $_SESSION['ID_TIRAGE'],
                    'idu' => $_SESSION['ID'],
                    'date' => $date,
                    'score' => $getData['score'],
                ]) or die(print_r($mysqlConnection->errorInfo()));
                echo '<script type="text/JavaScript"> location.reload(); </script>';
            }
        }
        ?>  
    </body>
</html>