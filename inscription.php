<?php 
  session_start();
 
  //verification du mot de passe avec le mot de passe de confirmation
  
  function confirm_password($str_a, $str_b) {
    if($str_a==$str_b && $str_a != NUll && $str_b != NULL){
      return TRUE;
    }else{
      $array_of_errors[]="Mot de passe et confirmation de mot de passe différent";
  
      return FALSE;
    }
  }
  
  // confirm_password($_POST['password'],$_POST['confirpassword']);
  
  // verification que le username est bien unique et n existe pas dans la bdd
  include('bdd_call.php');
  if(isset($_POST['username'])){
      $username = $_POST['username'];
      $valid_username = valid_username($_POST['username']);
  }
  if(isset($_POST['nom'])){
    $nom = $_POST['nom'];
  }
  if(isset($_POST['prenom'])){
    $prenom = $_POST['prenom'];
  }
  if(isset($_POST['password'])){
    $password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
  }
  if(isset($_POST['question'])){
    $question = $_POST['question'];
  }
  if(isset($_POST['reponse'])){
    $reponse = $_POST['reponse'];
  }

  if (!isset($_POST['username'])){

  }else{
    if( confirm_password($_POST['password'],$_POST['confirpassword'])==TRUE && $valid_username==TRUE && $_POST['prenom'] && $_POST['nom'] && $_POST['question'] && $_POST['reponse']){
      insert_into_accounts($nom, $prenom, $username, $password_hash, $question, $reponse);
      $resultat= accounts_table($username);
      $_SESSION['id_user'] = $resultat['id_user'];
      $_SESSION['prenom'] = $resultat['prenom'];
      $_SESSION['nom'] = $resultat['nom'];
      $_SESSION['username'] = $username;
      header("location: index.php");
    }else{
      if(confirm_password($_POST['password'],$_POST['confirpassword'])==FALSE )
      {
        $array_of_errors[]="Mot de passe non renseigné ou confirmation du mot de passe différents";
      }
      if(valid_username($_POST['username'])==FALSE )
      {
        $array_of_errors[]="username non renseigné ou déjà utilisé";
      }
      if(!$_POST['prenom'])
      {
        $array_of_errors[]="prenom non renseigné";
      }
      if(!$_POST['nom'])
      {
        $array_of_errors[]="nom non renseigné";
      }
      if(!$_POST['question'])
      {
        $array_of_errors[]="question secrete pour récupration du mot de passe non renseignée";
      }
      if(!$_POST['reponse'])
      {
        $array_of_errors[]="réponse à la question secrète non renseignée";
      }
      
      echo "<ul>";
      foreach ($array_of_errors as $value) {
        echo "<li>".$value."</li>";
      }
      echo "</ul>";
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
  <form action="inscription.php" method="post">
    <p>
    <label for="prenom">prénom :</label> 
    <input type="text" name="prenom" id="prenom" value="<?php if(isset($prenom)){echo $prenom;} ?>"/><br/>
    <label for="nom">nom :</label> 
    <input type="text" name="nom" id="nom" value="<?php if(isset($nom)){echo $nom;} ?>"/><br/>
    <label for="username">username :</label> 
    <input type="text" name="username" id="username" value="<?php if(isset($username)){echo $username;} ?>"/><br/>
    <label for="password">mot de passe :</label>
    <input type="password" name="password" id="password" value="<?php if(isset($password)){echo $password;} ?>"/><br/>
    <label for="confirpassword">confirmation du mot de passe:</label>
    <input type="password" name="confirpassword" id="confirpassword" value=""/><br/>
    <label for="question">entrez votre question secrète :</label>
    <textarea name="question" id="question">ex: Quel est le nom de votre animal de compagnie?</textarea><br/>
    <label for="reponse">entrez la reponse à votre question secrète :</label>
    <textarea name="reponse" id="reponse">ex: Sacha</textarea>  <br/>
    <input type="submit"/>
    </p>
  </form>
  <a href="connexion.php">déjà inscrit?</a>
</body>
</html>