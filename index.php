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
<h1>Le Groupement Banque Assurance Français - GBAF</h1>
<p>Fédération représentant les 6 grands groupes français (BNP Paribas, BPCE, Crédit Agricole, Crédit Mutuel-CIC, Société Général, La Banque Postale) et tous les autres acteurs de la profession bancaire et 
  des assureurs sur tous les axes de la réglementation financière française.
</p>
<h2>Les acteurs de la GBAF</h1>
<p>les acteurs s'unissent et proposent les meilleurs produits bancaires et assurances pour les 80 millions de comptes présent sur le territoire français
</p>
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

// Si tout va bien, on peut continuer

// On récupère tout le contenu de la table jeux_video
// $reponse = $bdd->query('SELECT * FROM billets ORDER BY date_creation DESC LIMIT 5');
$reponse = $bdd->query('SELECT * FROM acteurs ORDER BY id_acteur DESC');

// On affiche chaque entrée une à une
while ($donnees = $reponse->fetch())
{
?>
<div class="news">
  <p>
    <img src="logos/<?php echo htmlspecialchars($donnees['logo']); ?>" alt="logo acteur">
  </p>
  <h3>
    <?php echo htmlspecialchars($donnees['description']);?>
    <a href="<?php echo $donnees['lien'];?>"><?php echo $donnees['lien'];?></a>
  </h3>
  <p>
    <button  type="button"><a href="commentaires.php?id=<?php echo $donnees['id_acteur']; ?>">Lire la suite</a></button>
  </p>
</div>
 
<?php
}

$reponse->closeCursor(); // Termine le traitement de la requête

?>
</body>
</html>