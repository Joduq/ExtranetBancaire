<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>blog</title>
</head>
<body>
<h1>Mon super blog!</h1>
<p>Derniers billets du blog:</p>
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
$reponse = $bdd->query('SELECT titre, contenu, id, date_creation, DAY(date_creation) AS jour, MONTH(date_creation) AS mois,
 YEAR(date_creation) AS annee, HOUR(date_creation) AS heure, MINUTE(date_creation) AS minute, SECOND(date_creation) AS seconde FROM billets ORDER BY date_creation DESC LIMIT 5');

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
    <button  onclick="commentaires.php?id=<?php echo $donnees['id']; ?>">Lire la suite</button>
  </p>
</div>
 
<?php
}

$reponse->closeCursor(); // Termine le traitement de la requête

?>
</body>
</html>