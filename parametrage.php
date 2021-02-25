<?php 
  session_start();

  if (isset($_SESSION['id_user']) AND isset($_SESSION['username']))
  { 

  }else{
  header("location:index.php");
  }
  include('bdd_call.php');
  $donnees= select_one_account($username);





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
  
  
  function add_to_bdd(){
  
  
    $password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $question = $_POST['question'];
    $reponse = $_POST['reponse'];
    $id_user = $_SESSION['id_user'];
    update_one_account($nom, $prenom, $password_hash, $question, $reponse, $id_user);
  
  }
  if(!isset($_POST['prenom'])){

  }else{
    if( confirm_password($_POST['password'],$_POST['confirpassword'])==TRUE && $_POST['prenom'] && $_POST['nom'] && $_POST['question'] && $_POST['reponse']){
      add_to_bdd();
      print "yes";
      header("location:acteurs.php");
    }else{
      if(confirm_password($_POST['password'],$_POST['confirpassword'])==FALSE )
      {
        $array_of_errors[]="Mot de passe non renseigné ou confirmation du mot de passe différents";
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

<h1>changement des parametres de compte</h1>
  <form action="parametrage.php" method="post">
    <p>
    <label for="prenom">prénom :</label> 
    <input type="text" name="prenom" id="prenom" value="<?php echo $donnees['prenom'] ?>"/><br/>
    <label for="nom">nom :</label> 
    <input type="text" name="nom" id="nom" value="<?php echo $donnees['nom'] ?>"/><br/>
    <label for="password">mot de passe :</label>
    <input type="password" name="password" id="password" value=""/><br/>
    <label for="confirpassword">confirmation du mot de passe:</label>
    <input type="password" name="confirpassword" id="confirpassword" value=""/><br/>
    <label for="question">entrez votre question secrète :</label>
    <textarea name="question" id="question"><?php echo $donnees['question'] ?></textarea><br/>
    <label for="reponse">entrez la reponse à votre question secrète :</label>
    <textarea name="reponse" id="reponse"><?php echo $donnees['reponse'] ?></textarea>  <br/>
    <input type="submit"/>
    </p>
  </form>
  <a href="acteurs.php">retour à la page d'accueil</a>

</body>
