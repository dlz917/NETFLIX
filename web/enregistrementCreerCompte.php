<!DOCTYPE html>
<html>
   <head>
      <title>Enregistrement Compte</title>
      <link rel="stylesheet" href="./css/bootstrap.css" type="text/css"media="screen" />
      <meta charset="UFT-8">
          <?php
            if (isset($_POST['id']) && empty($_POST['id']) || isset($_POST['mdp1']) && empty($_POST['mdp1'])|| isset($_POST['mdp2']) && empty($_POST['mdp2'])|| ($_POST['mdp1'] != $_POST['mdp2'])) 
		 {
		// si il manque des données retourne sur page nouveau 
		echo "<meta http-equiv=\"refresh\" content=\"0; url=creerCompte.php?id=".$_POST['id']."\">";

	} 
	else {
	// tout complet appel fonction enregistrer et retour sur index
		
		echo'<meta http-equiv="refresh" content="0; url=index.html">';
		
	}
  
        ?>
        </head>
        <body>
    </body>
    
</html>