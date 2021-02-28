<?php
session_start();

if (isset($_SESSION['id_user']) AND isset($_SESSION['username']))
{}else{
  header("location:index.php");
}
include('bdd_call.php');
$id_acteur = $_GET['id'];
$donnees=select_one_acteur($id_acteur);
$bdd = bdd_call();
$count = thumbs_count($id_acteur);
$array_of_comments = all_comments($id_acteur);

foreach($array_of_comments as $comment){
  $users = user_params($comment);
  $display_comments[] = '<P>'.$users['prenom'].'</p>'.'<p>'.'le '.$comment['jour'].'/'.$comment['mois'].'/'.$comment['annee'].' à '.$comment['heure'].'h'.$comment['minute'].'m'.$comment['seconde'].'s'.'</br>'.$comment['post'].'</p>';
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>commentaires blog</title>
</head>
<a href="acteurs.php">retour à la page acteur</a>
<div class="news">
  <p>
    <img src="logos/<?php echo htmlspecialchars($donnees['logo']); ?>" alt="logo acteur">
  </p>
  <h3>
    <?php echo htmlspecialchars($donnees['description']);?>
    <a href="<?php echo $donnees['lien'];?>"><?php echo $donnees['lien'];?></a>
  </h3>
  <p>
    <button  type="button"><a href="commentaires.php?id=<?php echo $donnees['id']; ?>">Lire la suite</a></button>
  </p>
</div>

<h2>Commentaires</h2> 
<p>
  <?php echo($count);?> likes
</p>
<button>nouveau commentaire</button>
<a href="commentaires.php?id_acteur=<?php echo $_GET['id'];?>">commentaire</a>
<a href="votes.php?id_acteur=<?php echo $_GET['id'];?>&amp;id_user=<?php echo $_SESSION['id_user'];?>&amp;votes=1"><img src="logos/thumbs-up-regular.svg" class="logo-thumb" alt="thumbs up"></a>
<a href="votes.php?id_acteur=<?php echo $_GET['id'];?>&amp;id_user=<?php echo $_SESSION['id_user'];?>&amp;votes=0"><img src="logos/thumbs-down-regular.svg" class="logo-thumb" alt="thumbs down"></a>

<?php
foreach($display_comments as $comment){
  echo $comment;
}
?>
</body>
</html>
