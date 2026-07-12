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

//Récupération du produit
$sql = $pdo->prepare("SELECT * FROM produits WHERE id=?");
$sql->execute([$id]);

$produit = $sql->fetch(PDO::FETCH_OBJ);

//Produit inexistant
if(!$produit){
    header("Location:accueil.php");
    exit();
}

//Modification du produit
if(isset($_POST['modifier'])){
    $nom = trim($_POST['nom']);
    $description = trim($_POST['description']);
    $prix = trim($_POST['prix']);
    $categorie = trim($_POST['categorie']);

    $imageName= $produit->image;

    //La nouvelle image
    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){
        $extensions = ['jpg', 'jpeg', 'png', 'webp'];
        $fileName = $_FILES['image']['name'];
        $tmpName = $_FILES['image']['tmp_name'];

        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if(in_array($fileExt, $extensions)){
            //Nom unique de l'image
            $imageName = uniqid() . "." . $fileExt;

            //Upload image
            move_uploaded_file(
                $tmpName,
                "../assets/images/" . $imageName
            );
        }
    }

    //Mise à jour du produit
    $update = $pdo->prepare("UPDATE produits SET nom=?, description=?, prix=?, categorie=?, image=? WHERE id=?");
    $update->execute([$nom, $description, $prix, $categorie, $imageName, $id]); 

    $_SESSION['success'] = "Produit modifié avec succès 👍";
    header("Location:accueil.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Modifier Produit</title>
    <link rel="stylesheet" href="accueil.css">
</head>
<body>

    <h2>Modifier le Produit</h2>
    <form method="POST" enctype="multipart/form-data"> 
        <!-- Id -->
         <input type="hidden" name="id" value="<?php echo $produit->id?>">
        <!-- Nom -->
         <input placeholder="Nom du produit" type="text" name="nom" value="<?php echo htmlspecialchars($produit->nom)?>"required>
        <br><br>

        <!--Description -->
        <textarea placeholder="Description" name="description"><?= htmlspecialchars($produit->description)?></textarea>
        <br><br>

        <!-- Prix -->
         <input placeholder="Prix" type="number" step="0.01" name="prix" value="<?= htmlspecialchars($produit->prix)?>"required>
         <br><br>

        <!--Catégorie -->
         <input placeholder="Catégorie" type="text" name="categorie" value="<?= htmlspecialchars($produit->categorie)?>"required>
         <br><br>

        <!-- Ancienne image -->
          <?php if(!empty($produit->image)): ?>
            <img src="../assets/images/<?= htmlspecialchars($produit->image)?>"
            alt="Produit" width="200">
          <?php endif; ?>
          <br><br>

        <!-- Nouvelle image -->
         <input type="file" name="image" accept="image/*">
         <br><br>

        <!-- Bouton modifier -->
         <button type="submit" name="modifier">
            Enregistrer les modifications
          </button>
    </form>   
</body>
</html>