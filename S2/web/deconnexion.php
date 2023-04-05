<?php
session_start(); // Démarre la session en cours

if (isset($_SESSION['utilisateur'])) {

    // Met à jour en_cours à false pour la salle correspondante si l'utilisateur a creer une salle
    $id_us = $_SESSION['utilisateur']['id'];

    //Connexion à la bd
    require('bd.php');
    $bdd = getBD();

    // Vérifie si l'utilisateur a une salle en cours
    $stmt = $bdd->prepare('SELECT salle.en_cours, salle.code
                           FROM creer, salle 
                           WHERE creer.code = salle.code AND creer.id_us = :id_us');
    $stmt->execute(array('id_us' => $id_us));
    $en_cours = $stmt->fetch();

    if ($en_cours['en_cours']) {
        $stmt = $bdd->prepare('UPDATE salle SET en_cours = false WHERE code = :code');
        $stmt->execute(array('code' => $en_cours['code']));
    }
    session_unset(); // Efface toutes les données de la session
    header("Location: 1.html"); // Redirige l'utilisateur vers la page d'accueil
    exit(); // Met fin au script
} else {
    // l'utilisateur n'est pas connecté, redirigez-le vers la page de connexion
    header("Location: connexion.php");
    exit();
}
?>