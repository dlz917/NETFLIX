<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>Index</title>
		<link href="css/bootstrap.css" rel="stylesheet">
	</head>
	<body>
		<header>
			<a href="index.php"><div class="logo">
				<img src="images/logo.png" alt="Logo">
			</div></a>
			<span style="color:white; position:center;">Bienvenue sur notre site <?php echo $_SESSION['utilisateur']['mail']; ?> !</span>
			<a href="deconnexion.php" style="color:white; position:absolute; top:0; right:0; padding:20px;">Déconnexion</a>
		</header>

		<button class="btn1" onclick="window.location.href='1ecran/1ecran.php';">Regarder ensemble sur un seul écran</button>
		<button class="btn2" onclick="window.location.href='creerSalle/creerSalle.php';">Créer une salle en ligne</button>
		<button class="btn2" onclick="window.location.href='rejoindreSalle/codeForm.php';">Rejoindre une salle en ligne</button>
		<button class="btn2" onclick="window.location.href='historique.php';">Historique</button>

	</body>
</html>
