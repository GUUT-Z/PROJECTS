<?php
require_once('../includes/connexion.php');
session_start();

//Vérification de l'admin
if(!isset($_SESSION['autorise']) || $_SESSION['role'] != "Admin"){
    header("Location: index.php");
    exit();
}

//vérification du formulaire 
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $nom = trim($_POST['nom']);
    $description = trim($_POST['description']);
    $prix = trim($_POST['prix']);
    $categorie = trim($_POST['categorie']);

    $imageName = "";

    //La gestion de l'image
    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){
        $extensions = ['jpg', 'jpeg', 'png', 'webp'];
        $fileName = $_FILES['image']['name'];
        $tmpName = $_FILES['image']['tmp_name'];

        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if(in_array($fileExt, $extensions)){
            //Nom unique
            $imageName = uniqid() . "." . $fileExt;
            //Déplacement l'image
            move_uploaded_file(
                $tmpName, "../assets/images/" . $imageName
            );
        }else{
            die("Le format est invalide.");
        }
    }
    //Ajout du produit dans la BDD
    $sql = $pdo->prepare("
        INSERT INTO produits(
            nom,
            description,
            prix,
            categorie,
            image
        )
            VALUES(?,?,?,?,?)
    ");

    $sql->execute([
        $nom,
        $description,
        $prix,
        $categorie,
        $imageName
    ]);
//Le message de succès
$_SESSION['success'] = "Produit ajouté avec succès ✅";
header("location: accueil.php");
exit();
}
?>