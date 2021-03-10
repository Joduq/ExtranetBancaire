<?php
session_start();

if (isset($_SESSION['id_user']) AND isset($_SESSION['username'])){

}else{
  header("location:index.php");
}
include('bdd_call.php');
$acteurs = select_all_acteurs();
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="style.css" />
    <link rel="short icon" type="image/png" href="logos/GBAF.png">
    <title>blog</title>
  </head>
  <body>
    <?php include("header.php"); ?>
    <main>
    <div class="banner">
      <div class="container">
      <h1>Le Groupement Banque Assurance Français - GBAF</h1>
        <p>Fédération représentant les 6 grands groupes français (BNP Paribas, BPCE, Crédit Agricole, Crédit Mutuel-CIC, Société Général, La Banque Postale) et tous les autres acteurs de la profession bancaire et 
          des assureurs sur tous les axes de la réglementation financière française.</p>   
      </div>
    </div>
      <div class="container">
        <div class="titre-acteurs">
          <h2>Les acteurs de la GBAF</h2>
          <p>les acteurs s'unissent et proposent les meilleurs produits bancaires et assurances pour les 80 millions de comptes présent sur le territoire français</p>
        </div>
        <div class="cards">
          <?php foreach($acteurs as $acteur){ ?>
            <div class="card-acteur">
              <div>
                <img class="card-acteur-img" src="logos/<?php echo htmlspecialchars($acteur['logo']);?>" alt="logo acteur">
              </div>
              <div class="card-acteur-infos">
                <h3> <?php echo htmlspecialchars($acteur['acteur']); ?></h3>
                <div class="card-description">
                  <p><?php echo htmlspecialchars($acteur['description']); ?></p>
                </div>
                <a href="<?php echo htmlspecialchars($acteur['lien']); ?>"><?php echo htmlspecialchars($acteur['lien']); ?></a>
              </div>
              <div class="card-btn">
                <button  type="button"><a href="acteur.php?id=<?php echo htmlspecialchars($acteur['id_acteur']) ?>">Lire la suite</a></button>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
    </main>
    <footer>
      <?php include("footer.php"); ?>
    </footer>
  </body>
</html>
