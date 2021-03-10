<?php 
  session_start();
  $state_display = 'none';
  if (isset($_SESSION['id_user']) AND isset($_SESSION['username']))
  { 

  }else{
  header("location:index.php");
  }
  include('bdd_call.php');
  if(isset($username)){
    $donnees= select_one_account($username);
  }





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
  
  // mettre des specialchart sur les vaziables ci dessous
    $password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $question = $_POST['question'];
    $reponse = password_hash($_POST['reponse'], PASSWORD_DEFAULT);
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
        $state_display = 'initial';
      }
      if(!$_POST['prenom'])
      {
        $array_of_errors[]="Prenom non renseigné";
        $state_display = 'initial';
      }
      if(!$_POST['nom'])
      {
        $array_of_errors[]="Nom non renseigné";
        $state_display = 'initial';
      }
      if(!$_POST['question'])
      {
        $array_of_errors[]="Question secrete pour récupration du mot de passe non renseignée";
        $state_display = 'initial';
      }
      if(!$_POST['reponse'])
      {
        $array_of_errors[]="Réponse à la question secrète non renseignée";
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
  <title>inscription</title>
</head>
<body>
  <?php include("header.php"); ?>
  <main>
    <div style="<?php echo "display:".$state_display ?>">
      <div class="container">
        <div class="card-option-column list-contain">
          <?php if(isset($array_of_errors)){
                  echo '<ul class="list">';
                  foreach ($array_of_errors as $value) {
                    echo "<li>-".$value.".</li>";
                  }
                  echo "</ul>";
                }
          ?>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="card-option-column">
        <h2>Paramètres du compte</h2>
        <form action="parametrage.php" method="post">
          <p>
            <table>
              <tr>
                <td><label for="prenom">prénom :</label></td>
                <td><input type="text" name="prenom" id="prenom" value="<?php if(isset($donnees['prenom'])){echo $donnees['prenom'];} ?>"/></td>  
              </tr>
              <tr>
                <td><label for="nom">nom :</label> </td>
                <td><input type="text" name="nom" id="nom" value="<?php if(isset($donnees['nom'])){echo $donnees['nom'];} ?>"/></td>
              </tr>
              <tr>
                <td><label for="password">mot de passe :</label></td>
                <td><input type="password" name="password" id="password" value=""/></td>
              </tr>
              <tr>
                <td><label for="confirpassword">confirmation du mot de passe:</label></td>
                <td><input type="password" name="confirpassword" id="confirpassword" value=""/></td>
              </tr>
              <tr>
                <td><label for="question">entrez votre question secrète :</label></td>
                <td><textarea name="question" id="question"><?php if(isset($donnees['question'])){echo $donnees['question'];} ?></textarea></td>
              </tr>
              <tr>
                <td><label for="reponse">entrez la reponse à votre question secrète :</label></td>
                <td><textarea name="reponse" id="reponse"><?php if(isset($donnees['reponse'])){echo $donnees['reponse'];} ?></textarea></td>
            </table>
            <input class="btn-option" type="submit"/>
          </p>
        </form>
        <div class="link-bottom">
          <a href="acteurs.php">retour à la page d'accueil</a>
        </div>
      </div>
    </div>
  </main>
  <footer>
    <?php include("footer.php"); ?>
  </footer>
</body>
