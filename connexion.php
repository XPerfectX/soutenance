<?php
require_once('inc/init.php');

//debug($_GET);
if(isset($_GET['action']) AND $_GET['action'] == 'deconnexion')
{
    unset($_SESSION['membre']);
    $content .= '<div class="alert alert-warning">Vous êtes déconnecté du site !</div>';
}
if(internauteEstConnecte())
{
    header('location:profil.php');
    exit();
}

if($_POST)
{
    //debug($_POST);
    // on tente de récupérer un membre dont le pseudo est celui passé dans le formulaire
    $req = $pdo->query("SELECT * FROM membre WHERE pseudo = '$_POST[pseudo]'");

    if($req->rowCount() != 0)
    {
        //on récupère le membre sous forme de tableau associatif
        $membre = $req->fetch(PDO::FETCH_ASSOC);

        //debug($membre);

        if(password_verify($_POST['mdp'], $membre['mdp']))
        {
            //remplissage de la session
            $_SESSION['membre']['pseudo'] = $membre['pseudo'];
            $_SESSION['membre']['nom'] = $membre['nom'];
            $_SESSION['membre']['prenom'] = $membre['prenom'];
            $_SESSION['membre']['email'] = $membre['email'];
            $_SESSION['membre']['civilite'] = $membre['civilite'];
            $_SESSION['membre']['ville'] = $membre['ville'];
            $_SESSION['membre']['code_postal'] = $membre['code_postal'];
            $_SESSION['membre']['adresse'] = $membre['adresse'];
            $_SESSION['membre']['statut'] = $membre['statut'];

            header('location:profil.php');
            //debug($_SESSION);
        }else{
            $content .= '<div class="alert alert-danger">Erreur Identifiants !</div>';
        }
    }else{
        $content .= '<div class="alert alert-danger">Erreur Identifiants !</div>';
    }
}
?>



<?php require_once('inc/header.inc.php'); ?>

<?= $content; ?>

<form method="post" action="">
    <div>
        <label for="pseudo">Pseudo</label>
        <input type="text" name="pseudo" placeholder="Votre Pseudo" id="pseudo" class="form-control">
    </div>
    <br>
    <div>
        <label for="mdp">Mot de Passe</label>
        <input type="password" name="mdp" placeholder="Votre Mot de Passe" id="mdp" class="form-control">
    </div>
    <br>
    <div>
        <input type="submit" class="btn btn-default" value="Se Connecter">
    </div>
</form>

<?php require_once('inc/footer.inc.php'); ?>