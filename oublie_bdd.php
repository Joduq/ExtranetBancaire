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
<a href="acteurs.php">retour à la page acteur</a>
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
  ?>
</body>
</html>