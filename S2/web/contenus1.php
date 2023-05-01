<?php
ini_set('memory_limit', '256M'); // set memory limit to 256MB

session_start();

// Récupération des choix de l'utilisateur
$type = isset( $_SESSION['utilisateur']['type']) ? $_SESSION['utilisateur']['type'] : [];
echo $type;
$genre = isset($_SESSION['utilisateur']['genre']) ? $_SESSION['utilisateur']['genre'] : [];
print_r($genre);
$cast = isset($_SESSION['utilisateur']['cast']) ? $_SESSION['utilisateur']['cast'] : [];
print_r($cast);
$director = isset($_SESSION['utilisateur']['director']) ? $_SESSION['utilisateur']['director'] : [];
print_r($director);

// Connexion à la base de données MySQL
require('bd.php');
$bdd = getBD();

// Requête pour récupérer les contenus correspondants aux choix de l'utilisateur
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

$query= str_replace("ORDER BY RAND() LIMIT 10", "", $query);
$query=str_replace("GROUP_CONCAT(DISTINCT produire.id_direc SEPARATOR ',') as director_ids", "director_new.director", $query);

$order_by = " ORDER BY ";
foreach ($decoded_json as $id) {
    $order_by .= "show_new.id_show = '$id' DESC, ";
}


$order_by = rtrim($order_by, ", ");
$query .= "$order_by LIMIT 30;";


$stmt = $bdd->prepare($query);
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