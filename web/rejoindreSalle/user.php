<?php
session_start();
// Connexion à la base de données MySQL
require('../bd.php');
$bdd = getBD();
$code = $_SESSION['code'];

// Récupération des données pour le menu "Genre 1"
$sql = "SELECT genre FROM genre_new";
$stmt = $bdd->query($sql);
$options_genre = '';
while ($row = $stmt->fetch()) {
    $options_genre .= '<option>' . htmlspecialchars($row['genre']) . '</option>';
}

// Récupération des données pour le menu "Cast"
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
    Remplissez vos critères :
</p>

<div class="container adduser">
<form action="../1ecran/enregistrementChoix1ecran.php" method="post">
    <div class="row">
      <div class="col-md-4 text-start">
        <img src="../images/user2.png" alt="IMG" title="User2" width="25%">
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
          <div class="fixed-bottom text-right mr-3 mb-3">
              <button type="submit" class="btn btn-light rounded-pill text-dark font-weight-bold btn-lg">>>></button>
          </div>
          </form>
    </div>
</div>

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

<?php
// Récupération des choix de genre de l'admin de la salle
$sql = "SELECT utilisateur.id_us, genre_new.genre
        FROM creer, utilisateur, faire, choix, avoirg, genre_new
        WHERE creer.code = :code
        AND creer.id_us = utilisateur.id_us
        AND utilisateur.id_us = faire.id_us
        AND faire.id_choix = choix.id_choix
        AND choix.id_choix = avoirg.id_choix
        AND avoirg.id_genre = genre_new.id_genre";
$stmt = $bdd->prepare($sql);
$stmt->execute(array('code' => $code));
$admin_choices_genre = $stmt->fetchAll();

// Récupération des choix de cast de l'admin de la salle
$sql = "SELECT utilisateur.id_us, cast_new.cast
        FROM creer, utilisateur, faire, choix, avoirc, cast_new
        WHERE creer.code = :code
        AND creer.id_us = utilisateur.id_us
        AND utilisateur.id_us = faire.id_us
        AND faire.id_choix = choix.id_choix
        AND choix.id_choix = avoirc.id_choix
        AND avoirc.id_cast = cast_new.id_cast";
$stmt = $bdd->prepare($sql);
$stmt->execute(array('code' => $code));
$admin_choices_cast = $stmt->fetchAll();

// Récupération des choix de director de l'admin de la salle
$sql = "SELECT utilisateur.id_us, director_new.director
        FROM creer, utilisateur, faire, choix, avoird, director_new
        WHERE creer.code = :code
        AND creer.id_us = utilisateur.id_us
        AND utilisateur.id_us = faire.id_us
        AND faire.id_choix = choix.id_choix
        AND choix.id_choix = avoird.id_choix
        AND avoird.id_direc = director_new.id_direc";
$stmt = $bdd->prepare($sql);
$stmt->execute(array('code' => $code));
$admin_choices_director = $stmt->fetchAll();

//Récupération de l'e-mail l'admin de la salle
$sql = "SELECT utilisateur.id_us, utilisateur.mail
        FROM creer, utilisateur
        WHERE creer.code = :code
        AND creer.id_us = utilisateur.id_us";
$stmt = $bdd->prepare($sql);
$stmt->execute(array('code' => $code));
$admin_email = $stmt->fetchAll();

if ($admin_choices_genre && $admin_choices_cast && $admin_choices_director) {
    // Affichage des choix de l'admin
    echo '<div class="container">';
    echo '<p class="prem">Choix de l\'administrateur de votre salle:</p>';
    foreach ($admin_email as $admin) {
        // Affichage de l'utilisateur et des choix
        echo '<div class="row mb-3"><div class="col-md-2"><img src="../images/images.png" alt="IMG" title="adminIMG" width="50%"></div>';
        echo '<div class="col-md-8"><div class="row"><div class="col-md-4"><p class="prem">Utilisateur: ' . $admin['id_us'] . ' - ' . $admin['mail'] . '</p></div>';
        foreach ($admin_choices_genre as $choice) {
            if ($choice['id_us'] == $admin['id_us']) {
                echo '<div class="col-md-4"><p class="prem">Genres: ' . $choice['genre'] . '</p></div>';
            }
        }
        echo '<div class="col-md-4"><p class="prem">Acteurs: ';
        foreach ($admin_choices_cast as $choice_cast) {
            if ($choice_cast['id_us'] == $admin['id_us']) {
                echo $choice_cast['cast'] . ', ';
            }
        }
        echo '</p></div><div class="col-md-4"><p class="prem">Réalisateurs: ';
        foreach ($admin_choices_director as $choice_director) {
            if ($choice_director['id_us'] == $admin['id_us']) {
                echo $choice_director['director'] . ', ';
            }
        }
        echo '</p></div></div></div></div>';
    }
    echo '</div>';
} else {
    echo 'Aucun choix de l\'administrateur de la salle n\'a été trouvé.';
}

// Récupération des choix de genre des utilisateurs connectés à la salle
$sql = "SELECT utilisateur.id_us, genre_new.genre
        FROM acceder, utilisateur, faire, choix, avoirg, genre_new
        WHERE acceder.code = :code
        AND acceder.id_us = utilisateur.id_us
        AND utilisateur.id_us = faire.id_us
        AND faire.id_choix = choix.id_choix
        AND choix.id_choix = avoirg.id_choix
        AND avoirg.id_genre = genre_new.id_genre";
$stmt = $bdd->prepare($sql);
$stmt->execute(array('code' => $code));
$users_choices_genre = $stmt->fetchAll();

// Récupération des choix de cast des utilisateurs connectés à la salle
$sql = "SELECT utilisateur.id_us, cast_new.cast
        FROM acceder, utilisateur, faire, choix, avoirc, cast_new
        WHERE acceder.code = :code
        AND acceder.id_us = utilisateur.id_us
        AND utilisateur.id_us = faire.id_us
        AND faire.id_choix = choix.id_choix
        AND choix.id_choix = avoirc.id_choix
        AND avoirc.id_cast = cast_new.id_cast";
$stmt = $bdd->prepare($sql);
$stmt->execute(array('code' => $code));
$users_choices_cast = $stmt->fetchAll();

// Récupération des choix de director des utilisateurs connectés à la salle
$sql = "SELECT utilisateur.id_us, director_new.director
        FROM acceder, utilisateur, faire, choix, avoird, director_new
        WHERE acceder.code = :code
        AND acceder.id_us = utilisateur.id_us
        AND utilisateur.id_us = faire.id_us
        AND faire.id_choix = choix.id_choix
        AND choix.id_choix = avoird.id_choix
        AND avoird.id_direc = director_new.id_direc";
$stmt = $bdd->prepare($sql);
$stmt->execute(array('code' => $code));
$users_choices_director = $stmt->fetchAll();

//Récupération de l'e-mail des utilisateurs connectés à la salle
$sql = "SELECT utilisateur.id_us, utilisateur.mail
        FROM acceder, utilisateur
        WHERE acceder.code = :code
        AND acceder.id_us = utilisateur.id_us";
$stmt = $bdd->prepare($sql);
$stmt->execute(array('code' => $code));
$users_email = $stmt->fetchAll();

if ($users_choices_genre && $users_choices_cast && $users_choices_director) {
    // Affichage des choix de l'utilisateur
    echo '<div class="container">';
    echo '<p class="prem">Choix des utilisateurs qui ont rejoint votre salle:</p>';
    $image_counter = 1; // initialize the image counter variable
    foreach ($users_email as $user) {
        // Affichage de l'utilisateur et des choix
        echo '<div class="row mb-3"><div class="col-md-2"><img src="../images/user'.$image_counter.'.png" alt="IMG" title="User'.$image_counter.'" width="50%"></div>';
        echo '<div class="col-md-8"><div class="row"><div class="col-md-4"><p class="prem">Utilisateur: ' . $user['id_us'] . ' - ' . $user['mail'] . '</p></div>';
        foreach ($users_choices_genre as $choice) {
            if ($choice['id_us'] == $user['id_us']) {
                echo '<div class="col-md-4"><p class="prem">Genres: ' . $choice['genre'] . '</p></div>';
            }
        }
        echo '<div class="col-md-4"><p class="prem">Acteurs: ';
        foreach ($users_choices_cast as $choice_cast) {
            if ($choice_cast['id_us'] == $user['id_us']) {
                echo $choice_cast['cast'] . ', ';
            }
        }
        echo '</p></div><div class="col-md-4"><p class="prem">Réalisateurs: ';
        foreach ($users_choices_director as $choice_director) {
            if ($choice_director['id_us'] == $user['id_us']) {
                echo $choice_director['director'] . ', ';
            }
        }
        echo '</p></div></div></div></div>';
        $image_counter++; // increment the image counter variable for the next user
    }
    echo '</div>';
} else {
    echo 'Aucun choix d\'utilisateur n\'a été trouvé.';
}
?>
</body>
</html>