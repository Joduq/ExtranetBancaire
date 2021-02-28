<?php
session_start();
// if(!$_SESSION['connexion']){
  // setcookie('username','', time() + 365*24*3600,'/','/tests/ExtranetBancaire/');
  // setcookie('password','', time() + 365*24*3600);
// }
include('bdd_call.php');
$isPasswordCorrect = [];
if(isset($_POST['username'])){
  $username = $_POST['username'];
  $resultat = accounts_table($_POST['username']);
}

if(isset($resultat['password'])){
  $password_stored = $resultat['password'];
}

if(isset($_POST['password'])){
  $password = $_POST['password'];
}
if (isset($password,$password_stored)){
  $isPasswordCorrect = password_verify($password, $password_stored);
}

if (!isset($_POST['username'])){

}else{
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
  
}
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
  <form action='' method="post">
      <p>
      <label for="username">Username :</label> 
      <input type="text" name="username" id="username" value="<?php if(isset($username)){echo $username;} ?>"/><br/>
      <label for="password">mot de passe :</label>
      <input type="password" name="password" id="password" value="<?php if(isset($password)){echo $password;} ?>"/><br/>
      <input type="submit" value="Se connecter"/>
      </p>
  </form>
  <a href="">page d'accueil</a>
  <a href="oublie.php">mot de passe oublié?</a>
  <?php include("footer.php"); ?>
</body>
</html>