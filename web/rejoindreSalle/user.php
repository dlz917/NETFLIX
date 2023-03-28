<?php
session_start();
// Connexion à la base de données MySQL
require('../bd.php');
$bdd = getBD();

// Récupération des données pour le menu "Genre 1"
$sql = "SELECT genre FROM genre_new";
$stmt = $bdd->query($sql);
$options_genre = '<option>Pas de préférence</option>';
while ($row = $stmt->fetch()) {
    $options_genre .= '<option>' . htmlspecialchars($row['genre']) . '</option>';
}

// Récupération des données pour le menu "Cast"
$sql = "SELECT cast FROM cast_new";
$stmt = $bdd->query($sql);
$options_cast = '<option>Pas de préférence</option>';
while ($row = $stmt->fetch()) {
    $options_cast .= '<option>' . htmlspecialchars($row['cast']) . '</option>';
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
	<a href="../index.html"><div class="logo">
		<img src="../images/logo.png" alt="Logo">
		</div></a>
	<a href="../deconnexion.php" style="color:white; position:absolute; top:0; right:0; padding:20px;">Déconnexion</a>
</header>

<p class="prem">
    Remplissez vos critères :
</p>

<div class="container adduser">
<form action="../1ecran/enregistrementChoix1ecran.php" method="post">
    <div class="row">
      <div class="col-md-4 text-start">
        <img src="../images/user2.png" alt="IMG" title="User2" width="25%">
      </div>
          <div class="col-md-2">
            <select class="form-control w-100 me-2 rounded-0 custom-select text-dark font-weight-bold" name="genre[]">
              <option>Genre</option>
              <?php echo $options_genre; ?>
            </select>
          </div>
          <div class="col-md-2">
            <select class="form-control w-100 me-2 rounded-0 custom-select text-dark font-weight-bold" name="cast[]">
              <option>Acteur</option>
              <?php echo $options_cast; ?>
            </select>
          </div>
          <div class="col-md-2">
            <select class="form-control w-100 me-2 rounded-0 custom-select text-dark font-weight-bold" name="director[]">
              <option>Réalisateur</option>
              <?php echo $options_director; ?>
            </select>
          </div>
          <div class="fixed-bottom text-right mr-3 mb-3">
              <button type="submit" class="btn btn-light rounded-pill text-dark font-weight-bold btn-lg">>>></button>
          </div>
          </form>
    </div>
</div>
</body>
</html>