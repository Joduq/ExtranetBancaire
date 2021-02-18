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
    <title>Document</title>
  </head>
  <body>
  <?php
  if (isset($_GET['id_acteur'])){
  ?>
    <form action="" method="post" >
      <p>
        <label for="post">entrez votre commentaire :</label>
        <textarea name="post" id="post"></textarea>  <br/>
        <input type="submit">
      </p>
    </form>



    <?php

    try
    {
      $bdd = new PDO('mysql:host=localhost;dbname=extranet_bancaire;charset=utf8', 'root', 'root');
    }
    catch(Exception $e)
    {
            die('Erreur : '.$e->getMessage());
    }


    $req = $bdd->prepare('INSERT INTO posts (id_user, id_acteur, post) VALUES(?, ?, ?)');
    $req->execute(array($_SESSION['id_user'], $_GET['id_acteur'], $_POST['post']));

    header("Location: acteur.php".'?id='.$_GET['id_acteur']);
  } else {
    header("location:acteurs.php");
    }
    ?>
  </body>
  </html>

<?php
}else{
  header("location:index.php");
} 
?>