<?php
// cette page sert a faire la requete pour afficher 
// les messages dans le chat d'une salle 

session_start();

require('../bd.php');
$bdd = getBD();
$code = $_SESSION['code'];// session créer dans CréerSalle
$pseudo = isset($_POST['pseudo']) ? $_POST['pseudo'] : '';

//requete pour récuperer les messages selon la salle
$recupMessage = $bdd->prepare('SELECT message.texte, utilisateur.id_us, message.pseudo FROM message, deposer, utilisateur
                               WHERE message.id_texte=deposer.id_texte
                               AND deposer.id_us=utilisateur.id_us
                               AND deposer.code=:code
                               ORDER BY message.id_texte DESC');

$recupMessage->bindParam(':code', $code);
$recupMessage->execute();

?>

<div id="messages">
  <?php
  // Boucle pour afficher les messages
  while($texte = $recupMessage->fetch()) {
    echo '<div class="message">';
    $color = getColorForPseudo($texte['pseudo']);
    echo '<p style="color: '.$color.'; display: inline-block;">' . $texte['pseudo'] . ':</p>';
    echo '<p style="display: inline-block;" class="texte">' . $texte['texte'] . '</p>';
    echo '</div>';
  }
  
// fonction qui associe une couleur à un pseudo 
  function getColorForPseudo($pseudo) {
    $hash = md5($pseudo); // Génère un hash unique pour le pseudo
    $r = hexdec(substr($hash, 0, 2)); // Composante rouge (0-255)
    $g = hexdec(substr($hash, 2, 2)); // Composante verte (0-255)
    $b = hexdec(substr($hash, 4, 2)); // Composante bleue (0-255)
    return "rgb($r, $g, $b)";
  }
  ?>
  
<!-- mise en page du texte-->  
  <style>
    .pseudo {
      display: inline-block;
      font-weight: bold;
    }

    .texte {
      display: inline-block;
    }

    p {
      margin: 1%;
      padding: 0.1%;
      font-size: 14px;
    }
  </style>
  
</div>