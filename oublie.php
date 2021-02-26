<?php

include('bdd_call.php');
if (isset($_POST['username'])){
  $username = $_POST['username'];
  $donnees = select_account_by_username($username);
}
if (isset($_POST['password'])){
  $password = $_POST['password'];
}

$state_a = 'initial';
$state_b = 'none';
$state_c = 'none';


if (!isset($_POST['username'])){
}else{
  if (!$donnees){
    echo 'username inconnu';
  }else{
    $state_a ='none';
    $state_b ='initial';
  }
}

if (!isset($_POST['reponse'])){
}else{
  if ($_POST['reponse'] != $donnees['reponse']){
    echo 'mauvaise reponse';
  }else{
    $state_b ='none';
    $state_c = 'initial';  
  }
}

if (!isset($_POST['password'])){
}else{
  if ($_POST['password']!=$_POST['confirpassword'] OR $_POST['password']== false){
    echo 'mot de passe nul ou différent du mot de passe de confirmation';
    $state_b ='none';
    $state_c = 'initial'; 
  }else{
    update_one_account_password($password,$username);
    header("location:index.php");
  }
} 

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>inscription</title>
</head>
<body>
<div style="<?php echo "display:".$state_a ?>">
  <h3>entrez votre username:</h3>
    <form action="oublie.php" method="post">
      <p>
      <label for="prenom">username:</label> 
      <input type="text" name="username" id="username"/><br/>
      <input type="submit"/>
      </p>
    </form>
</div> 
  <a href="connexion.php">retour à la page d'accueil</a>
  <div style="<?php echo "display:".$state_b ?>">
    <p>question secrète: <?php echo htmlspecialchars($donnees['question']);?></p>

    <form action="oublie.php" method="post">
    <p>
    <label for="reponse">entrez la réponse:</label>
    <input type="hidden" name="username" value="<?php echo $username ?>" /> 
    <input type="text" name="reponse" id="reponse"/><br/>
    <input type="submit"/>
    </p>
    </form>
  </div>

  <div style="<?php echo "display:".$state_c ?>">
    <form action="oublie.php" method="post">
    <p>
    <label for="password">nouveau mot de passe :</label>
    <input type="password" name="password" id="password" value=""/><br/>
    <label for="confirpassword">confirmation du nouveau mot de passe:</label>
    <input type="password" name="confirpassword" id="confirpassword" value=""/><br/>
    <input type="hidden" name="username" value="<?php echo $username ?>" /> 
    <input type="submit"/>
    </p>
    </form>
  </div>

</body>
