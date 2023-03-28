<?php
// Vérifier si une erreur a été signalée dans l'URL
if (isset($_GET['error']) && $_GET['error'] == 1) {
    // Afficher une alerte
    echo '<script>alert("Le code entré n\'est pas valide. Veuillez réessayer.")</script>';
}
?>
<?php
session_start();
// Vérifier si une erreur a été signalée dans l'URL
if (isset($_GET['error']) && $_GET['error'] == 1) {
    // Afficher une alerte
    echo '<script>alert("Le code entré n\'est pas valide. Veuillez réessayer.")</script>';
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Nchoice | Saisir son code </title>
		<link rel="stylesheet" href="../css/bootstrap.css" type="text/css" media="screen"/>
		<meta charset="UTF-8">>
	</head>
	<body>
	<header>
		<a href="index.html"><div class="logo">
			<img src="images/logo.png" alt="Logo">
			</div></a>
		<a href="deconnexion.php" style="color:white; position:absolute; top:0; right:0; padding:20px;">Déconnexion</a>
	</header>
	<form action="./verifCode.php" method="post" autocomplete="off">
		<div class="codeForm">
			<label for="Code">Rentrez votre code de salle :</label>
			<input type="text" class="form-control" id="Code" name="Code">
		</div>
		<div class="fixed-bottom text-right mr-3 mb-3">
			<button type="submit" class="btn btn-light rounded-pill text-dark font-weight-bold btn-lg">
			>>>
			</button>
		</div>
	</form>
	</body>
</html>