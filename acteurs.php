<?php
session_start();

if (isset($_SESSION['id_user']) AND isset($_SESSION['username'])){

}else{
  header("location:index.php");
}
include('bdd_call.php');
$array_of_acteurs = select_all_acteurs();
foreach($array_of_acteurs as $acteur){
  $display_acteurs[] = '
  <div class="news">
    <p>
      <img src="logos/'.htmlspecialchars($acteur['logo']).'" alt="logo acteur">
    </p>
    <h3>
      '.htmlspecialchars($acteur['description']).'
      <a href="'.htmlspecialchars($acteur['lien']).'"><'.htmlspecialchars($acteur['lien']).'</a>
    </h3>
    <p>
      <button  type="button"><a href="acteur.php?id='.htmlspecialchars($acteur['id_acteur']).'">Lire la suite</a></button>
    </p>
  </div>  
  ';
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="style.css" />
    <title>blog</title>
  </head>
  <body>
    <?php include("header.php"); ?>
    <h1>Le Groupement Banque Assurance Français - GBAF</h1>
    <p>Fédération représentant les 6 grands groupes français (BNP Paribas, BPCE, Crédit Agricole, Crédit Mutuel-CIC, Société Général, La Banque Postale) et tous les autres acteurs de la profession bancaire et 
      des assureurs sur tous les axes de la réglementation financière française.
    </p>
    <h2>Les acteurs de la GBAF</h2>
    <p>les acteurs s'unissent et proposent les meilleurs produits bancaires et assurances pour les 80 millions de comptes présent sur le territoire français
    </p>

    <?php
      foreach($display_acteurs as $acteur){
      echo $acteur;
      }
      include("footer.php"); 
    ?>
  </body>
</html>
