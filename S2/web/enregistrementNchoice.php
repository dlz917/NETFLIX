<!DOCTYPE html>
<html>
   <head>
      <title> Enregistrement</title>
      <link rel="stylesheet" href="./css/bootstrap.css" type="text/css"media="screen" />
      <meta charset="UFT-8">
        <?php
		session_start();
		
		function connecter($email, $password) {
			require('bd.php');
			$bdd = getBD();
	
			if (isset($_POST['mail']) && !empty($_POST['mail']) && isset($_POST['mdp']) && !empty($_POST['mdp'])) {
				$req = $bdd->prepare('SELECT * FROM Utilisateur WHERE mail = :email ');
				$req->bindParam(':email', $email);
				$req->execute(array('email' => $email));	
				$utilisateur = $req->fetch();

				$mdp = md5($_POST['mdp']);
				if ($utilisateur && $mdp == $utilisateur['mdp']) {
					$_SESSION['utilisateur'] = array(
						'id' => $utilisateur['id_us'],
						'mail' => $email
					);
					header('Location: index.php');
					exit();
				} else {
					header('Location: connexion.php?mail='.$_POST["mail"]);
					exit();
				}
			} else {
				header('Location: connexion.php?mail='.$_POST["mail"]);
				exit();
			}
		}

		
		if (isset($_POST['mail']) && empty($_POST['mail']) || isset($_POST['mdp']) && empty($_POST['mdp'])){
		 
			// si il manque des données retourne sur page nouveau 
			echo "<meta http-equiv=\"refresh\" content=\"0; url=connexion.php?mail=".$_POST['mail']."\">";
			} 
		else {
		// tout complet appel fonction connecter
			$email = $_POST['mail'];
			$mdp=$_POST['mdp'];
			connecter($email, $mdp);
		
		}
        ?>
        </head>
        <body>
    </body>
    
</html>


	
