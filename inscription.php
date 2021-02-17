<?php 
  session_start();
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
    <input type="text" name="prenom" id="prenom" value="<?php echo $_POST['prenom'] ?>"/><br/>
    <label for="nom">nom :</label> 
    <input type="text" name="nom" id="nom" value="<?php echo $_POST['nom'] ?>"/><br/>
    <label for="username">username :</label> 
    <input type="text" name="username" id="username" value="<?php echo $_POST['username'] ?>"/><br/>
    <label for="password">mot de passe :</label>
    <input type="password" name="password" id="password" value="<?php echo $_POST['password'] ?>"/><br/>
    <label for="confirpassword">confirmation du mot de passe:</label>
    <input type="password" name="confirpassword" id="confirpassword" value="<?php echo $_POST['confirpassword'] ?>"/><br/>
    <label for="question">entrez votre question secrète :</label>
    <textarea name="question" id="question">ex: Quel est le nom de votre animal de compagnie?</textarea><br/>
    <label for="reponse">entrez la reponse à votre question secrète :</label>
    <textarea name="reponse" id="reponse">ex: Sacha</textarea>  <br/>
    <input type="submit"/>
    </p>
  </form>
  <a href="connexion.php">déjà inscrit?</a>

<?php 
if (isset($_SESSION['id_user']) AND isset($_SESSION['username']))
{
    echo 'Bonjour ' . $_SESSION['username'];
}


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

function valid_username($str){
  try
  {
  $bdd_a = new PDO('mysql:host=localhost;dbname=extranet_bancaire;charset=utf8', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
  }
  catch(Exception $e)
  {
          die('Erreur : '.$e->getMessage());
  }
  $req_a = $bdd_a->prepare('SELECT COUNT(*) FROM accounts WHERE username = :username');
  $req_a->execute(array('username' =>$str)); //$_POST['username']
  $count = $req_a->fetchColumn();

  if ($count < 1 && $str != null)
  {
    return TRUE;
  } else {
    return FALSE;
  }
}

function add_to_bdd(){
  // Hachage du mot de passe
  $password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $username = $_POST['username'];
  $prenom = $_POST['prenom'];
  $nom = $_POST['nom'];
  $question = $_POST['question'];
  $reponse = $_POST['reponse'];
  try
  {
    $bdd = new PDO('mysql:host=localhost;dbname=extranet_bancaire;charset=utf8', 'root', 'root');
  }
  catch(Exception $e)
  {
          die('Erreur : '.$e->getMessage());
  }

  // Insertion
  $req = $bdd->prepare('INSERT INTO accounts(nom, prenom, username, password, question, reponse) VALUES(:nom, :prenom, :username, :password, :question, :reponse)');
  $req->execute(array(
      'nom' => $nom,
      'prenom' => $prenom,
      'username' => $username,
      'password' => $password_hash,
      'question' => $question,
      'reponse' => $reponse));

  // Redirection du visiteur vers la page du minichat
  // header('Location: minichat.php');
}

if( confirm_password($_POST['password'],$_POST['confirpassword'])==TRUE && valid_username($_POST['username'])==TRUE && $_POST['prenom'] && $_POST['nom'] && $_POST['question'] && $_POST['reponse']){
  add_to_bdd();
  print "yes";
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
  
?>
</body>
</html>