<?php 
require_once('inc/init.php');

if ($_POST)// cela revient à dire if(isset($_POST))
{
    //debug($_POST);

    $erreur = '';
    if( strlen($_POST['pseudo']) <=3 || strlen($_POST['pseudo']) > 20 ){
        $erreur .= '<div class="alert alert-danger text-center" role="alert"><p>Le Pseudo DOIT avoir entre 4 et 20 caratères!</p></div>';
    }
    if(!preg_match('#^[a-zA-Z0-9._-]+$#', $_POST['pseudo'])){
        $erreur .= '<div class="alert alert-danger text-center" role="alert"><p>Le Pseudo DOIT contenir uniquement des caractères de a-z, A-Z, 0-9 et . _ - !</p></div>';
    }

    // on cherche dans la BD si le pseudo envoyé depuis le formulaire il n'y a pas de membre existant
    $req = $pdo->query("SELECT * FROM membre WHERE pseudo = '$_POST[pseudo]'");
    if($req->rowCount() >=1){
        $erreur .= '<div class="alert alert-danger text-center" role="alert"><p>Le Pseudo existe déjà, veuillez en saisir un autre!</p></div>';
    }
    // on parcourt notre tableau $_Post
    foreach($_POST as $indice => $valeur)//pour chaque ligne de notre tableau $_POST(une ligne = indice => valeur)
    {
        //la fonction addslashes permet d'échapper les quotes
        $_POST[$indice] = addslashes($valeur);
    }

    // oncrypte le mdp en utilisant la fonction password_hash
    $_POST['mdp'] = password_hash($_POST['mdp'], PASSWORD_DEFAULT);

    //si la variable erreur reste vide, cela veut dire que nous n'avons aucune erreur et donc nous pouvons envoyer en BD
    if(empty($erreur)){

        $date_enregistrement = date('y-m-d h:i:s');
        //debug($date_enregistrement);
        //on insert les données dans la BD
        $pdo->query("INSERT INTO membre (pseudo, mdp, nom, prenom, email, civilite, ville, code_postal, adresse, date_enregistrement) VALUES ('$_POST[pseudo]', '$_POST[mdp]', '$_POST[nom]', '$_POST[prenom]', '$_POST[email]', '$_POST[civilite]', '$_POST[ville]', '$_POST[cp]', '$_POST[adresse]', '$date_enregistrement')");

        $content .= '<div class="alert alert-success" role="alert">Inscription validée ! </div>';
    }

    $content .= $erreur;
}
?>

<?php require_once("inc/header.inc.php") ?>

    <?= $content ?>

    <form method="post" action="">
        <label for="pseudo">Pseudo</label>
        <input type="text" name="pseudo" id="pseudo" placeholder="Votre Pseudo" class="form-control">

        <label for="nom">Nom</label>
        <input type="text" name="nom" id="nom" placeholder="Votre Nom" class="form-control">

        <label for="prenom">Prenom</label>
        <input type="text" name="prenom" id="prenom" placeholder="Votre Prénom" class="form-control">

        <label for="mdp">Mot de Passe</label>
        <input type="password" name="mdp" id="mdp" placeholder="Votre Mot de Passe" class="form-control">

        <label for="email">Email</label>
        <input type="email" name="email" id="email" class="form-control" placeholder="Votre Email"><br>
    
        <label for="civilite">Civilité</label><br>
        <input type="radio" name="civilite" id="civilite" value="m" checked>
        Homme --
        <input type="radio" name="civilite" id="civilite" value="f" checked>
        Femme<br>

        <label for="ville">Ville</label>
        <input type="text" name="ville" id="ville" placeholder="Votre Ville" class="form-control">

        <label for="cp">Code Postal</label>
        <input type="text" name="cp" id="cp" placeholder="Votre CP" class="form-control">

        <label for="adresse">Adresse</label>
        <textarea type="text" name="adresse" id="adresse" placeholder="Votre Adresse" class="form-control"></textarea>

        <input type="submit" class="btn btn-default">
    </form>

<?php require_once("inc/footer.inc.php") ?>