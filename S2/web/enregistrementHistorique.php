<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Connexion à la base de données MySQL
require('bd.php');
$bdd = getBD();


var_dump($_POST);


    $id_show = $_POST['id_show'];
    $id_us = $_SESSION['utilisateur']['id'];
    $date = new DateTime(); //convertire date en objt DateTime
	$date_str = $date->format('Y-m-d');
    $code = isset($_SESSION['utilisateur']['code']) ? $_SESSION['utilisateur']['code'] : NULL;
    
    // Afficher les valeurs des variables
	var_dump($id_show);
	var_dump($id_us);
	var_dump($date);
	var_dump($code);
	
	try {
 	 	$stmt = $bdd->prepare('INSERT INTO regarder (date, id_show, id_us, code) VALUES (?,?,?,?)');
		$stmt->execute([$date_str, $id_show, $id_us, $code]);
    	echo "L'enregistrement a été ajouté avec succès !";
	} catch(PDOException $e) {
   		echo "Erreur lors de l'insertion : " . $e->getMessage();
}



    // Rediriger l'utilisateur vers la page de fin
   // header('Location: bye.html');
	//exit();
    
    
?>