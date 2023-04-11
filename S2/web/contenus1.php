<?php
session_start();

// Vérification que l'utilisateur a sélectionné au moins une catégorie (en l'occurence le type car le plus simple)
if(!isset($_SESSION['type']) || empty($_SESSION['type'])) {
    header("Location: enregistrementChoix1ecran.php");
}

// Récupération des choix de l'utilisateur
$type = $_SESSION['type'];
$genre = $_SESSION['genre'] ? $_SESSION['genre'] : ""; //car possibilité que ce soit null
$cast = isset($_SESSION['cast']) ? $_SESSION['cast'] : "";
$director = isset($_SESSION['director']) ? $_SESSION['director'] : "";

// Connexion à la base de données MySQL
require('bd.php');
$bdd = getBD();

// Requête pour récupérer les contenus correspondants aux choix de l'utilisateur
$query = "SELECT DISTINCT s.title, s.duration, s.description, s.country, s.year, c.cast, d.director, g.genre
          FROM SHOW_NEW s
          LEFT JOIN JOUER j ON s.id_show = j.id_show
          LEFT JOIN CAST_NEW c ON j.id_cast = c.id_cast
          LEFT JOIN PRODUIRE p ON s.id_show = p.id_show
          LEFT JOIN DIRECTOR_NEW d ON p.id_direct = d.id_direct
          LEFT JOIN ETRE e ON s.id_show = e.id_show
          LEFT JOIN GENRE_NEW g ON e.id_genre = g.id_genre
          WHERE s.type = :type";

$params = [':type' => $type];

if(!empty($genre)) {
    $query .= " AND g.genre = :genre";
    $params[':genre'] = $genre;
}

if(!empty($cast)) {
    $query .= " AND c.cast = :cast";
    $params[':cast'] = $cast;
}

if(!empty($director)) {
    $query .= " AND d.director = :director";
    $params[':director'] = $director;
}

$stmt = $bdd->prepare($query);
$stmt->execute($params);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Liste de contenus</title>
	<meta name="generator" content="BBEdit 14.6" />
	<link rel="stylesheet" href="css/bootstrap.css">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
	<header>
		<a href="index.html"><div class="logo">
			<img src="images/logo.png" alt="Logo">
			</div></a>
		<a href="deconnexion.php" style="color:white; position:absolute; top:0; right:0; padding:20px;">Déconnexion</a>
	</header>
	<div class="container">
	<h1 class="titre">
    Cliquez sur le contenu pour voir la description :</h1>

	<div class="d-flex flex-column justify-content-center align-items-center" style="height: 50vh; margin-bottom: 50px;">
			<?php foreach ($result as $row) { ?>
			<p>
				<a href="description.php?id=<?php echo $row['id_show']; ?>" class="small" style="color: white; cursor: pointer;">
					<?php echo $row['title']; ?>, <?php echo $row['director']; ?>, <strong><?php echo $row['genre']; ?></strong>
				</a>
			<?php } ?>
		</div>
	</div>
	<div class="fixed-bottom text-right mr-3 mb-3">
  		<button type="button" class="btn btn-light rounded-pill text-dark font-weight-bold btn-lg" onclick="refreshPage()">
  		  Refresh
  		</button>
	</div>
	<script>
	function refreshPage() { 
   		window.location.href = "contenus_refresh.php"; //à changer pour qu'on puisse refresh automatiquement
 	}
	</script>
</body>
</html>
