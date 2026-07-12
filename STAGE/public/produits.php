<?php
require_once('../includes/connexion.php');

// Récupération des catégories
$sqlCategories = "SELECT DISTINCT categorie FROM produits ORDER BY categorie";
$categorie = $pdo->query($sqlCategories);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles.css">
    <title>Produits</title>
</head>
<body>

<?php require '../includes/header.php'; ?>

<div class="titre_produits">
    <span></span>
    <h2>Nos produits</h2>
    <span></span>
</div>

<?php while($categorieData = $categorie->fetch(PDO::FETCH_ASSOC)) : ?>

    <section class="categorie">

        <h2><?= htmlspecialchars($categorieData['categorie']); ?></h2>

        <div class="produits">

            <?php
            $sqlProduits = "SELECT * FROM produits WHERE categorie = ?";
            $stmt = $pdo->prepare($sqlProduits);
            $stmt->execute([$categorieData['categorie']]);
            ?>

            <?php while($produit = $stmt->fetch(PDO::FETCH_ASSOC)) : ?>

                <div class="carte">

                    <img
                        src="../assets/images/<?= htmlspecialchars($produit['image']); ?>"
                        alt="<?= htmlspecialchars($produit['nom']); ?>"
                    >

                    <h3><?= htmlspecialchars($produit['nom']); ?></h3>

                    <p><?= htmlspecialchars($produit['description']); ?></p>

                    <span><?= htmlspecialchars($produit['prix']); ?> €</span>

                </div>

            <?php endwhile; ?>

        </div>

    </section>

<?php endwhile; ?>

<?php include '../includes/footer.php'; ?>

</body>
</html>