<!-- envoyer_message.php-->
<?php

session_start();
require('../bd.php');
$bdd = getBD();

// verifie champs remplie 
if(isset($_POST['valider'])){
	if(!empty($_POST['pseudo'])and !empty($_POST['texte'])){
	// entre dans variable sous bonne forme
			$pseudo=htmlspecialchars($_POST['pseudo']);
			 $_SESSION['pseudo'] = $pseudo;
			$texte=nl2br(htmlspecialchars($_POST['texte']));
		 	$id_us = $_SESSION['utilisateur']['id'];
			$code = $_SESSION['code'];
echo $id_us;
echo $pseudo;
echo $code;
echo $texte;
    		// insère le message dans la table `message` avec la date et l'heure actuelles
   			 $query = $bdd->prepare('INSERT INTO message SET texte=:texte, date=NOW(), heure=NOW(),pseudo=:pseudo');
   			 $query->execute(['texte' => $texte,
   			 					'pseudo'=>$pseudo]);

    		// récupère l'ID du message qui vient d'être inséré
   			 $id_texte = $bdd->lastInsertId();
   			 echo $id_texte;
    		// insérer le message dans la table `deposer`
   		 	$query = $bdd->prepare('INSERT INTO deposer SET code=:code, id_us=:id_us, id_texte=:id_texte');
$query->execute([
    ':id_us' => $id_us,
    ':id_texte' => $id_texte,
    ':code' => $code
]);
			header("Location:".$_SERVER["HTTP_REFERER"]."?pseudo=".$pseudo);


    		//echo'<meta http-equiv="refresh" content="0; url= creerSalle.php">';
		//echo'<meta http-equiv="refresh" content="0; url= chat.php">';
		
	} else{
			echo "veuillez complèter tout les champs";
			}
}


?>
