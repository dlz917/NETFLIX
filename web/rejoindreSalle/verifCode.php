<?php
session_start();
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
    // Le code existe dans la table, enregistrer l'accès dans la table "acceder"
    if(isset($_SESSION['utilisateur'])) {
        $id_us = $_SESSION['utilisateur']['id'];
    } else {
        // rediriger l'utilisateur vers une page de connexion
        header('Location: ../connexion.php');
        exit();
    }
    $date = date("Y-m-d H:i:s");
    $sql = "INSERT INTO acceder(id_us, code, date) VALUES (?, ?, ?)";
    $stmt = $bdd->prepare($sql);
    $stmt->execute([$id_us, $code, $date]);

    // Rediriger vers la page user.php
    header('Location: ./user.php');
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

