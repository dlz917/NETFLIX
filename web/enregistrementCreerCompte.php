<!DOCTYPE html>
<html>
   <head>
      <title>Enregistrement Compte</title>
      <link rel="stylesheet" href="./css/bootstrap.css" type="text/css"media="screen" />
      <meta charset="UFT-8">
          <?php
			function enregistrer($id_us,$email,$motdepasse) {
			require('bd.php');
			$bdd = getBD();
			$req = $bdd->prepare('INSERT INTO Utilisateur(id_us,mail,mdp) VALUES (:id_us, :email, :motdepasse)');
			$req->bindParam(':id_us', $id_us);
			$req->bindParam(':email', $email);
			$req->bindParam(':motdepasse', $motdepasse);
			$req->execute();
}
            if (isset($_POST['id']) && empty($_POST['id']) || isset($_POST['mdp1']) && empty($_POST['mdp1'])|| isset($_POST['mdp2']) && empty($_POST['mdp2'])|| ($_POST['mdp1'] != $_POST['mdp2'])) 
		 {
		// si il manque des données retourne sur page nouveau 
		echo "<meta http-equiv=\"refresh\" content=\"0; url=creerCompte.php?id=".$_POST['id']."\">";

	} 
	else {
	// tout complet appel fonction enregistrer et retour sur index
		$id_us = mt_rand(1000000,9999999);
		$email = $_POST['mail'];
		$motdepasse = password_hash($_POST['mdp1'], PASSWORD_DEFAULT); 
		enregistrer($id_us, $email, $motdepasse);
		echo'<meta http-equiv="refresh" content="0; url=index.html">';
		
	}
  
        ?>
        </head>
        <body>
    </body>
    
</html>