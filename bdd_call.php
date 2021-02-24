<?php
function accounts_table($username){
  try
{
$bdd = new PDO('mysql:host=localhost;dbname=extranet_bancaire;charset=utf8', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}
//  Récupération de l'utilisateur et de son pass hashé
$req = $bdd->prepare('SELECT id_user, password, prenom, nom FROM accounts WHERE username = :username');
$req->execute(array(
    'username' => $username));
$resultat = $req->fetch();

return $resultat;
}

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


function insert_into_accounts ($nom, $prenom, $username, $password_hash, $question, $reponse){
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
}
function select_all_acteurs(){
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

  // Si tout va bien, on peut continuer

  // On récupère tout le contenu de la table jeux_video
  // $reponse = $bdd->query('SELECT * FROM billets ORDER BY date_creation DESC LIMIT 5');
  return $reponse = $bdd->query('SELECT * FROM acteurs ORDER BY id_acteur DESC');
}

function select_one_acteur($id_acteur){
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
  $reponse_a = $bdd->prepare("SELECT * FROM acteurs WHERE id_acteur=?");
  return $reponse_a->execute(array($id_acteur));
}

?>