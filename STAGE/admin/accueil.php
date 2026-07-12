<?php
require_once('../includes/connexion.php');
session_start();

// Vérification de l'admin
// MODIFICATION : ajout de isset($_SESSION['role']) pour éviter les warnings
if (
    !isset($_SESSION['autorise']) ||
    !isset($_SESSION['role']) ||
    $_SESSION['role'] !== "Admin"
) {
    header("Location: index.php");
    exit();
}

// Récupération des catégories
$categories = $pdo->query("
    SELECT DISTINCT categorie
    FROM produits
    ORDER BY categorie
")->fetchAll(PDO::FETCH_OBJ);

// MODIFICATION : correction de la requête SQL des prix
$prix = $pdo->query("
    SELECT DISTINCT prix
    FROM produits
    ORDER BY prix ASC
")->fetchAll(PDO::FETCH_OBJ);

// Recherche des produits
$search = "";
$categories_filtre = "";

// MODIFICATION : ajout de l'initialisation de $prix_filtre
$prix_filtre = "";

if (isset($_POST['search'])) {
    $search = trim($_POST['search']);
}

if (isset($_POST['categories_filtre'])) {
    $categories_filtre = trim($_POST['categories_filtre']);
}

if (isset($_POST['prix_filtre'])) {
    $prix_filtre = trim($_POST['prix_filtre']);
}

// MODIFICATION : ajout du filtre sur le prix
$sql = $pdo->prepare("
    SELECT *
    FROM produits
    WHERE nom LIKE ?
    AND (categorie = ? OR ? = '')
    AND (prix = ? OR ? = '')
    ORDER BY date_ajout DESC
");

$sql->execute([
    "%$search%",
    $categories_filtre,
    $categories_filtre,
    $prix_filtre,
    $prix_filtre
]);

$produits = $sql->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil - Admin</title>
    <link rel="stylesheet" href="accueil.css">
</head>
<body>

    <div class="en-tête">

        <h1>
            Bienvenue <?= htmlspecialchars($_SESSION['pseudo']) ?> 👨‍🍳
        </h1>

        <!-- Message de succès après modification d'un produit -->
        <?php if (isset($_SESSION['success'])) : ?>

            <!-- MODIFICATION : correction des propriétés CSS -->
            <p style="
                background:#d1fae5;
                color:#065f46;
                padding:15px;
                border-radius:10px;
                margin-bottom:20px;
                text-align:center;
                font-weight:bold;
            ">
                <?= htmlspecialchars($_SESSION['success']) ?>
            </p>

            <?php unset($_SESSION['success']); ?>

        <?php endif; ?>

        <!-- Déconnexion -->
        <form action="deconnexion.php" method="POST" class="form-deco">
            <button type="submit" class="deconnexion">
                Déconnexion
            </button>
        </form>

    </div>

    <!-- Recherche -->
    <form method="POST">

        <input
            type="text"
            name="search"
            placeholder="Nom du produit"
            value="<?= htmlspecialchars($search) ?>"
        >

        <!-- Filtre catégorie -->
        <select name="categories_filtre">

            <option value="">
                -- Toutes les catégories --
            </option>

            <?php foreach ($categories as $cat) : ?>

                <option
                    value="<?= htmlspecialchars($cat->categorie) ?>"
                    <?= $categories_filtre === $cat->categorie ? 'selected' : '' ?>
                >
                    <?= htmlspecialchars($cat->categorie) ?>
                </option>

            <?php endforeach; ?>

        </select>

        <!-- Filtre prix -->
        <select name="prix_filtre">

            <option value="">
                -- Tous les prix --
            </option>

            <!-- MODIFICATION : correction du foreach -->
            <?php foreach ($prix as $p) : ?>

                <option
                    value="<?= htmlspecialchars($p->prix) ?>"
                    <?= $prix_filtre == $p->prix ? 'selected' : '' ?>
                >
                    <?= htmlspecialchars($p->prix) ?> €
                </option>

            <?php endforeach; ?>

        </select>

        <button type="submit">
            Rechercher
        </button>

    </form>

    <!-- Ajouter un produit -->
    <h2>Ajouter un produit</h2>

    <form
        method="POST"
        action="ajout_produit.php"
        enctype="multipart/form-data"
    >

        <input
            type="text"
            name="nom"
            placeholder="Nom du produit"
            required
        >

        <br><br>

        <textarea
            name="description"
            placeholder="Description du produit"
        ></textarea>

        <br><br>

        <input
            type="number"
            step="0.01"
            name="prix"
            placeholder="Prix"
            required
        >

        <br><br>

        <input
            type="text"
            name="categorie"
            placeholder="Catégorie"
            required
        >

        <br><br>

        <input
            type="file"
            name="image"
            accept="image/*"
            required
        >

        <br><br>

        <button type="submit" name="ajouter">
            Ajouter le produit
        </button>

    </form>

    <!-- Liste des produits -->
    <h2>Liste des produits</h2>

    <?php if (count($produits) > 0) : ?>

        <div class="produits">

            <?php foreach ($produits as $p) : ?>

                <div class="carte">

                    <?php if (!empty($p->image)) : ?>

                        <img
                            src="../assets/images/<?= htmlspecialchars($p->image) ?>"
                            alt="Produit"
                        >

                    <?php endif; ?>

                    <div class="contenu">

                        <h3>
                            <?= htmlspecialchars($p->nom) ?>
                        </h3>

                        <p>
                            <?= htmlspecialchars($p->description) ?>
                        </p>

                        <p>
                            Catégorie :
                            <?= htmlspecialchars($p->categorie) ?>
                        </p>

                        <p class="prix">
                            <?= htmlspecialchars($p->prix) ?> €
                        </p>

                    </div>

                    <!-- Modifier -->
                    <form action="modifier_produit.php" method="POST">

                        <input
                            type="hidden"
                            name="id"
                            value="<?= $p->id ?>"
                        >

                        <button type="submit" class="modifier">
                            Modifier
                        </button>

                    </form>

                    <!-- Supprimer -->
                    <form action="supprimer_produit.php" method="POST">

                        <input
                            type="hidden"
                            name="id"
                            value="<?= $p->id ?>"
                        >

                        <button
                            type="submit"
                            class="supprimer"
                            onclick="return confirm('Supprimer ce produit ?')"
                        >
                            Supprimer
                        </button>

                    </form>

                </div>

            <?php endforeach; ?>

        </div>

    <?php else : ?>

        <p>Aucun produit trouvé.</p>

    <?php endif; ?>

</body>
</html>