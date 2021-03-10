<?php
session_start();

if (isset($_SESSION['id_user']) AND isset($_SESSION['username']))
{

}else{
  header("location:index.php");
}

include('bdd_call.php');

$id_acteur = $_GET['id'];
$donnees_acteur=select_one_acteur($id_acteur);
$bdd = bdd_call();
$count_up = thumbs_count($id_acteur,1);
$count_down = thumbs_count($id_acteur,0);
$count_comments = comments_count($id_acteur);
$array_of_comments = all_comments($id_acteur);

foreach($array_of_comments as $comment){
  $users = user_params($comment);
  $display_comments[] = '<div class="commentaire"><P class="name">'.$users['prenom'].'</p>'.'<p class="time">'.'le '.$comment['jour'].'/'.$comment['mois'].'/'.$comment['annee'].' à '.$comment['heure'].'h'.$comment['minute'].'m'.$comment['seconde'].'s :</p>'.'<p class="overflow-wrap">'.$comment['post'].'</p></div>';
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
  <title>commentaires blog</title>
</head>
<body>
<?php include("header.php"); ?>
<main>
  <div class="container">
    <div class="card-acteur-column">
      <div class="card-acteur-img-center">
        <img class="card-acteur-img" src="logos/<?php echo htmlspecialchars($donnees_acteur['logo']);?>" alt="logo acteur">
      </div>
      <div class="card-acteur-column-infos">
        <h3> <?php echo htmlspecialchars($donnees_acteur['acteur']); ?></h3>
        <div class="card-description">
          <p><?php echo htmlspecialchars($donnees_acteur['description']); ?></p>
        </div>
        <a href="<?php echo htmlspecialchars($donnees_acteur['lien']); ?>"><?php echo htmlspecialchars($donnees_acteur['lien']); ?></a>
      </div>
    </div>
    <div class="card-commentaires-column">
      <div class="card-commentaire-infos">
        <h2> <?php echo htmlspecialchars($count_comments);?> commentaires</h2> 
        <div class="card-commentaire-input">
          <div class="card-btn-commentaire"><button><a href="commentaires.php?id_acteur=<?php echo htmlspecialchars($_GET['id']);?>">nouveau commentaire</a></button>
          </div>
          <div class="card-commentaire-like">
            <div class="thumb-up">      
              <p><?php echo htmlspecialchars($count_up);?></p>
              <a href="votes.php?id_acteur=<?php echo htmlspecialchars($_GET['id']);?>&amp;id_user=<?php echo htmlspecialchars($_SESSION['id_user']);?>&amp;votes=1"><img src="logos/thumbs-up-regular.svg" id="thumb-up" alt="thumbs up"></a>
            </div>
            <div class="thumb-down">
              <p><?php echo htmlspecialchars($count_down);?></p>          
              <a href="votes.php?id_acteur=<?php echo htmlspecialchars($_GET['id']);?>&amp;id_user=<?php echo htmlspecialchars($_SESSION['id_user']);?>&amp;votes=0"><img src="logos/thumbs-down-regular.svg" id="thumb-down" alt="thumbs down"></a>
            </div> 
          </div>
        </div>
      </div>
      <div class="card-commentaires">      
        <?php
        foreach($display_comments as $comment){
          echo($comment);
        }
        ?>
      </div>
    </div>  
  </div>
</main>
<footer>
  <?php include("footer.php"); ?>
</footer>
</body>
</html>
