
<?php

if (isset($_SESSION['id_user']) AND isset($_SESSION['username']))
{
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
  $reponse_a = $bdd->prepare("SELECT * FROM accounts WHERE id_user=?");
  $reponse_a->execute(array($_SESSION['id_user']));
  while ($donnees_a = $reponse_a->fetch())
  {
  ?>
<div class=header>
  <img src="logos/GBAF.png" alt="logo de la GBAF">
  <p>Bienvenue <?php echo htmlspecialchars($donnees_a['prenom']);?> et <?php echo htmlspecialchars($donnees_a['nom']);?> ! </p>
  <ul class="list-inline">
    <li><a href="parametre.php">paramètre</a></li>
    <li><a href="deconnexion.php">déconnexion</a></li>
    <li><i class="far fa-user"></i></li>
  </ul>
</div>
<?php
  }
} else {
?>


<?php
}
?>



