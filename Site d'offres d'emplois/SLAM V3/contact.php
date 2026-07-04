<?php 
include("connexion.php");
include("navbar.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $nom_entreprise = $_POST['nom-e'];
    $adresse = $_POST['adresse-e'];
    $cp_entreprise = $_POST['CP-e'];
    $region = $_POST['region'];
    $email_entreprise = $_POST['email-e'];
    $tel_entreprise = $_POST['telephone-e'];
    $secteur = $_POST['secteur'];
    
    $nom_chef = $_POST['nom'];
    $prenom_chef = $_POST['prenom'];
    $email_chef = $_POST['email'];
    $tel_chef = $_POST['tel'];
    
    // Insérer dans la table Entreprises
    $sql_entreprise = "INSERT INTO Entreprises (Nom, Adresse, CP_Entreprise, Region, Email, Tel, Secteur) 
                      VALUES (:nom, :adresse, :cp, :region, :email, :tel, :secteur)";
    
    $stmt_entreprise = $connexion->prepare($sql_entreprise);
    $stmt_entreprise->execute([
        ':nom' => $nom_entreprise,
        ':adresse' => $adresse,
        ':cp' => $cp_entreprise,
        ':region' => $region,
        ':email' => $email_entreprise,
        ':tel' => $tel_entreprise,
        ':secteur' => $secteur
    ]);
    
    // Récupérer l'ID de l'entreprise insérée
    $id_entreprise = $connexion->lastInsertId();
    
    // Insérer dans la table Chef_entreprise
    $sql_chef = "INSERT INTO Chef_entreprise (id_entreprise, Nom, Prenom, Email, Tel) 
                VALUES (:id_entreprise, :nom, :prenom, :email, :tel)";
    
    $stmt_chef = $connexion->prepare($sql_chef);
    $stmt_chef->execute([
        ':id_entreprise' => $id_entreprise,
        ':nom' => $nom_chef,
        ':prenom' => $prenom_chef,
        ':email' => $email_chef,
        ':tel' => $tel_chef
    ]);
    
    echo "Données insérées avec succès !";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Mention légales & Politique de confidentialité</title>
    <link rel="stylesheet" type="text/css" href="contact.css"> <!--Lien vers le fichier CSS pour appliquer les styles-->
</head>
<body>

        <!--  CONTENU PRINCIPAL -->
    <div class=titre>
        <h1> Contact </h1>
    </div>

    <div class="contact-center">
        <h2> Entrons en contact </h2>
        <p> Nous serons heureux de vous aider. Voici comment nous contacter.</p>
    </div>
    
        <!-- Section contact avec 3 colonnes-->
    <div class="contact-info-container">
        
        <!-- Colonne 1: Email -->
        <div class="contact-column">
            <div class="contact-item">
                <img src="images/email.avif" alt="Enveloppe" class="contact-icon">
                <h3>Email</h3>
                <p><a href="mailto:contact@monentreprise.fr">contact@monentreprise.fr</a></p>
            </div>
        </div>

        <!-- Colonne 2 : Téléphone -->
        <div class="contact-column">
            <div class="contact-item">
                <img src="images/tel.png" alt="Téléphone" class="contact-icon">
                <h3>Téléphone</h3>
                <p><a href="tel:+33123456789">+33 1 23 45 67 89</a></p>
            </div>
        </div>

        <!-- Colonne 3 : Adresse -->
        <div class="contact-column">
            <div class="contact-item">
                <img src="images/maps.jpg" alt="Localisation" class="contact-icon">
                <h3>Adresse</h3>
                <p>  22 avenue de l’explorateur de Kerguelen <br>98412 France</p>
            </div>
        </div>

    </div>

        <!--Formulaire de contact-->
<div class="contact-center">
    <h2>Vous souhaitez mettre en avant votre entreprise ?</h2>
    <p>Nous serons heureux de vous aider. Remplissez le formulaire afin de vous inscrire !</p>
</div>

<div class="form-container">
    <h2>Formulaire d'inscription</h2>

    <form method="post" action="" class="contact-form-wrapper">
        <div class="contact-form">
            <div class="form-column">
                <h2>Entreprise</h2>

                <div class="form-group">
                    <label for="nom-e">Nom <span style="color: red;">*</span></label>
                    <input type="text" id="nom-e" name="nom-e" required>
                </div>

                <div class="form-group">
                    <label for="adresse-e">Adresse <span style="color: red;">*</span></label>
                    <input type="text" id="adresse-e" name="adresse-e" required>
                </div>

                <div class="form-group">
                    <label for="CP-e">Code postal <span style="color: red;">*</span></label>
                    <input type="text" id="CP-e" name="CP-e" required>
                </div>

                <div class="form-group">
                    <label for="region">Région <span style="color: red;">*</span></label>
                    <select name="region" id="region" required>
                        <option value="">-- Sélectionner une région --</option>
                        <option value="Auvergne-Rhône-Alpes">Auvergne-Rhône-Alpes</option>
                        <option value="Bourgogne-Franche-Comté">Bourgogne-Franche-Comté</option>
                        <option value="Bretagne">Bretagne</option>
                        <option value="Centre-Val de Loire">Centre-Val de Loire</option>
                        <option value="Corse">Corse</option>
                        <option value="Grand Est">Grand Est</option>
                        <option value="Hauts-de-France">Hauts-de-France</option>
                        <option value="Île-de-France">Île-de-France</option>
                        <option value="Normandie">Normandie</option>
                        <option value="Nouvelle-Aquitaine">Nouvelle-Aquitaine</option>
                        <option value="Occitanie">Occitanie</option>
                        <option value="Pays de la Loire">Pays de la Loire</option>
                        <option value="Provence-Alpes-Côte d'Azur">Provence-Alpes-Côte d'Azur</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="email-e">Email <span style="color: red;">*</span></label>
                    <input type="email" id="email-e" name="email-e" required>
                </div>
                
                <div class="form-group">
                    <label for="telephone-e">Téléphone <span style="color: red;">*</span></label>
                    <input type="tel" id="telephone-e" name="telephone-e" required>
                </div>

                <div class="form-group">  
                    <label for="secteur">Secteurs d'activité <span style="color: red;">*</span></label>
                    <select name="secteur" id="secteur" required>
                        <option value="">-- Sélectionner un secteur --</option>
                        <option value="Secteur Primaire">Secteur Primaire</option> 
                        <option value="Secteur Secondaire">Secteur Secondaire</option>
                        <option value="Secteur Tertiaire">Secteur Tertiaire</option>
                        <option value="Secteur Quaternaire">Secteur Quaternaire</option>
                    </select>
                </div>
            </div>
            
            <div class="form-column">
                <h2>Chef d'entreprise</h2>

                <div class="form-group">
                    <label for="nom">Nom <span style="color: red;">*</span></label>
                    <input type="text" id="nom" name="nom" required>
                </div>
                
                <div class="form-group">
                    <label for="prenom">Prénom <span style="color: red;">*</span></label>
                    <input type="text" id="prenom" name="prenom" required>
                </div>

                <div class="form-group">
                    <label for="email">Email <span style="color: red;">*</span></label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="tel">Téléphone <span style="color: red;">*</span></label>
                    <input type="tel" id="tel" name="tel" required>
                </div>
            </div>
        </div>

        <div class="form-group checkbox-group">
            <input type="checkbox" id="consentement" name="consentement" required>
            <label for="consentement">J'accepte que mes données soient utilisées conformément à la <a href="RGPD.php">Politique de confidentialité</a> <span style="color: red;">*</span></label>
        </div>
        
        <button type="submit" class="form-submit">Envoyer</button>
    </form>
</div>

</body>
</html>