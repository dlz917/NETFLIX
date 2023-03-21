<?php
// Récupérer le code entré par l'utilisateur
$code = $_POST['Code'];

// Connexion à la base de données
require('../bd.php');
$bdd = getBD();

// Préparer la requête SQL pour vérifier si le code existe dans la table Salle
$sql = "SELECT * FROM salle WHERE code = ?";
$stmt = $bdd->prepare($sql);
$stmt->execute([$code]);

// Récupérer le résultat de la requête
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Vérifier si le code existe dans la table
if (count($rows) > 0) {
    // Le code existe dans la table, rediriger vers la page user.html
    header('Location: ./user.html');
    exit;
} else {
    // Le code n'existe pas dans la table, afficher un message d'erreur sur la page codeForm.php
    header('Location: ./codeForm.php?error=1');
    exit;
}

// Fermer la connexion à la base de données
$stmt->closeCursor();
$conn = null;
?>
