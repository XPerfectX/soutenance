<?php require_once('../inc/init.php'); 
if(!internauteEstConnecteEtEstAdmin())
{
     header('location: ../connexion.php');
     exit();
}

if($_POST)
{
   // debug ($_POST);
    //die();
    $photo_bdd = '';

    foreach($_POST as $indice => $valeur)
    {
        $_POST[$indice] = addslashes($valeur);
    }

    if(isset($_GET['action']) && $_GET['action'] == 'modification')
    {
        $req = $pdo->query("SELECT photo FROM produit WHERE id_produit = $_GET[id_produit]");
        $recup =$req->fetch(PDO::FETCH_ASSOC);

        if(!$_FILES['photo']['name'])
        {
            //traitemant photo
            if(!empty ($recup['photo']))
            {
                $photo_bdd = $recup['photo'];
            }
        }elseif($_FILES['photo']['name'])
        {
            $nom_photo = $_POST['reference'] .'_' . $_FILES['photo']['name'];
            $photo_bdd = URL ."photo/$nom_photo";
            $photo_dossier = RACINE_SITE . "photo/$nom_photo";

            copy($_FILES['photo']['tmp_name'], $photo_dossier);
            //fin photo
        }
        
    
        $pdo->query("UPDATE produit SET reference = '$_POST[reference]', categorie = '$_POST[categorie]', titre = '$_POST[titre]', description = '$_POST[description]', couleur = '$_POST[couleur]', taille = '$_POST[taille]', public = '$_POST[public]', photo = '$photo_bdd', prix = '$_POST[prix]', stock = '$_POST[stock]' WHERE id_produit = '$_POST[id_produit]' ");
        
        header('location:gestion_produit.php');
        exit();

    }else{

        //traitemant photo
        if($_FILES['photo']['name'])
        {
            //debug($_FILES);
        
            $nom_photo = $_POST['reference'] .'_' . $_FILES['photo']['name'];
            $photo_bdd =URL ."photo/$nom_photo";
            $photo_dossier = RACINE_SITE . "photo/$nom_photo";
            copy($_FILES['photo']['tmp_name'], $photo_dossier );
        }
        //fin photo

        $pdo->query("INSERT INTO produit (reference, categorie, titre, description, couleur, taille, public, photo, prix, stock) VALUES ('$_POST[reference]', '$_POST[categorie]', '$_POST[titre]','$_POST[description]', '$_POST[couleur]', '$_POST[taille]','$_POST[public]', '$photo_bdd', '$_POST[prix]', '$_POST[stock]')");
    }

}

if(isset($_GET['action']) && $_GET['action'] == 'modification')
{
    $req = $pdo->query("SELECT * FROM produit WHERE id_produit = '$_GET[id_produit]'");
    $produit_actuel = $req->fetch(PDO::FETCH_ASSOC);
}
$id_produit = (isset($produit_actuel['id_produit']))? $produit_actuel['id_produit']: '';
$reference = (isset($produit_actuel['reference']))? $produit_actuel['reference']: '';
$categorie = (isset($produit_actuel['categorie']))? $produit_actuel['categorie']: '';
$titre = (isset($produit_actuel['titre']))? $produit_actuel['titre']: '';
$description = (isset($produit_actuel['description']))? $produit_actuel['description']: '';
$couleur = (isset($produit_actuel['couleur']))? $produit_actuel['couleur']: '';
$taille = (isset($produit_actuel['taille']))? $produit_actuel['taille']: '';
$public = (isset($produit_actuel['public']))? $produit_actuel['public']: '';
$photo = (isset($produit_actuel['photo']))? $produit_actuel['photo']: '';
$prix = (isset($produit_actuel['prix']))? $produit_actuel['prix']: '';
$stock = (isset($produit_actuel['stock']))? $produit_actuel['stock']: '';





//----------------------------------------------------------------

if(isset($_GET['action']) && $_GET['action'] == 'supression')
{
    $pdo->query("DELETE FROM produit WHERE id_produit = '$_GET[id_produit]'");
    header('location:gestion_produit.php');
    exit();
}
//on récupère les produits
$req = $pdo->query("SELECT * FROM produit");

$content .= "<h1> Affichage des " . $req->rowCount() . " produits</h1>";
$content .= "<table class=\"table\"><tr>";

for($i = 0; $i < $req->columnCount(); $i++) 
{
    $colonne = $req->getColumnMeta($i);
    $content .= "<th>$colonne[name]</th>";
}

$content .= "<th>Modification</th>";
$content .= "<th>Supression</th>";
$content .= "</tr>";

while($ligne = $req->fetch(PDO::FETCH_ASSOC))
{
    $content .= "<tr>";
    foreach($ligne as $indice => $valeur) 
    {
        if($indice == 'photo')
        {
            $content .= "<td><img src=\"$valeur\" width=\"70\" class=\"img-responsive\"></td>";
        }else{
            $content .= "<td>$valeur</td>";
        }
    }
    $content .= "<td><a href=\"?action=modification&id_produit=$ligne[id_produit]\">Modification</a></td>";
    $content .= "<td><a onclick=\"return confirm('êtes vous sûr de vouloir supprimer le produit?');\" href=\"?action=supression&id_produit=$ligne[id_produit]\">Supression</a></td>";

    $content .= "</tr>";
}

$content .= "</table>";
$content .= "<hr>";

?>


<?php require_once('../inc/header.inc.php'); ?>

<?= $content ?>
<div class="text-center">

<form method="post" action="" enctype="multipart/form-data">
    <input type="hidden" name="id_produit" value="<?= $id_produit ?>">

    <label for="reference">Référence</label>
    <input type="text" name="reference" id="reference" placeholder="La Référence" class="form-control" value="<?= $reference ?>">

    <label for="categorie">Catégorie</label>
    <input type="text" name="categorie" id="categorie" placeholder="La Catégorie" class="form-control" value="<?= $categorie ?>">

    <label for="titre">Titre</label>
    <input type="text" name="titre" id="titre" placeholder="Le Titre" class="form-control" value="<?= $titre ?>">

    <label for="description">Description</label>
    <textarea name="description" id="description" cols="30" rows="10" placeholder="Description du Produit" class="form-control"><?= $description ?></textarea>

    <label for="couleur">Couleur</label>
    <select name="couleur" id="couleur" class="form-control">
        <option <?php if($couleur == 'bleu') echo 'selected'?>>bleu</option>
        <option <?php if($couleur == 'rouge') echo 'selected'?>>rouge</option>
        <option <?php if($couleur == 'vert') echo 'selected'?>>vert</option>
        <option <?php if($couleur == 'blanc') echo 'selected'?>>blanc</option>
        <option <?php if($couleur == 'noir') echo 'selected'?>>noir</option>
        <option <?php if($couleur == 'jaune') echo 'selected'?>>jaune</option>
        <option <?php if($couleur == 'violet') echo 'selected'?>>violet</option>
    </select>

    <label for="taille">Taille</label>
    <select name="taille" id="taille" class="form-control">
        <option <?php if($taille == 'S') echo 'selected'?>>S</option>
        <option <?php if($taille == 'M') echo 'selected'?>>M</option>
        <option <?php if($taille == 'L') echo 'selected'?>>L</option>
        <option <?php if($taille == 'XL') echo 'selected'?>>XL</option>
        <option <?php if($taille == 'XXL') echo 'selected'?>>XXL</option>
    </select>

    <label for="public">Public</label>
    <select name="public" id="public" class="form-control">
        <option value="m" <?php if($public == 'm') echo 'selected'?>>Homme</option>
        <option value="f" <?php if($public == 'f') echo 'selected'?>>Femme</option>
        <option value="mixte" <?php if($public == 'mixte') echo 'selected'?>>Mixte</option>
    </select>

    <label for="photo">Photo</label>
    <input type="file" name="photo" id="photo" class="form-control">
    <?php if(!empty($photo)) : ?>
        <img src="<?=$photo?>" alt="">
    <?php endif; ?>

    <label for="prix">Prix</label>
    <input type="text" name="prix" placeholder="prix" id="prix" class="form-control" value="<?= $prix ?>">

    <label for="stock">Stock</label>
    <input type="text" name="stock" id="stock" class="form-control" value="<?= $stock ?>">

    <input type="submit" value="enregistrer le produit" class="btn btn-default">

</form>
</div>

<?php require_once('../inc/footer.inc.php'); ?>