<?php
require_once("inc/init.php");

if(isset($_POST['ajouter_panier']))
{
    $req = $pdo->query("SELECT * FROM produit WHERE id_produit = $_POST[id_produit]");

    $produit = $req->fetch(PDO::FETCH_ASSOC);

    // debug($produit);
    // die();    
    ajoutProduitPanier($produit['id_produit'], $_POST['quantite'], $produit['prix']);
}

if(isset($_GET['action']) && $_GET['action'] == 'suppression')
{
    retirerProduit($_GET['id_produit']);
}

if(isset($_GET['action']) && $_GET['action'] == 'vider_panier')
{
    unset($_SESSION['panier']);
}

//debug($_SESSION);

$content .= '<table class="table">';
$content .= '<tr> <th>id produit</th> <th>quantité</th> <th>prix</th> <th>action</th> </tr>';

if(empty($_SESSION['panier']['id_produit']))
{
    $content .= '<tr><td colspan="3"> Votre panier est vide ! </td></tr>';
}else
{
    for($i = 0; $i < count($_SESSION['panier']['id_produit']); $i++)
    {
        $content .= '<tr>';
        $content .= '<td>' . $_SESSION['panier']['id_produit'][$i] . '</td>';
        $content .= '<td>' . $_SESSION['panier']['quantite'][$i] . '</td>';
        $content .= '<td>' . $_SESSION['panier']['prix'][$i] . '€</td>';
        $content .= '<td><a href="?action=suppression&id_produit='. $_SESSION['panier']['id_produit'][$i] .' ">retirer</a></td>';
        $content .= '</tr>';
    }

    $content .= '<th colspan="3">' . calculTotal() . '€ </th>';

    $content .= '<tr><td colspan="5"><a href="?action=vider_panier">Vider le panier</a></td></tr>';
}

$content .= '</table>';

?>

<?php require_once("inc/header.inc.php") ?>

    <h1>Panier</h1>
    <?= $content; ?>

<?php require_once("inc/footer.inc.php")?>