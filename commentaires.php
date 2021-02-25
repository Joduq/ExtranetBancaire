<?php
session_start();
if (isset($_SESSION['id_user']) AND isset($_SESSION['username']))
{
    
}else{
      header("location:index.php");
} 
include('bdd_call.php');

$id_user = $_SESSION['id_user'];
$id_acteur = $_POST['id_acteur'];
$post = $_POST['post'];

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
    <form action="commentaires.php" method="post" >
      <p>
        <label for="post">entrez votre commentaire :</label>
        <textarea name="post" id="post"></textarea>  <br/>
        <input type="hidden" name="id_acteur" value="<?php echo $_GET['id_acteur'] ?>" />
        <input type="submit">
      </p>
    </form>
    <?php
  } elseif(!$_POST['post'] ){
    ?>
    <form action="commentaires.php" method="post" >
      <p>
        <label for="post">entrez votre commentaire :</label>
        <textarea name="post" id="post"></textarea>  <br/>
        <input type="hidden" name="id_acteur" value="<?php echo $_POST['id_acteur'] ?>" />
        <input type="submit">
      </p>
    </form>
    <?php
      echo 'Veuillez renseigner le champs commentaire';

  } else {
    insert_into_commentaires($id_user,$id_acteur,$post);
    header("Location: acteur.php".'?id='.$_POST['id_acteur']);
    } 
    ?>
  </body>
  </html>
