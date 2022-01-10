<?php 
require_once('inc/init.php');

if(!internauteEstConnecte())
{
    //la fonction header est une fonction prédéfinie qui nous permet de renvoyer vers une autre page
    header('location:connexion.php');
    exit();
}

if(internauteEstConnecteEtEstAdmin())
{
    $content .= '<h1>Vous êtes Administrateur du site</h1>';
}
?>

<?php require_once('inc/header.inc.php'); ?>
<?= $content ?>
Bonjour <?= $_SESSION['membre']['pseudo'] ?> Vous êtes bien connecté !<br>
voici vos informations : <br>
Votre nom : <?= $_SESSION['membre']['nom'] ?><br>
Votre prénom : <?= $_SESSION['membre']['prenom'] ?><br>
Votre e-mail : <?= $_SESSION['membre']['email'] ?><br>



<?php require_once('inc/footer.inc.php'); ?>