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
    <link rel="stylesheet" href="style.css">
    <link href="css/all.css" rel="stylesheet"> <!--load all styles -->
    <title>commentaires blog</title>
  </head>
  <?php
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
  $reponse_a->execute(array($_GET['id']));
  while ($donnees_a = $reponse_a->fetch())
  {

  ?>
  <div class="news">
    <p>
      <img src="logos/<?php echo htmlspecialchars($donnees_a['logo']); ?>" alt="logo acteur">
    </p>
    <h3>
      <?php echo htmlspecialchars($donnees_a['description']);?>
      <a href="<?php echo $donnees_a['lien'];?>"><?php echo $donnees_a['lien'];?></a>
    </h3>
    <p>
      <button  type="button"><a href="commentaires.php?id=<?php echo $donnees_a['id']; ?>">Lire la suite</a></button>
    </p>
  </div>
  <?php
  }
  $reponse_a->closeCursor(); // Termine le traitement de la requête
  ?>

  <h2>Commentaires</h2> <button>nouveau commentaire</button><a href="like">like</a><i class="far fa-thumbs-up"></i>
  <?php


  // Si tout va bien, on peut continuer

  // On récupère tout le contenu de la table jeux_video
  // $reponse = $bdd->query('SELECT * FROM billets ORDER BY date_creation DESC LIMIT 5');
  $reponse_b = $bdd->prepare("SELECT id_post, id_user, id_acteur, date_add,post, DAY(date_add) AS jour, MONTH(date_add) AS mois,
  YEAR(date_add) AS annee, HOUR(date_add) AS heure, MINUTE(date_add) AS minute, SECOND(date_add) AS seconde FROM posts WHERE id_acteur=?");
  $reponse_b->execute(array($_GET['id']));
  // On affiche chaque entrée une à une
  while ($donnees_b = $reponse_b->fetch())
  {
  ?>
    <?php
    $reponse_c = $bdd->prepare("SELECT * FROM accounts WHERE id_user=?");
    $reponse_c->execute(array($donnees_b['id_user']));
    // On affiche chaque entrée une à une
    while ($donnees_c = $reponse_c->fetch())
    {
    ?>
    
    <p>
    <strong><?php echo htmlspecialchars($donnees_c['prenom']);?>
    </p>
    <?php    
    }
    $reponse_c->closeCursor();
    ?>

    <p>
      </strong> le <?php echo $donnees_b['jour'];?>/<?php echo $donnees_b['mois'];?>/<?php echo $donnees_b['annee'];?> à <?php echo $donnees_b['heure'];?>h<?php echo $donnees_b['minute'];?>m<?php echo $donnees_b['seconde'];?>s</br>
      <?php echo nl2br(htmlspecialchars($donnees_b['post']));?>
    </p>
  <?php
  }
  $reponse_b->closeCursor(); // Termine le traitement de la requête
  ?>
  </body>
  </html>
<?php
}else{
  header("location:index.php");
} 
?>