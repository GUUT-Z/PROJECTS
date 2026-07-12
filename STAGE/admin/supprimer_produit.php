<?php
require_once('../includes/connexion.php');
session_start();

//Vérification de l'admin
if(!isset($_SESSION['autorise']) || $_SESSION['role'] != "Admin"){
    header("Location: index.php");
    exit();
}

//Vérification de l'ID
if(!isset($_POST['id'])){
    header("Location:accueil.php");
    exit();
}
$id = intval($_POST['id']);

//Récupération de l'image
$sql = $pdo->prepare("SELECT image FROM produits WHERE id=?");
$sql->execute([$id]);

$produit = $sql->fetch(PDO::FETCH_OBJ);
//Produit inexistant
if(!$produit){
    header("Location: accueil.php");
    exit();
}

//Suppresion d'un image
if(!empty($produit->image)){
    $imagePath = "../assets/images/". $produit->image;
    if(file_exists($imagePath)){
        unlink($imagePath);
    }
}

//Suppression du produit
$supp=$pdo->prepare("DELETE FROM produits WHERE id=?");
$supp->execute([$id]);

//Le message de succès
$_SESSION['success'] = "Produit supprimé avec succès 🗑️";

//Redirection
header("Location:accueil.php");
exit();

?>