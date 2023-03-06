<!DOCTYPE html>
<html>
   <head>
      <title> Enregistrement</title>
      <link rel="stylesheet" href="./css/bootstrap.css" type="text/css"media="screen" />
      <meta charset="UFT-8">
          <?php
            if (isset($_POST['id']) && empty($_POST['id']) || isset($_POST['mdp']) && empty($_POST['mdp'])) 
		 {
		// si il manque des données retourne sur page nouveau 
		echo "<meta http-equiv=\"refresh\" content=\"0; url=connexion.php?id=".$_POST['id']."\">";
		
		
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

	
