  <!DOCTYPE html>
<html>
	<head>
		<title>Création Compte </title>
		<link rel="stylesheet" href="./css/bootstrap.css" type="text/css" media="screen" />
		<meta charset="UTF-8">
	</head>
	<body>
		<header>
			<div class="logo">
				<img src="images/logo.png" alt="Logo">
			</div>
		</header>
		<form action="enregistrementCreerCompte.php" method="post" autocomplete="off">
			<div class='connexion'>
			<p>
				<input type="text" name="id" placeholder="Identifiant" value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>">
				</p><p>
					<input type="password" name="mdp1" placeholder="Mot de passe" value=""/>
				</p>
				<p>
					<input type="password" name="mdp2" placeholder="Confirmer mot de passe" value=""/>
				</p>
				<p>
					<input type="submit" value="S'inscrire">
					<div style="display:flex; justify-content:center;">
						<hr style="width:25%;">
					</div>
				</p>
				<p>
				

		
				
				</p>
			</div>
		</form>

	</body>
</html>