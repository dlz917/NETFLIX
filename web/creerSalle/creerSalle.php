﻿<?php
session_start();
// Connexion à la base de données MySQL
require('../bd.php');
$bdd = getBD();

// Récupération des données pour le menu "Genre 1"
$sql = "SELECT genre FROM genre_new";
$stmt = $bdd->query($sql);
$options_genre_1 = '<option>Pas de préférence</option>';
while ($row = $stmt->fetch()) {
    $options_genre_1 .= '<option>' . htmlspecialchars($row['genre']) . '</option>';
}

// Récupération des données pour le menu "Genre 2"
$sql = "SELECT genre FROM genre_new";
$stmt = $bdd->query($sql);
$options_genre_2 = '<option>Pas de préférence</option>';
while ($row = $stmt->fetch()) {
    $options_genre_2 .= '<option>' . htmlspecialchars($row['genre']) . '</option>';
}

// Récupération des données pour le menu "Director"
$sql = "SELECT director FROM director_new";
$stmt = $bdd->query($sql);
$options_director = '';
while ($row = $stmt->fetch()) {
    $options_director .= '<option>' . htmlspecialchars($row['director']) . '</option>';
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Un seul écran</title>
    <link href="../css/bootstrap.css" rel="stylesheet">

</head>
<body>
<header>
    <div class="logo">
        <img src="../images/logo.png" alt="Logo">
    </div>
</header>

<p class="prem">
    Envoyer votre code salle aux utilisateurs souhaités puis remplisser vos critères :
</p>
<div class="container">
<form action="enregistrementchoix_1ecran.php" method="post">
    <div class="row">
      <div class="col-md-4 text-start">
        <img src="../images/images.png" alt="IMG" title="User1" width="25%">
      </div>
    <div class="col-md-8">
        <div class="row">
          <div class="col-md-2">
            <select class="form-control w-100 me-2 rounded-0 custom-select text-dark font-weight-bold" name="type">
              <option>Type</option>
              <option>Movie</option>
              <option>TV Show</option>
            </select>
          </div>
          <div class="col-md-2">
            <select class="form-control w-100 me-2 rounded-0 custom-select text-dark font-weight-bold" name="genre1">
              <option>Genre 1</option>
              <?php echo $options_genre_1; ?>
            </select>
          </div>
          <div class="col-md-2">
            <select class="form-control w-100 me-2 rounded-0 custom-select text-dark font-weight-bold" name="genre2">
              <option>Genre 2</option>
              <?php echo $options_genre_2; ?>
            </select>
          </div>
          <div class="col-md-2">
            <select class="form-control w-100 me-2 rounded-0 custom-select text-dark font-weight-bold" name="director">
                <option>Réalisateur</option>
                <?php echo $options_director; ?>
            </select>
          </div>
          <div class="col-md-2">
                <button class="btn btn-primary rounded-0 w-100 font-weight-bold" type="submit" name="submit">Recherche</button>
          </div>
        </div>
        </form>
    </div>
</div>
</div>

<div class="fixed-top text-right mr-3 mb-3" style="margin-top: 30px; margin-right:50px;">
    <span style="color: white; font-weight: bold;">Votre code :</span>
    <div class="code-box bg-light d-inline-flex align-items-center justify-content-center">
        <span class="code-text font-weight-bold">3580</span>
    </div>
</div>

<div class="fixed-bottom text-right mr-3 mb-3">
  <button type="button" class="btn btn-light rounded-pill text-dark font-weight-bold btn-lg" onclick="window.location.href='../contenus1.html'">
    >>> 
  </button>
</div>

</body>
</html>