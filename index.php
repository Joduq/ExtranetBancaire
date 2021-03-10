<?php
session_start();
// if(!$_SESSION['connexion']){
  // setcookie('username','', time() + 365*24*3600,'/','/tests/ExtranetBancaire/');
  // setcookie('password','', time() + 365*24*3600);
// }
include('bdd_call.php');
$state_display = 'none';
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
    $error_message = '<ul class="list"><li>-Mauvais identifiant ou mot de passe !.</li></ul>';
    $state_display = 'initial';
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
        $error_message = '<ul class="list"><li>-Mauvais identifiant ou mot de passe.</li></ul>';
        $state_display = 'initial';
    }
  }
  
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <link rel="short icon" type="image/png" href="logos/GBAF.png">
  <title>connexion</title>
</head>
<body>
  <?php include("header.php"); ?>
  <main>
    <div style="<?php echo "display:".$state_display ?>">
      <div class="container">
          <div class="card-option-column list-contain">
              <?php if(isset($error_message)){echo $error_message;} ?>
          </div>
      </div>
    </div>
    <div class="container">
      <div class="card-option-column">
        <h2>CONNEXION</h2>
        <form action='' method="post">
          <table>
            <tr>
              <td><label for="username">username :</label> </td>
              <td><input type="text" name="username" id="username" value="<?php if(isset($username)){echo htmlspecialchars($username);} ?>"/></td>
            </tr>
            <tr>
              <td><label for="password">mot de passe :</label></td>
              <td> <input type="password" name="password" id="password" value="<?php if(isset($password)){echo htmlspecialchars($password);} ?>"/></td>
            </tr>
          </table>
              <input class="btn-option" type="submit" value="Se connecter"/>
          
        </form>
        <a href="inscription.php">Pas de compte? Créer un compte.</a>
        <div class="link-bottom"><a href="oublie.php">Mot de passe oublié?</a>
        </div>
      </div>
    </div>
  </main>
  <footer>
    <?php include("footer.php"); ?>
  </footer>
</body>
</html>