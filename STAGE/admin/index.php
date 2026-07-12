<?php
require_once('../includes/connexion.php'); 
session_start(); 

$erreur = ""; 

if(isset($_POST['connexion'])){
    
    $pseudo = htmlspecialchars($_POST['pseudo']); 
    $mdp = $_POST['mdp'];

    $utilExiste = false;

    $sql = $pdo->prepare("SELECT * FROM membres WHERE pseudo = ?");
    $sql->execute (array($pseudo));
    $utilExiste= $sql->fetchAll(PDO::FETCH_OBJ);

    $nb_result = count($utilExiste);

    if ($nb_result > 0) {

        $mdp_bdd = $utilExiste[0]->mdp; 

        if (password_verify($mdp, $mdp_bdd)) {

            $util = $utilExiste[0];
            $_SESSION['pseudo'] = $util->pseudo;
            $_SESSION['autorise'] = true;
            $_SESSION['role'] = $util->role;
            
            if($util->role == "Admin"){
                header("Location:accueil.php");
            }else{
                header("Location: index.php");
            }
            exit(); 
        } else {
            $erreur = "Mot de passe incorrect.";
        }
    } else {
        $erreur = "Ce pseudo n'est pas inscrit dans la base.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="connexion.css">
    <title>Connexion</title>
</head>
<body>
    <div class="formulaire">
        <h2>Connexion</h2>
        <form method="post">
        pseudo:<input type="text" name="pseudo" placeholder=" pseudo" required><br><br>
        Mot de passe:<input type="password" name="mdp" placeholder="mot de passe" required ><br><br>

            <input type="submit" name="connexion" value="Se connecter"><br><br>
        </form>

<?php 
    if(!empty($erreur)){
        echo '<p style="color:red; text-align:center;">' . $erreur . '</p>';
    }
?>
    </div>
</body>
</html>