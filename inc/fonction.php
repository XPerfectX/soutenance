<?php  
    function debug($var, $mode =1){
        $trace = debug_backtrace();
        $trace = array_shift($trace);

        echo "<stong>debug demandé dans le fichier : $trace[file] en ligne : $trace[line]</strong>" ;
            if($mode == 1){
                echo '<pre>'; print_r($var); '</pre>';
            }
            else{
                echo '<pre>'; var_dump($var); echo '</pre>';
            }
    }
    function internauteEstConnecte()
    {
        if(!isset($_SESSION['membre'])) return false;
        else return true;
    }
    function internauteEstConnecteEtEstAdmin()
    {
        if(internauteEstConnecte() AND $_SESSION['membre']['statut'] == 1)
        {
            return true;
        }else{
            return false;
        }
    }

    function creationPanier()
    {
        if(!isset($_SESSION['panier']))
        {
           $_SESSION['panier'] = []; 
           $_SESSION['panier']['id_produit'] = [];
           $_SESSION['panier']['quantite'] = [];
           $_SESSION['panier']['prix'] = [];
        }
    }

    function ajoutProduitPanier($id_produit, $quantite, $prix) 
    {
        creationPanier();
        // on recherche si l'id du produit qu'on ajoute dans le panier se trouve déjà dans la session
        $position_produit = array_search($id_produit, $_SESSION['panier']['id_produit']);

        if($position_produit !== false) //le produit existe dans le panier
        {
            $_SESSION['panier']['quantite'][$position_produit] += $quantite;
        }else{
            $_SESSION['panier']['id_produit'][]= $id_produit;
            $_SESSION['panier']['quantite'][]= $quantite; 
            $_SESSION['panier']['prix'][]= $prix;  
        }
    }

    function calculTotal()
    {
        $total = 0;
        for($i=0; $i< count($_SESSION['panier']['id_produit']); $i++)
        {
            $total += $_SESSION['panier']['quantite'][$i] * $_SESSION['panier']['prix'][$i];
        }

        return round($total, 2);
    }

    function retirerProduit($id_produit_a_supprimer)
    {
        $position_produit = array_search($id_produit_a_supprimer, $_SESSION['panier']['id_produit']);

        if($position_produit !== false) 
        {
            array_splice($_SESSION['panier']['id_produit'], $position_produit, 1);
            array_splice($_SESSION['panier']['quantite'], $position_produit, 1);
            array_splice($_SESSION['panier']['prix'], $position_produit, 1);
        }
    }
?>