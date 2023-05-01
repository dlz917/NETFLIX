<?php
ini_set('memory_limit', '256M'); // set memory limit to 256MB
$t0 = time();

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
<<<<<<< Updated upstream
$query = "SELECT DISTINCT s.id_show, s.title, c.cast, d.director, g.genre
		FROM SHOW_NEW s
		INNER JOIN JOUER j ON s.id_show = j.id_show
		INNER JOIN CAST_NEW c ON j.id_cast = c.id_cast
		INNER JOIN PRODUIRE p ON s.id_show = p.id_show
		INNER JOIN DIRECTOR_NEW d ON p.id_direc = d.id_direc
		INNER JOIN ETRE e ON s.id_show = e.id_show
		INNER JOIN GENRE_NEW g ON e.id_genre = g.id_genre;";
=======
$query = "SELECT show_new.*, GROUP_CONCAT(DISTINCT jouer.id_cast SEPARATOR ',') as cast_ids, GROUP_CONCAT(DISTINCT produire.id_direc SEPARATOR ',') as director_ids,GROUP_CONCAT(DISTINCT etre.id_genre SEPARATOR ',') as genre_ids 
FROM show_new 
LEFT JOIN jouer ON jouer.id_show = show_new.id_show 
LEFT JOIN produire ON produire.id_show = show_new.id_show 
LEFT JOIN etre ON etre.id_show = show_new.id_show 
LEFT JOIN director_new on director_new.id_direc = produire.id_direc 
LEFT JOIN cast_new on cast_new.id_cast = jouer.id_cast 
LEFT JOIN genre_new on genre_new.id_genre = etre.id_genre";


if(isset($_SESSION['utilisateur']['type']) && !empty($_SESSION['utilisateur']['type'])) {
    $query .= " AND show_new.type = '$type' ";
}

if(is_array($genre) && !empty($genre) && $genre[0] != 'Genre') {
    $quotedArray = array_map(function($value) {
        return '"' . $value . '"';
    }, $genre);
    $string = '(' . implode(',', $quotedArray) . ')';
    $query .= " AND genre_new.genre IN $string";
}

if(is_array($cast) && !empty($cast) && $cast[0] != 'Acteur') {
    $quotedArray = array_map(function($value) {
        return '"' . $value . '"';
    }, $cast);
    $string = '(' . implode(',', $quotedArray) . ')';
    $query .= " AND cast_new.cast IN $string";
}
if(is_array($director) && !empty($director) && $director[0] != 'Réalisateur') {
	$quotedArray = array_map(function($value) {
		return '"' . $value . '"';
	}, $director);
	$string = '(' . implode(',', $quotedArray) . ')';	
    $query .= " AND director_new.director IN $string";
}

$query .= " GROUP BY show_new.id_show ORDER BY RAND() LIMIT 10";

$user = $_SESSION['utilisateur']['id'];
$filename = "query.txt";
file_put_contents($filename, $query);

$command = "C:\Users\joans\AppData\Local\Programs\Python\Python37-32\python.exe script_recom.py 2>&1 $user";

$output = shell_exec($command);

$filename = "output.txt";
file_put_contents($filename, $output);;
$decoded_json = json_decode($output);

$films = array_map(function($value) {
    return '"' . $value . '"';
}, $decoded_json);

$string = implode(',', $films);
>>>>>>> Stashed changes

$query= str_replace("ORDER BY RAND() LIMIT 10", "", $query);
$query=str_replace("GROUP_CONCAT(DISTINCT produire.id_direc SEPARATOR ',') as director_ids", "director_new.director", $query);

<<<<<<< Updated upstream
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
=======
$order_by = " ORDER BY ";
foreach ($decoded_json as $id) {
    $order_by .= "show_new.id_show = '$id' DESC, ";
}


$order_by = rtrim($order_by, ", ");
$query .= "$order_by LIMIT 30;";
echo $query;
>>>>>>> Stashed changes

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

	<div class="d-flex flex-column justify-content-center align-items-center" style="height: 50vh; margin-bottom: 50px;">
    <?php 
        $filmsDejaAffiches = array(); // tableau pour stocker les films déjà affichés
        $filmsAvecGenres = array(); // tableau pour stocker les films avec leurs genres respectifs
        foreach ($result as $row) { 
            $film = $row['title'];
    ?>
            <p>
                <a href="description.php?id=<?php echo $row['id_show']; ?>" class="small" style="color: white; cursor: pointer;">
                    <strong><?php echo $film; ?></strong>, <?php echo $row['director']; ?>
                </a>
            </p>
    <?php 

		}
    ?>
	</div>

	<div class="fixed-bottom text-right mr-3 mb-3">
  		<button type="button" class="btn btn-light rounded-pill text-dark font-weight-bold btn-lg" onclick="refreshPage()">
  		  Refresh
  		</button>
	</div>
</body>
</html>