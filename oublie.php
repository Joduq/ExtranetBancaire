<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>inscription</title>
</head>
<body>
<h3>entrez votre username:</h3>
  <form action="oublie.php" method="post">
    <p>
    <label for="prenom">username:</label> 
    <input type="text" name="username" id="username"/><br/>
    <input type="submit"/>
    </p>
  </form>
  <a href="connexion.php">retour à la page d'accueil</a>
<?php
// if (isset($_POST['username'])){
  try
  {
    // On se connecte à MySQL
    $bdd = new PDO('mysql:host=localhost;dbname=extranet_bancaire;charset=utf8', 'root', 'root');
  }
  catch(Exception $e)
  {
    // En cas d'erreur, on affiche un message et on arrête tout
          die('Erreur : '.$e->getMessage());
  }
  $reponse_a = $bdd->prepare("SELECT * FROM accounts WHERE username=?");
  $reponse_a->execute(array($_POST['username']));
  while ($donnees_a = $reponse_a->fetch())
  {
?>
  <p><?php echo htmlspecialchars($donnees_a['question']);?></p>
<?php
  }  
?>
  <form action="oublie.php" method="post">
    <p>
    <label for="reponse">entrez la réponse:</label>
    <input type="hidden" name="username" value="<?php echo $_POST['username'] ?>" /> 
    <input type="text" name="reponse" id="reponse"/><br/>
    <input type="submit"/>
    </p>
  </form>
<?php
  $reponse_b = $bdd->prepare("SELECT * FROM accounts WHERE username=?");
  $reponse_b->execute(array($_POST['username']));
  while ($donnees_b = $reponse_b->fetch())
  {
  var_dump( $donnees_b);
  if($_POST['reponse']== $donnees_b['reponse']){
  ?>
    <form action="oublie.php" method="post">
    <p>
    <label for="password">nouveau mot de passe :</label>
    <input type="password" name="password" id="password" value=""/><br/>
    <label for="confirpassword">confirmation du nouveau mot de passe:</label>
    <input type="password" name="confirpassword" id="confirpassword" value=""/><br/>
    <input type="hidden" name="username" value="<?php echo $_POST['username'] ?>" /> 
    <input type="submit"/>
    </p>
    </form>
  <?php
    if ($_POST['password']==$_POST['conrfirpassword'] && $_POST['password']==TRUE ){
      $sql = "UPDATE accounts SET password = ? WHERE username=?";
      $query = $bdd->prepare($sql);
      $pass_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
      $query->execute(array($pass_hash,  $_POST['username']));
    }else{
      echo "Mot de passe non renseigné ou confirmation du mot de passe différents";
    }
  }
  ?>

<?php
  }
// }  
?>
</body>
