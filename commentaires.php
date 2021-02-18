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
    <form action="commentaires.php" method="post" >
      <p>
        <label for="post">entrez votre commentaire :</label>
        <textarea name="post" id="post"></textarea>  <br/>
        <input type="hidden" name="id_acteur" value="<?php echo $_GET['id_acteur'] ?>" />
        <input type="submit">
      </p>
    </form>



    <?php
    var_dump($_POST['post']);


  } else {
    try
    {
      $bdd = new PDO('mysql:host=localhost;dbname=extranet_bancaire;charset=utf8', 'root', 'root');
    }
    catch(Exception $e)
    {
            die('Erreur : '.$e->getMessage());
    }


    // $req = $bdd->prepare('INSERT INTO posts (id_user, id_acteur, post) VALUES(?, ?, ?)');
    // $req->execute(array($_SESSION['id_user'], $_POST['id_acteur'], $_POST['post']));
    $req = $bdd->prepare('INSERT INTO posts(id_user,id_acteur,date_add, post) VALUES(:id_user, :id_acteur, CURRENT_TIMESTAMP(),:post)');
    $req->execute(array(
        'id_user' => $_SESSION['id_user'],
        'id_acteur' => $_POST['id_acteur'],
        'post' =>  $_POST['post']));
    header("Location: acteur.php".'?id='.$_POST['id_acteur']);
    }
    ?>
  </body>
  </html>

<?php
}else{
  header("location:index.php");
} 
?>