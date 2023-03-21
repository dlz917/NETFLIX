<?php
session_start();
// Connexion à la base de données MySQL
require('../bd.php');
$bdd = getBD();

if (isset($_POST['submit'])) {
    // Récupération des données du formulaire
    $type = $_POST['type'];
    $genre1 = $_POST['genre1'];
    $genre2 = $_POST['genre2'];
    $director = $_POST['director'];
    $date = date('Y-m-d H:i:s');
    if(isset($_SESSION['utilisateur'])) {
        $id_us = $_SESSION['utilisateur']['id'];
    } else {
        // rediriger l'utilisateur vers une page de connexion
        header('Location: connexion.php');
        exit();
    }

    //Récupération de id_genre1
    $stmt = $bdd->prepare('SELECT id_genre FROM genre_new WHERE genre = ?');
    $stmt->execute([$genre1]);
    $id_genre1 = $stmt->fetchColumn();

    //Récupération de id_genre2
    $stmt = $bdd->prepare('SELECT id_genre FROM genre_new WHERE genre = ?');
    $stmt->execute([$genre2]);
    $id_genre2 = $stmt->fetchColumn();

    // Insertion des données dans les tables CHOIX
    $sql = "INSERT INTO choix (ordre, date, type) VALUES (?,?,?)";
    $stmt = $bdd->prepare($sql);
    $stmt->execute([1, $date, $type]);

    //Recherche de l'identifiant du choix
    $stmt = $bdd->prepare('SELECT id_choix FROM choix WHERE date = ?');
    $stmt->execute([$date]);
    $id_choix = $stmt->fetchColumn();


    // Insertion des données dans les tables de liaison faire et avoird et avoirg
    $sql = "INSERT INTO faire (id_us, id_choix) VALUES ($id_us, $id_choix)";
    $stmt = $bdd->prepare($sql);
    $stmt->execute([$id_us, $id_choix]);

    $sql = "INSERT INTO avoirg (id_genre, id_choix) VALUES (?, ?)";
    $stmt = $bdd->prepare($sql);
    $stmt->execute([$id_genre1, $id_choix]);

    // Deuxième fois pour genre2
    // Insertion des données dans la table CHOIX
    $sql = "INSERT INTO choix (ordre, date, type) VALUES (?,?,?)";
    $stmt = $bdd->prepare($sql);
    $stmt->execute([1, $date, $type]);

    //Recherche de l'identifiant du choix
    $stmt = $bdd->prepare('SELECT id_choix FROM choix WHERE date = ? AND id_choix = ?');
    $stmt->execute([$date, $id_choix + 1]);
    $id_choix2 = $stmt->fetchColumn();


    // Insertion des données dans les tables de liaison faire et avoird et avoirg
    $sql = "INSERT INTO faire (id_us, id_choix) VALUES ($id_us, $id_choix2)";
    $stmt = $bdd->prepare($sql);
    $stmt->execute([$id_us, $id_choix2]);

    $sql = "INSERT INTO avoirg (id_genre, id_choix) VALUES (?, ?)";
    $stmt = $bdd->prepare($sql);
    $stmt->execute([$id_genre2, $id_choix2]);


    // Redirection vers la page de confirmation
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();

}
?>