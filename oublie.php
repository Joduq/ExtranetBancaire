<?php

include('bdd_call.php');
$state_display='none';
if (isset($_POST['username'])){
  $username = htmlspecialchars($_POST['username']);
  $donnees = select_account_by_username($username);
}
if (isset($_POST['password'])){
  $password = htmlspecialchars($_POST['password']);
}

$state_a = 'initial';
$state_b = 'none';
$state_c = 'none';


if (!isset($_POST['username'])){
}else{
  if (!$donnees){
    $array_of_errors[] = 'username inconnu';
    $state_display ='initial';
  }else{
    $state_a ='none';
    $state_b ='initial';
  }
}

if (!isset($_POST['reponse'])){
}else{
  if ($_POST['reponse'] != $donnees['reponse']){
    $array_of_errors[] = 'mauvaise reponse';
    $state_display ='initial';
  }else{
    $state_b ='none';
    $state_c = 'initial';  
  }
}

if (!isset($_POST['password'])){
}else{
  if ($_POST['password']!=$_POST['confirpassword'] OR $_POST['password']== false){
    $array_of_errors[] = 'Mot de passe non renseigné ou différent du mot de passe de confirmation';
    $state_display ='initial';
    $state_b ='none';
    $state_c = 'initial'; 
  }else{
    update_one_account_password($password,$username);
    header("location:index.php");
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
                    echo "<li>-".$value.".</li>";
                  }
                  echo "</ul>";
                }
          ?>
        </div>
      </div>
    </div>
    <div style="<?php echo "display:".$state_a ?>">
      <div class="container">
          <div class="card-option-column">          
            <h3>Mot de passe oublié</h3>
            <p>Entrez votre username:</p>
            <form action="oublie.php" method="post">
              <p>
                <table>
                  <tr>
                    <td><label for="prenom">username:</label></td>
                    <td><input type="text" name="username" id="username"/><br/></td>
                  </tr> 
                </table>
                <input class="btn-option" type="submit"/>
              </p>
            </form>
          </div>
        </div> 
      </div>
    <div style="<?php echo "display:".$state_b ?>">
      <div class="container">
        <div class="card-option-column">
          <h3>Mot de passe oublié</h3>          
          <p>question secrète: <?php echo htmlspecialchars($donnees['question']);?></p>
          <form action="oublie.php" method="post">
            <p>
              <table>
                <tr>
                  <td><label for="reponse">entrez la réponse:</label></td>
                  <td><input type="text" name="reponse" id="reponse"/></td>
                </tr>
              </table>  
              <input type="hidden" name="username" value="<?php echo $username ?>" />
              <input class="btn-option" type="submit"/>
            </p>
          </form>
        </div>
      </div>
    </div>
    <div style="<?php echo "display:".$state_c ?>">
      <div class="container">
        <div class="card-option-column">
        <h3>Mot de passe oublié</h3>     
          <form action="oublie.php" method="post">
            <p>
              <table>
                <tr>
                  <td><label for="password">nouveau mot de passe :</label></td>
                  <td><input type="password" name="password" id="password" value=""/></td>
                </tr>
                <tr>
                  <td><label for="confirpassword">confirmation du nouveau mot de passe:</label></td>
                  <td><input type="password" name="confirpassword" id="confirpassword" value=""/></td>
                </tr>
              </table> 
              <input type="hidden" name="username" value="<?php echo $username ?>" /> 
              <input class="btn-option" type="submit"/>
            </p>
          </form>
        </div>
      </div>
    </div>
  </main>
  <footer>
    <?php include("footer.php"); ?>
  </footer>
</body>
