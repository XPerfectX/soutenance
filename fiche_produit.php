<?php
require_once("inc/init.php");

if(!isset($_GET['id_produit']))
{
    //si dans l'url il n'y a pas d'id_produit on renvoit vers la page index
    header('location:index.php');
    exit();
}

if (isset($_GET['id_produit']))
{
    //on récupère le produit dont l'id est celui qui se trouve dans l'url qui du coup est récupéré par le $_GET
    $req = $pdo->query("SELECT * FROM produit WHERE id_produit = '$_GET[id_produit]'");
}

if($req->rowCount() <= 0)
{
    header('location:index.php');
    exit();
}

$produit = $req->fetch(PDO::FETCH_ASSOC);

$content .= "<h1>$produit[titre]</h1>";
$content .= "<p>categorie : $produit[categorie]</p>";
$content .= "<p>couleur : $produit[couleur]</p>";
$content .= "<p>taille : $produit[taille]</p>";
$content .= "<p> : <img width=\"400\" src=\"$produit[photo]\"</p>";
$content .= "<p>prix : $produit[prix]</p>";

if($produit['stock'] > 0)
{
    $content .= "<p> Nombre de produits disponible : $produit[stock]</p><br>";
    $content .= "<form method=\"post\" action=\"panier.php\" >";
    $content .= "<input type=\"hidden\" name=\"id_produit\" value=\"$produit[id_produit]\" ><br>";

    $content .= "<label for=\"quantite\">Quantité</label>";
    $content .= "<select name=\"quantite\" id=\"quantite\">";
        for($i=1; $i <= $produit['stock']; $i++)
        {
            $content .= "<option>$i</option>";
        }

$content .= "</select><br>";
$content .= "<input type=\"submit\" value=\"ajouter au panier\" name=\"ajouter_panier\" class=\"btn btn-default\"><br>";
$content .="</form>";
}


?>



<?php require_once("inc/header.inc.php") ?>

<div class="text-center">
    <?= $content ?>
</div>



<?php require_once("inc/footer.inc.php")?>