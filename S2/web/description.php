<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Description</title>
	<meta name="generator" content="BBEdit 14.6" />
	<link rel="stylesheet" href="css/bootstrap.css">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <header>
        <a href="index.php"><div class="logo">
            <img src="images/logo.png" alt="Logo">
            </div></a>
        <a href="deconnexion.php" style="color:white; position:absolute; top:0; right:0; padding:20px;">Déconnexion</a>
    </header>
    <?php
        // Connexion à la base de données
        require('bd.php');
        $bdd = getBD();
        // Vérification si l'identifiant du contenu est bien présent dans l'URL
        if (isset($_GET['id'])) {
            // Récupération de l'identifiant du contenu depuis l'URL
            $id_show = $_GET['id'];
        } else {
            // Si l'ID n'est pas passé dans l'URL, on redirige l'utilisateur vers la page contenus.php
            header('Location: contenus1.php');
            exit();
        }
// Requête pour récupérer les informations du contenu correspondant
            $query = "SELECT title, duration, description, country, year FROM SHOW_NEW WHERE id_show = :id_show";
            $stmt = $bdd->prepare($query);
            $stmt->execute([':id_show' => $id_show]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            // Affichage des informations du contenu
            echo "<h1>" . $result['title'] . "</h1>";
            echo "<p>Durée : " . $result['duration'] . "</p>";
            echo "<p>Synopsis : " . $result['description'] . "</p>";

            // Requête pour récupérer la distribution
            $query = "SELECT * FROM CAST_NEW WHERE id_cast IN (SELECT id_cast FROM JOUER WHERE id_show = :id_show)";
            $stmt = $bdd->prepare($query);
            $stmt->execute([':id_show' => $id_show]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Affichage de la distribution
            echo "<p>Distribution : ";
            foreach ($result as $row) {
                echo $row['cast'] . ", ";
            }
            echo "</p>";

            ?>
            
    <form action="enregistrementHistorique.php?ordre=1" method="POST">
    	<div class="fixed-bottom text-right mr-3 mb-3">
      		<button type="submit" name="id_show" class="btn btn-light rounded-pill text-dark font-weight-bold btn-lg" value="<?php echo $id_show; ?>">Valider mon choix</button>
    	</div>
    </form>
    </body>
</html>