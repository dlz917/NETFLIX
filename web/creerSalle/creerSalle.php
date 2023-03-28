<?php
session_start();
// Connexion à la base de données MySQL
require('../bd.php');
$bdd = getBD();

// Récupération des données pour le menu "Genre"
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

// Génère un code aléatoire unique de 4 chiffres
$code = strval(mt_rand(1000, 9999));

// Vérifie si le code existe déjà dans la table salle
$stmt = $bdd->prepare('SELECT code FROM salle WHERE code = :code');
$stmt->execute(array('code' => $code));

// Si le code existe déjà, en génère un nouveau jusqu'à ce qu'il soit unique
while ($stmt->fetch()) {
    $code = strval(mt_rand(1000, 9999));
    $stmt->execute(array('code' => $code));
}

// Insère le code, le nom d'utilisateur et la date actuelle dans la table salle
if(isset($_SESSION['utilisateur'])) {
    $id_us = $_SESSION['utilisateur']['id'];
} else {
    // rediriger l'utilisateur vers une page de connexion
    header('Location: connexion.php');
    exit();
}
$date = date('Y-m-d H:i:s');
$stmt = $bdd->prepare('INSERT INTO salle (code, date) VALUES (:code, :date)');
$stmt->execute(array('code' => $code, 'date' => $date));

$stmt = $bdd->prepare('INSERT INTO creer (id_us, code, date) VALUES (:id_us, :code, :date)');
$stmt->execute(array('id_us' => $id_us, 'code' => $code, 'date' => $date));

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
    <a href="../deconnexion.php" style="color:white; position:absolute; top:80px; right:0; padding:20px;">Déconnexion</a>
</header>

<p class="prem">
    Envoyer votre code salle aux utilisateurs souhaités puis remplisser vos critères :
</p>
<div class="container">
<form action="../1ecran/enregistrementChoix1ecran.php" method="post">
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
        </div>
        </form>
    </div>
</div>
</div>

<div class="fixed-top text-right mr-3 mb-3" style="margin-top: 30px; margin-right:50px;">
    <span style="color: white; font-weight: bold;">Votre code :</span>
    <div class="code-box bg-light d-inline-flex align-items-center justify-content-center">
        <span class="code-text font-weight-bold"><?php echo $code; ?></span>
    </div>
</div>

</body>
</html>