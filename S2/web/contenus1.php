<?php
ini_set('memory_limit', '256M'); // set memory limit to 256MB

session_start();

// Vérification que l'utilisateur a sélectionné au moins une catégorie (en l'occurence le type car le plus simple)
//if(!isset($_SESSION['utilisateur']['type']) || empty($_SESSION['utilisateur']['type'])) {
  //  header("Location: " . $_SERVER["HTTP_REFERER"]);
//}

// Récupération des choix de l'utilisateur
$type = $_SESSION['utilisateur']['type'];
$genre = isset($_SESSION['utilisateur']['genre']) ? $_SESSION['utilisateur']['genre'] : [];
$cast = isset($_SESSION['utilisateur']['cast']) ? $_SESSION['utilisateur']['cast'] : [];
$director = isset($_SESSION['utilisateur']['director']) ? $_SESSION['utilisateur']['director'] : [];

// Connexion à la base de données MySQL
require('bd.php');
$bdd = getBD();

// Requête pour récupérer les contenus correspondants aux choix de l'utilisateur
$query = "SELECT DISTINCT s.id_show, s.title, c.cast, d.director, g.genre
		FROM SHOW_NEW s
		INNER JOIN JOUER j ON s.id_show = j.id_show
		INNER JOIN CAST_NEW c ON j.id_cast = c.id_cast
		INNER JOIN PRODUIRE p ON s.id_show = p.id_show
		INNER JOIN DIRECTOR_NEW d ON p.id_direc = d.id_direc
		INNER JOIN ETRE e ON s.id_show = e.id_show
		INNER JOIN GENRE_NEW g ON e.id_genre = g.id_genre;";


if(isset($_SESSION['utilisateur']['type']) && !empty($_SESSION['utilisateur']['type'])) {
    $query .= " WHERE s.type = $type";
}

if(is_array($genre) && !empty($genre) && $genre != 'Genre') {
    $genreStr = implode(',', $genre);
    $query .= " AND g.genre IN ($genreStr)";
}

if(is_array($cast) && !empty($cast) && $cast != 'Acteur') {
    $castStr = implode(',', $cast);
    $query .= " AND c.cast IN ($castStr)";
}
if(is_array($director) && !empty($director) && $director != 'Réalisateur') {
    $directorStr = implode(',', $director);
    $query .= " AND d.director IN ($directorStr)";
}

$query .= " GROUP BY s.title ORDER BY RAND() LIMIT 10";

$stmt = $bdd->prepare($query);
echo $query;
$stmt->execute(array());
$result = $stmt->fetchAll();
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
		<a href="index.php"><div class="logo">
			<img src="images/logo.png" alt="Logo">
			</div></a>
		<a href="deconnexion.php" style="color:white; position:absolute; top:0; right:0; padding:20px;">Déconnexion</a>
	</header>
	<div class="container">
	<h1 class="prem">
    Cliquez sur le contenu pour voir la description :</h1>

	<div class="d-flex flex-column justify-content-center align-items-center" style="height: 50vh; margin-bottom: 50px;">
    <?php 
        $filmsDejaAffiches = array(); // tableau pour stocker les films déjà affichés
        $filmsAvecGenres = array(); // tableau pour stocker les films avec leurs genres respectifs
        foreach ($result as $row) { 
            $film = $row['title'];
            if(!in_array($film, $filmsDejaAffiches)) { // vérifie si le film a déjà été affiché
                $filmsDejaAffiches[] = $film; // ajoute le film au tableau des films déjà affichés
                $filmsAvecGenres[$film] = array($row['genre']); // ajoute le film au tableau des films avec leurs genres respectifs
    ?>
            <p>
                <a href="description.php?id=<?php echo $row['id_show']; ?>" class="small" style="color: white; cursor: pointer;">
                    <strong><?php echo $film; ?></strong>, <?php echo $row['director']; ?>
                </a>
            </p>
    <?php 
            } // fin de la vérification si le film a déjà été affiché
            else { // si le film a déjà été affiché, affiche seulement son genre
                $filmsAvecGenres[$film][] = $row['genre'];
            }
        } // fin de la boucle foreach
    ?>
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