<?php
session_start();

// Connexion à la base de données
require('bd.php');
$bdd = getBD();

$id_show = $_POST['id_show'];
$id_us = $_SESSION['utilisateur']['id'];
$date = date('Y-m-d H:i:s');
$code = isset($_SESSION['code']) ? $_SESSION['code'] : '0';

$sql = "INSERT INTO regarder (date, id_show, id_us, code) VALUES (?,?,?,?)";
$stmt = $bdd->prepare($sql);
$stmt->execute([$date, $id_show, $id_us, $code]);

if ($code != '0'){
	// Mettre à jour la variable en_cours à 0 dans la table salle
	$sql2 = "UPDATE salle SET en_cours = 0 WHERE code = ?";
	$stmt2 = $bdd->prepare($sql2);
	$stmt2->execute([$code]);
}

// Rediriger l'utilisateur vers la page de fin
header('Location: bye.html');
exit();
?>
