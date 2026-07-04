<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="navb.css">
</head>
<body>
    <nav class="navbar">
        <div class="titre">GEI</div>

        <div class="liens">
            <a href="contenus_editoriaux.php">Contenus éditoriaux</a>
            <a href="carte_france.php">Carte de France</a>
            <a href="contact.php">Contact</a>
            <a href="RGPD.php">Mentions Légales</a>
        </div>

        <form class="recherche" action="recherche.php" method="GET">
            <input type="text" name="mot_cle" placeholder="Rechercher..." required>
        </form>
    </nav>
</body>
</html>