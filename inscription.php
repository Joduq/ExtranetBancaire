<?php 
  session_start();
 
  //verification du mot de passe avec le mot de passe de confirmation
  $state_display = 'none';
  function confirm_password($str_a, $str_b) {
    if($str_a==$str_b && $str_a != NUll && $str_b != NULL){
      return TRUE;
    }else{
      $array_of_errors[]="Mot de passe et confirmation de mot de passe différent";
  
      return FALSE;
    }
  }
  
  // confirm_password($_POST['password'],$_POST['confirpassword']);
  
  include('bdd_call.php');
  if(isset($_POST['username'])){
      $username = htmlspecialchars($_POST['username']);
      $valid_username = valid_username($_POST['username']);
  }
  if(isset($_POST['nom'])){
    $nom = htmlspecialchars($_POST['nom']);
  }
  if(isset($_POST['prenom'])){
    $prenom = htmlspecialchars($_POST['prenom']);
  }
  if(isset($_POST['password'])){
    $password_hash = password_hash(htmlspecialchars($_POST['password']), PASSWORD_DEFAULT);
  }
  if(isset($_POST['question'])){
    $question = htmlspecialchars($_POST['question']);
  }
  if(isset($_POST['reponse'])){
    $reponse = password_hash(htmlspecialchars($_POST['reponse']), PASSWORD_DEFAULT);
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
        $state_display = 'initial';
      }
      if(valid_username($_POST['username'])==FALSE )
      {
        $array_of_errors[]="Username non renseigné ou déjà utilisé";
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
                    echo "<li>".$value.".</li>";
                  }
                  echo "</ul>";
                }
          ?>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="card-option-column">
        <h3>Inscription</h3>
        <form action="inscription.php" method="post">
            <table>
              <tr>
                <td><label for="prenom">prénom :</label> </td>
                <td><input type="text" name="prenom" id="prenom" value="<?php if(isset($prenom)){echo $prenom;} ?>"/></td>
              </tr>
              <tr>
                <td><label for="nom">nom :</label></td>
                <td><input type="text" name="nom" id="nom" value="<?php if(isset($nom)){echo $nom;} ?>"/></td>
              </tr>
              <tr>
                <td><label for="username">pseudo :</label> </td>
                <td><input type="text" name="username" id="username" value="<?php if(isset($username)){echo $username;} ?>"/></td>
              </tr>
              <tr>
                <td><label for="password">mot de passe :</label></td>
                <td><input type="password" name="password" id="password" value="<?php if(isset($password)){echo $password;} ?>"/></td>
              </tr>
              <tr>
                <td><label for="confirpassword">confirmation du mot de passe:</label></td>
                <td><input type="password" name="confirpassword" id="confirpassword" value=""/></td>
              </tr>
              <tr>
                <td><label for="question">entrez votre question secrète :</label></td>
                <td><textarea name="question" id="question"></textarea></td>
              </tr>
              <tr>
                <td><label for="reponse">entrez la reponse à votre question secrète :</label></td>
                <td><textarea name="reponse" id="reponse"></textarea></td>
              </tr>
            </table>
            <input class="btn-option" type="submit"/>
        </form>
        <div class="link-bottom">
          <a href="index.php">déjà inscrit?</a>
        </div>    
      </div>
    </div>
  </main>
  <footer>
    <?php include("footer.php"); ?>
  </footer>
</body>
</html>