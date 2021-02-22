<?php
session_start();
// if(!$_SESSION['connexion']){
  // setcookie('username','', time() + 365*24*3600,'/','/tests/ExtranetBancaire/');
  // setcookie('password','', time() + 365*24*3600);
// }

// Et SEULEMENT MAINTENANT, on peut commencer à écrire du code html
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>connexion</title>
</head>
<body>
<?php include("header.php"); ?>

<form action="" method="post">
    <p>
    <label for="username">Username :</label> 
    <input type="text" name="username" id="username" value="<?php echo $_POST['username'] ?>"/><br/>
    <label for="password">mot de passe :</label>
    <input type="password" name="password" id="password" value="<?php echo $_POST['password'] ?>"/><br/>
    <input type="checkbox" name="connexion" id="connexion" /> <label for="connexion">connexion automatique</label><br />
    <input type="submit" value="Se connecter"/>
    </p>
  </form>
  <a href="">page d'accueil</a>
  <a href="oublie.php">mot de passe oublié?</a>
  <?php

$username = $_POST['username'];

try
{
$bdd = new PDO('mysql:host=localhost;dbname=extranet_bancaire;charset=utf8', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}
//  Récupération de l'utilisateur et de son pass hashé
$req = $bdd->prepare('SELECT id_user, password, prenom, nom FROM accounts WHERE username = :username');
$req->execute(array(
    'username' => $username));
$resultat = $req->fetch();

// Comparaison du pass envoyé via le formulaire avec la base
$isPasswordCorrect = password_verify($_POST['password'], $resultat['password']);

if (!$resultat)
{
    echo 'Mauvais identifiant ou mot de passe !';
}
else
{
    if ($isPasswordCorrect) {
        $_SESSION['id_user'] = $resultat['id_user'];
        $_SESSION['prenom'] = $resultat['prenom'];
        $_SESSION['nom'] = $resultat['nom'];
        $_SESSION['username'] = $username;
        // if ($_POST['connexion']){
          
        //   $_COOKIE['password'] = password_hash($resultat['password']);;
        //   $_COOKIE['username'] = $username;

        // }
 
        header("location: acteurs.php");
    }
    else {
        echo 'Mauvais identifiant ou mot de passe !';
    }
}
?>
<?php include("footer.php"); ?>
</body>
</html>