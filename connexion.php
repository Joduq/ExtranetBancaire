<?php
session_start();
setcookie('login', '', time() + 365*24*3600, null, null, false, true); // On écrit un cookie
setcookie('pass_hash', '', time() + 365*24*3600, null, null, false, true); // On écrit un autre cookie...

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
<form action="connexion.php" method="post">
    <p>
    <label for="pseudo">pseudo :</label> 
    <input type="text" name="pseudo" id="pseudo" value="<?php echo $_POST['pseudo'] ?>"/><br/>
    <label for="mdp">mot de passe :</label>
    <input type="password" name="mdp" id="mdp" value="<?php echo $_POST['mdp'] ?>"/><br/>
    <input type="checkbox" name="connexion" id="connexion" /> <label for="connexion">connexion automatique</label><br />
    <input type="submit" value="Se connecter"/>
    </p>
  </form>
  <a href="">page d'accueil</a>

  <?php
$pseudo = $_POST['pseudo'] ;
try
{
$bdd = new PDO('mysql:host=localhost;dbname=espace_membre;charset=utf8', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}
//  Récupération de l'utilisateur et de son pass hashé
$req = $bdd->prepare('SELECT id, pass FROM membres WHERE pseudo = :pseudo');
$req->execute(array(
    'pseudo' => $pseudo));
$resultat = $req->fetch();

// Comparaison du pass envoyé via le formulaire avec la base
$isPasswordCorrect = password_verify($_POST['mdp'], $resultat['pass']);

if (!$resultat)
{
    echo 'Mauvais identifiant ou mot de passe !';
}
else
{
    if ($isPasswordCorrect) {
        $_SESSION['id'] = $resultat['id'];
        $_SESSION['pseudo'] = $pseudo;
        if ($_POST['connexion']){
          $_COOKIE['pass_hash'] =  password_hash($resultat['pass']);
          $_COOKIE['login'] = $pseudo;
        }
        echo $_COOKIE['login'];
        echo $_COOKIE['pass_hash'];
        echo 'Vous êtes connecté !';
    }
    else {
        echo 'Mauvais identifiant ou mot de passe !';
    }
}
?>
</body>
</html>