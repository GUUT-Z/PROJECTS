<?php
include("connexion.php");
include("navbar.php");

$recherche = isset($_GET['mot_cle']) ? trim($_GET['mot_cle']) : '';
$resultats = [];

if ($recherche != '') {
    $param = "%$recherche%";

    // On utilise des noms différents (:k1, :k2...) pour être sûr que ça marche partout
    $sql = "
        SELECT Titre, Resume, Description, 'Contenu' as Categorie 
        FROM Contenus_editoriaux 
        WHERE Titre LIKE :Titre OR Resume LIKE :Resume OR Description LIKE :Description
        
        UNION
        
        SELECT Nom as Titre, Secteur as Resume, 'Info partenaire GEI' as Description, 'Entreprise' as Categorie 
        FROM Entreprises 
        WHERE Nom LIKE :Nom OR Secteur LIKE :Secteur
    ";

    $stmt = $connexion->prepare($sql);
    
    // On lie chaque paramètre à la variable
    $stmt->execute([
        'Titre' => $param,
        'Resume' => $param,
        'Description' => $param,
        'Nom' => $param,
        'Secteur' => $param
    ]);
    
    $resultats = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Résultats de recherche</title>
    <link rel="stylesheet" href="rech.css">
</head>
<body>

<div class="container-recherche">
    <h1>Résultats de recherche</h1>
    
    <?php
    if ($recherche == '') {
        echo '<p>Veuillez saisir un mot-clé.</p>';
    } else {
        echo '<p>Il y a ' . count($resultats) . ' résultat(s) pour "' . htmlspecialchars($recherche) . '"</p>';

        if (count($resultats) > 0) {
            foreach ($resultats as $res) {
                // On détermine la couleur du badge simplement
                $classeBadge = ($res['Categorie'] == 'Entreprise') ? 'badge-entreprise' : 'badge-contenu';
                
                echo '<div class="resultat-item">';
                echo '  <span class="badge ' . $classeBadge . '">' . $res['Categorie'] . '</span>';
                echo '  <h3>' . htmlspecialchars($res['Titre']) . '</h3>';
                echo '  <div class="description-complete">';
                echo '    <p><strong>Résumé :</strong> ' . htmlspecialchars($res['Resume']) . '</p>';
                echo '    <p><strong>Description :</strong><br>' . htmlspecialchars($res['Description']) . '</p>';
                echo '  </div>';
                echo '</div>';
            }
        } else {
            echo '<p>Aucun résultat trouvé.</p>';
        }
    }
    ?>
</div>

</body>
</html>