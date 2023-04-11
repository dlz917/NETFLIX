<?php
session_start();
// Connexion à la base de données MySQL
require('../bd.php');
$bdd = getBD();

// Récupération des données pour le menu "Genre 1"
$sql = "SELECT genre FROM genre_new";
$stmt = $bdd->query($sql);
$options_genre = '';
while ($row = $stmt->fetch()) {
    $options_genre .= '<option>' . htmlspecialchars($row['genre']) . '</option>';
}

// Récupération des données pour le menu "Genre 2"
$sql = "SELECT cast FROM cast_new";
$stmt = $bdd->query($sql);
$options_cast = '';
while ($row = $stmt->fetch()) {
    $options_cast .= '<option>' . htmlspecialchars($row['cast']) . '</option>';
}

// Récupération des données pour le menu "Director"
$sql = "SELECT director FROM director_new";
$stmt = $bdd->query($sql);
$options_director = '';
while ($row = $stmt->fetch()) {
    $options_director .= '<option>' . htmlspecialchars($row['director']) . '</option>';
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Un seul écran</title>
    <link href="../css/bootstrap.css" rel="stylesheet">
</head>
<body>
	<header>
		<a href="../index.php"><div class="logo">
			<img src="../images/logo.png" alt="Logo">
			</div></a>
		<a href="../deconnexion.php" style="color:white; position:absolute; top:0; right:0; padding:20px;">Déconnexion</a>
	</header>

    <p class="prem">
        Selectionner vos critères :
    </p>

    <div class="container">
            <form action="enregistrementChoix1ecran.php?ordre=1" method="POST">
            <div class="row">
                <div class="col-md-4 text-start">
                    <img src="../images/images.png" alt="IMG" title="User1" width="25%">
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-2">
                            <select class="form-control w-100 me-2 rounded-0 custom-select text-dark font-weight-bold" name="type">
                                <option>Type</option>
                                <option>Movie</option>
                                <option>TV Show</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select id="menu-1" class="mb-4 form-control w-100 me-2 rounded-0 custom-select text-dark font-weight-bold" name="genre[]">
                                <option>Genre</option>
                                <?php echo $options_genre; ?>
                            </select>
                            <button id="btn-1" type="button" class="add-button btn btn-light rounded-circle">
                                <span class="font-weight-bold">+</span>
                            </button>
                        </div>
                        <div class="col-md-2">
                            <select id="menu-2" class="mb-4 form-control w-100 me-2 rounded-0 custom-select text-dark font-weight-bold" name="cast[]">
                                <option>Acteur</option>
                                <?php echo $options_cast; ?>
                            </select>
                            <button id="btn-2" type="button" class="add-button btn btn-light rounded-circle">
                                <span class="font-weight-bold">+</span>
                            </button>
                        </div>
                        <div class="col-md-2">
                            <select id="menu-3" class="mb-4 form-control w-100 me-2 rounded-0 custom-select text-dark font-weight-bold" name="director[]">
                                <option>Réalisateur</option>
                                <?php echo $options_director; ?>
                            </select>
                            <button id="btn-3" type="button" class="add-button btn btn-light rounded-circle">
                                <span class="font-weight-bold">+</span>
                            </button>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
    <div class="fixed-bottom text-right mr-3 mb-3">
      <button type="submit" class="btn btn-light rounded-pill text-dark font-weight-bold btn-lg">>>></button>
    </div>
    </form>

    <script>
    // Sélectionne le bouton et le menu déroulant
    const btn1 = document.querySelector('#btn-1');
    const menu1 = document.querySelector('#menu-1');
    const btn2 = document.querySelector('#btn-2');
    const menu2 = document.querySelector('#menu-2');
    const btn3 = document.querySelector('#btn-3');
    const menu3 = document.querySelector('#menu-3');

    // Sélectionne la div parente
    const parentDiv = menu1.parentNode;
    parentDiv.style.marginBottom = '10px';

    // Ajoute un compteur pour suivre le nombre de menus créés
    let counter = 1;

    // Ajoute un écouteur d'événement sur chaque bouton
    btn1.addEventListener('click', () => {
        // Clone le menu déroulant
        const newMenu = menu1.cloneNode(true);

        // Ajoute le menu cloné à la fin de la div parente
        parentDiv.appendChild(newMenu);

        // Déplace le bouton "+" en dessous du nouveau menu déroulant
        newMenu.parentNode.insertAdjacentElement('beforeend', btn1);

        newMenu.style.marginBottom = '10px';

        // Met à jour le texte du bouton avec le compteur
        counter++;
        btn1.querySelector('span').textContent = '+';
        });

    btn2.addEventListener('click', () => {
        // Sélectionne la div parente
        const parentDiv = menu2.parentNode;
        parentDiv.style.marginBottom = '10px';

        // Clone le menu déroulant
        const newMenu = menu2.cloneNode(true);

        // Ajoute le menu cloné à la fin de la div parente
        parentDiv.appendChild(newMenu);

        // Déplace le bouton "+" en dessous du nouveau menu déroulant
        newMenu.parentNode.insertAdjacentElement('beforeend', btn2);

        newMenu.style.marginBottom = '10px';

        // Met à jour le texte du bouton avec le compteur
        counter++;
        btn2.querySelector('span').textContent = '+';
        });

    btn3.addEventListener('click', () => {
        // Sélectionne la div parente
        const parentDiv = menu3.parentNode;
        parentDiv.style.marginBottom = '10px';

        // Clone le menu déroulant
        const newMenu = menu3.cloneNode(true);

        // Ajoute le menu cloné à la fin de la div parente
        parentDiv.appendChild(newMenu);

        // Déplace le bouton "+" en dessous du nouveau menu déroulant
        newMenu.parentNode.insertAdjacentElement('beforeend', btn3);

        newMenu.style.marginBottom = '10px';

        // Met à jour le texte du bouton avec le compteur
        counter++;
        btn3.querySelector('span').textContent = '+';
        });

    </script>

    </body>
</html>