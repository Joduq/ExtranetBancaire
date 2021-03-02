<?php
  $donnees = select_account_by_username($_SESSION['username']);
?>
<header>
  <div class="nav-left">
    <img class="logo" src="logos/GBAF.png" alt="logo de la GBAF">
  </div>
  

  <div class="nav-right">
    <div class="dropdown">
    <button class="dropbtn"></button>
      <div class="dropdown-content">
        <a href="parametrage.php">paramètres</a>
        <a href="deconnexion.php">déconnexion</a>
      </div>
    </div>
    <p><?php echo htmlspecialchars($donnees['prenom']);?> <?php echo htmlspecialchars($donnees['nom']);?></p> 
  </div>
</header>
