<?php
if(isset($_SESSION['username'])){
  $donnees = select_account_by_username($_SESSION['username']);}
?>
<header>
  <div class="nav-left">
    <img class="logo" src="logos/GBAF.png" alt="logo de la GBAF">
  </div>
  

  <div class="nav-right">
    <div class="dropdown">
    <button class="dropbtn"></button>
      <div class="dropdown-content">
        <a href="acteurs.php">accueil</a>
        <a href="parametrage.php">paramètres</a>
        <a href="deconnexion.php">déconnexion</a>
      </div>
    </div>
    <p><?php if(isset($donnees['prenom'])){echo htmlspecialchars($donnees['prenom']);}else{echo 'prénom';}?> <?php if(isset($donnees['nom'])){echo htmlspecialchars($donnees['nom']);}else{echo 'nom';}?></p> 
  </div>
</header>
