<?php
session_start();

include_once('menu.php'); 

$postData = $_POST;
// Validation du formulaire
if (isset($_POST['pseudo']) &&  isset($_POST['password'])) {
    $pseudo = $_POST['pseudo'];
    $pw = hash("sha256", $_POST['password']);
    try
    {
        $userStatement = $mysqlConnection->prepare('SELECT id, pseudo, password FROM compte');
        $userStatement->execute();
        $utilisateurs = $userStatement->fetchAll();
        foreach ($utilisateurs as $user) {
            if ($user['pseudo'] === $pseudo && $user['password'] === $pw)
            {
                $loggedUser = [
                    'pseudo' => $user['pseudo'],
                ];
                $_SESSION['LOGGED_USER'] = $pseudo;
                $_SESSION['ID'] = $user['id'];
            } else {
                $errorMessage = sprintf('<h1>Les informations envoyées ne permettent pas de vous identifier : (%s/%s)</h1>',
                    $_POST['pseudo'],
                    $_POST['password']
                );
            }
        }
    }
    catch (Exception $e)
    {
        die('Erreur : ' . $e->getMessage());
    }
}
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
</body>
</html>

<!--
   Si utilisateur/trice est non identifié(e), on affiche le formulaire
-->
<?php if(!isset($_SESSION['LOGGED_USER'])): ?>
    <div class="alert alert-danger" role="alert">
            <?php echo $errorMessage; ?>
            <a href='home.php'>Retourner au menu</a>
        </div>
<!-- 
    Si utilisateur/trice bien connectée on affiche un message de succès
-->
<?php else: ?>
    <?php
    
    $getIDStatement = $mysqlConnection->prepare('SELECT id, pseudo FROM compte WHERE pseudo = :ps');
    $getIDStatement->execute([
        'ps' => $pseudo,
    ]);
    $user = $getIDStatement->fetchAll(); 
    ?>
    <div class="alert alert-success" role="alert">
        <h1>Bonjour <?php echo $_SESSION['LOGGED_USER']; ?> et bienvenue sur le site ! <a href="home.php?id=<?php echo $user[0]['id']; ?>">Retourner au menu</a></h1>
    </div>
<?php endif;?>