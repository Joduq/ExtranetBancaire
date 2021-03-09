<?php
session_start();
include('bdd_call.php');
if (isset($_SESSION['id_user']) AND isset($_SESSION['username']))
{ 

}else{
  header("location:index.php");
}

if (isset($_GET['id_user']) AND isset($_GET['id_acteur']) AND isset($_GET['votes'])){
  $id_user = $_GET['id_user'];
  $id_acteur = $_GET['id_acteur'];
  $votes = $_GET['votes'];

  $count = count_vote_user_for_acteur($id_user, $id_acteur);

  if ($count < 1 )
  {
    insert_vote($id_user, $id_acteur, $votes);
  }
  header("Location: acteur.php".'?id='.$_GET['id_acteur']);
} else{
  header('Location: acteurs.php');
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
</body>
</html>
