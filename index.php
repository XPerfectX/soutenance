<?php
require_once("inc/init.php");

    $req = $pdo->query('SELECT DISTINCT(categorie) FROM produit');

    $content .= '<div class="row">';
    $content .= '<div class="col-md-3"><div class="list-group">';
    
    $content .= '<li><a href=" '. URL .' " class="list-group-item">Tous les produits</a></li>';

    while($categorie = $req->fetch(PDO::FETCH_ASSOC))
    {
        $content .= "<li><a href=\"?categorie=$categorie[categorie]\" class=\"liste-group-item\">$categorie[categorie]</a></li>";
    }
    
    $content .= '</div></div>';

    $content .= '<div class="col-md-8 col-md-offset-1">';

    if(isset($_GET['categorie']))
    {
        $req = $pdo->query("SELECT * FROM produit WHERE categorie = '$_GET[categorie]' ");
    }else{
        $req = $pdo->query("SELECT * FROM produit");
    }

    $content .= '<div class="row">';
    while($produit = $req->fetch(PDO::FETCH_ASSOC))
    {
            $content .= '<div class="thumbnail col-sm-4 col-lg-4 col-md-4"> 
                            <a href="fiche_produit.php?id_produit='. $produit['id_produit'] . ' "><img width="200" src=" '. $produit['photo'] .'"></a> 
                            <div class="caption">
                                <a href="fiche_produit.php?id_produit='. $produit['id_produit'] . ' "> <h4> ' . $produit['titre'] .  ' </h4></a> 
                                <p>'. $produit['description'] .' <strong>' . $produit['prix'] . '  €</strong></p>
                            </div>
                        </div>';
    }
    $content .= '</div></div></div>'; 
?>

<!------------------------------------------------------------------------------->

<?php require_once("inc/header.inc.php") ?>


    <h1>Nos Produits</h1>
    <p>Voici notre catalogue de produits</p>
    <hr>
    <?= $content ?>
<?php require_once("inc/footer.inc.php")?>    
