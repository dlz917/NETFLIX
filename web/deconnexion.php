﻿<?php
session_start(); // Démarre la session en cours
session_destroy(); // Détruit toutes les données de la session
header("Location: index.php"); // Redirige l'utilisateur vers la page d'accueil
exit; // Met fin au script
?>