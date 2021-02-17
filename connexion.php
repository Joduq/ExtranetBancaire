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
    <label for="username">Username :</label> 
    <input type="text" name="username" id="username" value="<?php echo $_POST['username'] ?>"/><br/>
    <label for="password">mot de passe :</label>
    <input type="password" name="password" id="password" value="<?php echo $_POST['password'] ?>"/><br/>
    <input type="checkbox" name="connexion" id="connexion" /> <label for="connexion">connexion automatique</label><br />
    <input type="submit" value="Se connecter"/>
    </p>
  </form>
  <a href="">page d'accueil</a>

  <?php
$username = $_POST['username'] ;
try
{
$bdd = new PDO('mysql:host=localhost;dbname=extranet_bancaire;charset=utf8', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}
//  Récupération de l'utilisateur et de son pass hashé
$req = $bdd->prepare('SELECT id_user, password FROM accounts WHERE username = :username');
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
        $_SESSION['username'] = $username;
        if ($_POST['connexion']){
          $_COOKIE['password'] =  password_hash($resultat['password']);
          $_COOKIE['username'] = $username;
        }
    }
    else {
        echo 'Mauvais identifiant ou mot de passe !';
    }
}
?>
</body>
</html>