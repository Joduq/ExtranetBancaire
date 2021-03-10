<?php
session_start();
include('bdd_call.php');
$state_display = 'none';
if (isset($_SESSION['id_user']) AND isset($_SESSION['username']))
{
  $id_user = $_SESSION['id_user'];
   
}else{
      header("location:index.php");
} 

if(isset($_GET['id_acteur'])){
  $id_acteur = $_GET['id_acteur'];
}else{
  if(isset($_POST['id_acteur'])){
    $id_acteur = $_POST['id_acteur'];
  }else{
    header("Location: acteurs.php");
  }
}

if(isset($_POST['post'])){
  if($_POST['post']){
    $post = $_POST['post'];
    insert_into_commentaires($id_user,$id_acteur,$post);
    header("Location: acteur.php".'?id='.$id_acteur); 
  }else{
    $error_message='<ul class="list"><li>-Veuillez renseigner un commentaire.</li></ul>';
    $state_display = 'initial';
  }
} 
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <link rel="short icon" type="image/png" href="logos/GBAF.png">
  <title>Document</title>
</head>
<body>
  <?php include("header.php");?>
  <main>
  <div style="<?php echo "display:".$state_display ?>">
      <div class="container">
          <div class="card-option-column list-contain">
              <?php if(isset($error_message)){echo $error_message;} ?>
          </div>
      </div>
    </div>
    <div class="container">
      <div class="card-option-column">
        <form action="commentaires.php" method="post" >
          <p>
            <h3>Entrez votre commentaire</h3>
            <table>
              <tr>
                <td><label for="post">commentaire :</label></td>
                <td><textarea name="post" id="post"></textarea></td>
              </tr>
            </table>  
            <input type="hidden" name="id_acteur" value="<?php echo $id_acteur ?>" />
            <input class="btn-option" type="submit">
          </p>
        </form>
      </div>
    </div>
  </main>
  <footer>
    <?php include("footer.php"); ?>
  </footer>
</body>
</html>
