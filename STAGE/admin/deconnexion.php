<?php
session_start();

//Suppression de toutes les variables
session_unset();

//Destruction de la session
session_destroy();

//Redirection vers connexion
header("Location: index.php");
exit();

?>