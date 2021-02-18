<?php
session_start();
if (isset($_SESSION['id_user']) AND isset($_SESSION['username']))
{
  ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <?php
  if (isset($_GET['id_user']) AND isset($_GET['id_acteur']) AND isset($_GET['votes'])){

    try
    {
      $bdd = new PDO('mysql:host=localhost;dbname=extranet_bancaire;charset=utf8', 'root', 'root');
    }
    catch(Exception $e)
    {
            die('Erreur : '.$e->getMessage());
    }
    $req_a = $bdd->prepare('SELECT COUNT(*) FROM votes WHERE id_user = :id_user AND id_acteur = :id_acteur');
    $req_a->execute(array('id_user' =>$_GET['id_user'],'id_acteur' =>$_GET['id_acteur']));
    $count = $req_a->fetchColumn();

    if ($count < 1 )
    {
        $req = $bdd->prepare('INSERT INTO votes (id_user, id_acteur, votes) VALUES(?, ?, ?)');
        $req->execute(array($_GET['id_user'], $_GET['id_acteur'], $_GET['votes']));
    }
    header("Location: acteur.php".'?id='.$_GET['id_acteur']);
  } else{
    header('Location: acteurs.php');
  }


  ?>
</body>
</html>
<?php
}else{
  header("location:index.php");
} 
?>