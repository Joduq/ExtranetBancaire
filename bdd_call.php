<?php
function bdd_call(){
  try
  {
  return $bdd = new PDO('mysql:host=localhost;dbname=extranet_bancaire;charset=utf8', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
  }
  catch(Exception $e)
  {
          die('Erreur : '.$e->getMessage());
  }
}
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
///////////////////////////////////////////
//////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
  $reponse_a->execute(array($id_acteur));
  return $donnees = $reponse_a->fetch();
}

function thumbs_count($id_acteur){
  $bdd = bdd_call();
  $req_d = $bdd->prepare('SELECT COUNT(*) FROM votes WHERE id_acteur = :id_acteur AND votes > 0');
  $req_d->execute(array('id_acteur' =>$id_acteur));
  return $count = $req_d->fetchColumn();
}
//////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////






function all_comments($id_acteur){
  $bdd = bdd_call();
  $reponse = $bdd->prepare("SELECT id_post, id_user, id_acteur, date_add,post, DAY(date_add) AS jour, MONTH(date_add) AS mois,
  YEAR(date_add) AS annee, HOUR(date_add) AS heure, MINUTE(date_add) AS minute, SECOND(date_add) AS seconde FROM posts WHERE id_acteur=?");
  $reponse->execute(array($id_acteur));
  return $comments = $reponse->fetchAll();
}



function user_params($comments){
  $bdd = bdd_call();
  $reponse = $bdd->prepare("SELECT id_user, prenom, nom FROM accounts WHERE id_user=?");
  $reponse->execute(array($comments['id_user']));
  return $users = $reponse->fetch();
}
////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
///////////////////////////////////////////////
function insert_into_commentaires($id_user,$id_acteur,$post){
  try
  {
    $bdd = new PDO('mysql:host=localhost;dbname=extranet_bancaire;charset=utf8', 'root', 'root');
  }
  catch(Exception $e)
  {
          die('Erreur : '.$e->getMessage());
  }


  // $req = $bdd->prepare('INSERT INTO posts (id_user, id_acteur, post) VALUES(?, ?, ?)');
  // $req->execute(array($_SESSION['id_user'], $_POST['id_acteur'], $_POST['post']));
  $req = $bdd->prepare('INSERT INTO posts(id_user,id_acteur,date_add, post) VALUES(:id_user, :id_acteur, CURRENT_TIMESTAMP(),:post)');
  $req->execute(array(
      'id_user' => $id_user,
      'id_acteur' => $id_acteur,
      'post' =>  $post));
}

function select_one_account($username){
  try
  {
    $bdd = new PDO('mysql:host=localhost;dbname=extranet_bancaire;charset=utf8', 'root', 'root');
  }
  catch(Exception $e)
  {
          die('Erreur : '.$e->getMessage());
  }
  $reponse = $bdd->prepare("SELECT * FROM accounts WHERE username=?");
  $reponse->execute(array($username));
  return $donnees = $reponse->fetch();
  // while ($donnees = $reponse->fetch())
}
function update_one_account($nom, $prenom, $password_hash, $question, $reponse, $id_user){
  try
  {
    $bdd = new PDO('mysql:host=localhost;dbname=extranet_bancaire;charset=utf8', 'root', 'root');
  }
  catch(Exception $e)
  {
          die('Erreur : '.$e->getMessage());
  }

 

      $sql = "UPDATE accounts SET nom = ?, prenom = ?, password = ?, question = ?,reponse = ? WHERE id_user=?";
      $query = $bdd->prepare($sql);
      $query->execute(array($nom, $prenom, $password_hash, $question, $reponse, $id_user));
}

?>