   <!DOCTYPE html>
<html>
	<head>
		<title>Connexion </title>
		<link rel="stylesheet" href="./css/bootstrap.css" type="text/css" media="screen" />
		<meta charset="UTF-8">
	</head>
	<body>
		<header>
			<div class="logo">
				<img src="images/logo.png" alt="Logo">
			</div>
		</header>
		<form action="enregistrementNchoice.php" method="post" autocomplete="off">
			<div class='connexion'>
			<p>
				<input type="email" name="mail" placeholder="Mail" value="<?php echo isset($_GET['mail']) ? $_GET['mail'] : '' ?>">
				</p><p>
					<input type="password" name="mdp" placeholder="Mot de passe" value=""/>
				</p>
				<p>
					<input type="submit" value="Connexion">
					<div style="display:flex; justify-content:center;">
						<hr style="width:25%;">
					</div>
				</p>
				<p>
				
				<hr class="bg-white text-white"style="height: 2px; width: 55%">


				

		
				
				</p>
			</div>
		</form>
		<div class='creer'>
		<a href="creerCompte.php">
	<button>Créer un compte </button>
	</a> 
	</div>

      </form>
	</body>
</html>

			
			
	
			
			
