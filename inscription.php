<?PHP  session_start();?>
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
    <label for="pseudo">pseudo :</label> 
    <input type="text" name="pseudo" id="pseudo" value="<?php echo $_POST['pseudo'] ?>"/><br/>
    <label for="mdp">mot de passe :</label>
    <input type="password" name="mdp" id="mdp" value="<?php echo $_POST['mdp'] ?>"/><br/>
    <label for="confirmdp">confirmation du mot de passe:</label>
    <input type="password" name="confirmdp" id="confirmdp" value="<?php echo $_POST['confirmdp'] ?>"/><br/>
    <label for="email">email</label>
    <input type="text" name="email" id="email" value="<?php echo $_POST['email'] ?>"/><br/>
    <input type="submit"/>
    </p>
  </form>
  <a href="connexion.php">déjà inscrit?</a>

<?php 
if (isset($_SESSION['id']) AND isset($_SESSION['pseudo']))
{
    echo 'Bonjour ' . $_SESSION['pseudo'];
}


//verification du mot de passe avec le mot de passe de confirmation

function confirm_email($str_a, $str_b) {
  if($str_a==$str_b && $str_a != NUll && $str_b != NULL){
    return TRUE;
  }else{
    $array_of_errors[]="Mot de passe et confirmation de mot de passe différent";

    return FALSE;
  }
}

// confirm_email($_POST['mdp'],$_POST['confirmdp']);

//verification que le pseudo est bien unique et n existe pas dans la bdd

function valid_pseudo($str){
  try
  {
  $bdd_a = new PDO('mysql:host=localhost;dbname=espace_membre;charset=utf8', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
  }
  catch(Exception $e)
  {
          die('Erreur : '.$e->getMessage());
  }
  $req_a = $bdd_a->prepare('SELECT COUNT(*) FROM membres WHERE pseudo = :pseudo');
  $req_a->execute(array('pseudo' =>$str)); //$_POST['pseudo']
  $count = $req_a->fetchColumn();

  if ($count < 1 && $str != null)
  {
    return TRUE;
  } else {
    return FALSE;
  }
}
// valid_pseudo($_POST['pseudo']);

//verification que l'adresse mail est bien une adresse mail

function valid_email($str) {
  if(!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str))
  {
    return FALSE;
    $array_of_errors[]="Adresse email invalide";
    echo "adress apas ok";
    var_dump($array_of_errors);

  } else {
    return TRUE;
  }
}
// valid_email($_POST['email']);
function add_to_bdd(){
  // Hachage du mot de passe
  $pass_hache = password_hash($_POST['mdp'], PASSWORD_DEFAULT);
  $pseudo = $_POST['pseudo'];
  $email =$_POST['email'];
  // $date = CURDATE();
  // Connexion à la base de données
  try
  {
    $bdd = new PDO('mysql:host=localhost;dbname=espace_membre;charset=utf8', 'root', 'root');
  }
  catch(Exception $e)
  {
          die('Erreur : '.$e->getMessage());
  }

  // Insertion
  $req = $bdd->prepare('INSERT INTO membres(pseudo, pass, email, date_inscription) VALUES(:pseudo, :pass, :email, CURDATE())');
  $req->execute(array(
      'pseudo' => $pseudo,
      'pass' => $pass_hache,
      'email' => $email));
  // Redirection du visiteur vers la page du minichat
  // header('Location: minichat.php');
}

if( confirm_email($_POST['mdp'],$_POST['confirmdp'])==TRUE && valid_pseudo($_POST['pseudo'])==TRUE &&  valid_email($_POST['email'])==TRUE ){
  add_to_bdd();
  print "yes";
} elseif(confirm_email($_POST['mdp'] && NULL,$_POST['confirmdp'])==NULL && valid_pseudo($_POST['pseudo'])==NULL &&  valid_email($_POST['email'])==NULL)

{


}else{
  if(confirm_email($_POST['mdp'],$_POST['confirmdp'])==FALSE )
  {
    $array_of_errors[]="Mot de passe non renseigné ou confirmation du mot de passe différents";
  }
  if(valid_pseudo($_POST['pseudo'])==FALSE )
  {
    $array_of_errors[]="Pseudo non renseigné ou déjà utilisé";
  }
  if(valid_email($_POST['email'])==FALSE )
  {
    $array_of_errors[]="Adresse email invalide";
  }
  echo "<ul>";
  foreach ($array_of_errors as $value) {
    echo "<li>".$value."</li>";
  }
  echo "</ul>";
}
  
// elseif($_POST['mdp']==NULL|| $_POST['confirmdp']==NULL|| $_POST['pseudo']==NULL || $_POST['email']== NULL)
?>
</body>
</html>