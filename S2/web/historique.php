<?php
// ouvre session 
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
	<link rel="stylesheet" href="./css/bootstrap.css">
		<title>Historique</title>
		
	</head>
	<body>
	<header>
		<a href="index.php"><div class="logo">
			<img src="images/logo.png" alt="Logo">
			</div></a>
		<a href="deconnexion.php" style="color:white; position:absolute; top:0; right:0; padding:20px;">Déconnexion</a>
	</header>
	
		<main>
		<h2 class="titre"> L'HISTORIQUE:</h2>
		
		<div class="d-flex justify-content-center align-items-center table-container">
		
	
			<?php
		
// Inclure le fichier de connexion à la base de données
include 'bd.php';
$bdd = getBD();

// Vérifier si l'utilisateur est connecté
if(isset($_SESSION['utilisateur'])){
    // Récupérer l'identifiant de l'utilisateur connecté
    $id_us = $_SESSION['utilisateur']['id'];

    // Préparer la requête SQL
    $rep = $bdd->prepare("SELECT show_new.title, genre_new.genre, regarder.date
                          FROM show_new
                          JOIN etre ON show_new.id_show = etre.id_show
                          JOIN genre_new ON etre.id_genre = genre_new.id_genre
                          JOIN regarder ON show_new.id_show = regarder.id_show
                          WHERE regarder.id_us = :id_us");
    $rep->execute(array(':id_us' => $id_us));

    // Vérifier si la requête retourne des résultats
    if ($rep->rowCount() > 0) {
        // Afficher les résultats dans un tableau
        echo '<table>';
        echo '<tr><th>Titre </th><th>Genre </th><th>Date </th></tr>';
        while($row = $rep->fetch()){
            echo '<tr>';
            echo '<td>' . $row['title'] . '&nbsp;</td>';
            echo '<td>' . $row['genre'] . '&nbsp;</td>';
            echo '<td>' . $row['date'] . '&nbsp;</td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
   
$message = "L'historique est vide";
echo "<p style='font-family: Arial, sans-serif; font-size: 18px; color: #FFFFF;'>{$message}</p>";



    }

    $rep->closeCursor();
} else {
    echo '<p> <em>Vous devez être connecté pour accéder à l\'historique de vos films </em></p>';
}

			?>
			</div>
		</main>
		<style>
  .table-container {
    color:white;
    height: 90%;
    width: 50%;
    margin-left: 30%;
 transform: scale(1.5);
 
  }
  button {
  position: absolute;
  bottom: 0;
  right: 0;
}

</style>