<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boutique</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Boutique</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="<?= URL ?>">Accueil</a>
            </li>
            <?php if(internauteEstConnecteEtEstAdmin()) : ?>
            <li class="nav-item">
                <a class="nav-link" href="<?= URL ?>admin/gestion_produit.php">BackOffice</a>
            </li>
            <?php endif; ?>
            <li class="nav-item">
                <a class="nav-link" href="<?= URL ?>panier.php">Panier</a>
            </li>

        <?php if(internauteEstConnecte()) :?>
            <!-- les 2 li suivantes s'affichent uniquement si je suis connecté -->
            <li class="nav-item">
                <a href="<?= URL ?>profil.php" class="nav-link">Profil</a>
            </li>
            <li class="nav-item">
                <a href="<?= URL ?>connexion.php?action=deconnexion" class="nav-link">Deconnexion</a>
            </li>
        <?php endif ?>

        <?php if(!internauteEstConnecte()) :?>
            <!-- les 2 li suivantes s'affichent uniquement si je ne suis pas connecté -->
            <li class="nav-item">
                <a href="<?= URL ?>inscription.php" class="nav-link">Inscription</a>
            <li class="nav-item">
                <a href="<?= URL ?>connexion.php" class="nav-link">Connexion</a>
            </li>
        <?php endif ?>
        </ul>
    </div>
    </nav>

    <div class="container">
        <div class="starter-template">

 