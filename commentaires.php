<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>commentaires blog</title>
</head>
<body>
<h1>Mon super blog!</h1>
<p><a href="index.php">Retour à la liste des billets</a></p>
<?php
try
{
	// On se connecte à MySQL
	$bdd = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', 'root');
}
catch(Exception $e)
{
	// En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
}

// Si tout va bien, on peut continuer

// On récupère tout le contenu de la table jeux_video
// $reponse = $bdd->query('SELECT * FROM billets ORDER BY date_creation DESC LIMIT 5');
$reponse = $bdd->prepare("SELECT titre, contenu, id, date_creation, DAY(date_creation) AS jour, MONTH(date_creation) AS mois,
 YEAR(date_creation) AS annee, HOUR(date_creation) AS heure, MINUTE(date_creation) AS minute, SECOND(date_creation) AS seconde FROM billets WHERE id=?");
$reponse->execute(array($_GET['id']));
// On affiche chaque entrée une à une
while ($donnees = $reponse->fetch())
{
?>
<div class="news">
  <h3>
    <?php echo htmlspecialchars($donnees['titre']);?> <em>le <?php echo $donnees['jour'];?>/<?php echo $donnees['mois'];?>/<?php echo $donnees['annee'];?> à <?php echo $donnees['heure'];?>h<?php echo $donnees['minute'];?>m<?php echo $donnees['seconde'];?>s</em>
  </h3>
  <p>
    <?php echo nl2br(htmlspecialchars($donnees['contenu']));?><br/>
  </p>
</div>
 
<?php
}

$reponse->closeCursor(); // Termine le traitement de la requête

?>
<h2>Commentaires</h2>
<?php
try
{
	// On se connecte à MySQL
	$bdd_a = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', 'root');
}
catch(Exception $e)
{
	// En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
}

// Si tout va bien, on peut continuer

// On récupère tout le contenu de la table jeux_video
// $reponse = $bdd->query('SELECT * FROM billets ORDER BY date_creation DESC LIMIT 5');
$reponse_a = $bdd_a->prepare("SELECT id_billet, auteur, id, date_commentaire,commentaire, DAY(date_commentaire) AS jour, MONTH(date_commentaire) AS mois,
 YEAR(date_commentaire) AS annee, HOUR(date_commentaire) AS heure, MINUTE(date_commentaire) AS minute, SECOND(date_commentaire) AS seconde FROM commentaires WHERE id_billet=?");
$reponse_a->execute(array($_GET['id']));
// On affiche chaque entrée une à une
while ($donnees_a = $reponse_a->fetch())
{
?>

  <p>
  <strong><?php echo htmlspecialchars($donnees_a['auteur']);?></strong> le <?php echo $donnees_a['jour'];?>/<?php echo $donnees_a['mois'];?>/<?php echo $donnees_a['annee'];?> à <?php echo $donnees_a['heure'];?>h<?php echo $donnees_a['minute'];?>m<?php echo $donnees_a['seconde'];?>s</br>
  <?php echo nl2br(htmlspecialchars($donnees_a['commentaire']));?>
  </p>
<?php
}

$reponse_a->closeCursor(); // Termine le traitement de la requête

?>
</body>
</html>