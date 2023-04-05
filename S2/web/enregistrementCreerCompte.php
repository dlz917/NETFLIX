<!DOCTYPE html>
<html>
   <head>
      <title>Enregistrement Compte</title>
      <link rel="stylesheet" href="./css/bootstrap.css" type="text/css"media="screen" />
      <meta charset="UFT-8">
          <?php
			function enregistrer($email,$motdepasse) {
			require('bd.php');
			$bdd = getBD();
			$req = $bdd->prepare('INSERT INTO Utilisateur(mail,mdp) VALUES (:email, :motdepasse)');
			$req->bindParam(':email', $email);
			$req->bindParam(':motdepasse', $motdepasse);
			$req->execute();
}
            if (isset($_POST['mdp1']) && empty($_POST['mdp1'])|| isset($_POST['mdp2']) && empty($_POST['mdp2'])|| ($_POST['mdp1'] != $_POST['mdp2'])) 
		 {
		// si il manque des données retourne sur page nouveau 
		echo "<meta http-equiv=\"refresh\" content=\"0; url=creerCompte.php\">";


	} 
	else {
	// tout complet appel fonction enregistrer et retour sur index
		$email = $_POST['mail'];
		$motdepasse = MD5($_POST['mdp1']); 
		enregistrer($email, $motdepasse);
		echo'<meta http-equiv="refresh" content="0; url=connexion.php">';
		
	}
  
        ?>
        </head>
        <body>
    </body>
    
</html>