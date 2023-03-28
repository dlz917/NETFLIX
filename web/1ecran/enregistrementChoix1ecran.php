<?php
session_start();
// Connexion à la base de données MySQL
require('../bd.php');
$bdd = getBD();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupère les choix de l'utilisateur pour chaque champ de formulaire
    $type = isset($_POST['type']) ? $_POST['type'] : NULL;
    $genres = $_POST['genre'];
    $casts = $_POST['cast'];
    $directors = $_POST['director'];
    $date = date('Y-m-d H:i:s');
    if(isset($_SESSION['utilisateur'])) {
        $id_us = $_SESSION['utilisateur']['id'];
    } else {
        // rediriger l'utilisateur vers une page de connexion
        header('Location: connexion.php');
        exit();
    }

    // Calcule le nombre total d'éléments
    $total = max(count($genres), count($casts), count($directors));

    // Boucle sur chaque élément pour les insérer dans la base de données
    for ($i = 0; $i < $total; $i++) {
        // Récupère l'élément correspondant de chaque liste
        $genre = isset($genres[$i]) ? $genres[$i] : NULL;
        $cast = isset($casts[$i]) ? $casts[$i] : NULL;
        $director = isset($directors[$i]) ? $directors[$i] : NULL;

        // Insertion des données dans la table CHOIX
        $sql = "INSERT INTO choix (ordre, date, type) VALUES (?,?,?)";
        $stmt = $bdd->prepare($sql);
        $stmt->execute([1, $date, $type]);

        //Recherche de l'identifiant du choix
        $stmt = $bdd->prepare('SELECT id_choix FROM choix WHERE date = ?');
        $stmt->execute([$date]);
        $id_choix = $stmt->fetchColumn();

        // Insère les données dans les tables de liaison avec des vérifications NULL
        if ($genre !== NULL) {
            $stmt = $bdd->prepare('SELECT id_genre FROM genre_new WHERE genre = ?');
            $stmt->execute([$genre]);
            $id_genre = $stmt->fetchColumn();
            $stmt = $bdd->prepare('INSERT INTO avoirg (id_genre, id_choix) VALUES (?,?)');
            $stmt->execute([$id_genre, $id_choix]);
        }
        if ($cast !== NULL) {
            $stmt = $bdd->prepare('SELECT id_cast FROM cast_new WHERE cast = ?');
            $stmt->execute([$cast]);
            $id_cast = $stmt->fetchColumn();
            $stmt = $bdd->prepare('INSERT INTO avoirc (id_cast, id_choix) VALUES (?,?)');
            $stmt->execute([$id_cast, $id_choix]);
        }
        if ($director !== NULL) {
            $stmt = $bdd->prepare('SELECT id_direc FROM director_new WHERE director = ?');
            $stmt->execute([$director]);
            $id_direc = $stmt->fetchColumn();
            $stmt = $bdd->prepare('INSERT INTO avoird (id_direc, id_choix) VALUES (?,?)');
            $stmt->execute([$id_direc, $id_choix]);
        }

        // Insertion des données dans la table FAIRE
        $stmt = $bdd->prepare('INSERT INTO faire (id_us, id_choix) VALUES (?,?)');
        $stmt->execute([$id_us, $id_choix]);
    }}

    // Rediriger l'utilisateur vers la page des résultats
    header('Location: ../contenus1.html');
    exit();
?>